<?php


// Dev
$host = '127.0.0.1';
$db   = 'snippets';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$user = 'root';
$pass = '';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];


/*
// Prod
$host = 'db722336839.db.1and1.com';
$db   = 'db722336839';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$user = 'dbo722336839';
$pass = '12345678';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
*/

$db = new PDO($dsn, $user, $pass, $opt);


class Table {
  

   protected $db;


   public function __construct ( $db ) {
        $this->db = $db;
   }


   protected function makeStatement ($sql) {
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement;
   }
    
    
   public function getAll($table_name) {
   	
   	$sql = "SELECT * FROM $table_name";

		$statement = $this->makeStatement($sql);
	
   	return $statement;

	}
	
	
	public function deleteRow($table_name, $id) {

		$sql = "DELETE FROM $table_name WHERE id = $id";
		
		$statement = $this->makeStatement($sql);
		
		return $statement;
	}
	
	
	public function getRowToEdit($table_name, $id) {

		$sql = "SELECT * FROM $table_name WHERE id = $id";
		
		$statement = $this->makeStatement($sql);
		
		return $statement;
	}
	
	
	public function save($table_name, $form_array) {
		
		$fields = "";
		$values = "'";
		foreach($form_array as $key => $array) {
			$fields .= $key.", ";
			$values .= $array['value']."', '";
		}
		
		//get rid of the trailing comma and space
		$fields = substr($fields, 0, -2);
		$values = substr($values, 0, -3);
		
		$sql = "INSERT INTO $table_name ($fields) VALUES ($values)";
		
		$this->makeStatement($sql);
		
		return $sql;
	
	}
	
	
/*
	public function save($table_name, $form_array) {
		
		$stmt = $dbh->prepare("INSERT INTO REGISTRY (name, value) VALUES (?, ?)");
		$stmt->bindParam(1, $name);
		$stmt->bindParam(2, $value);		
		
		
		
		$fields = "";
		$values = "'";
		foreach($form_array as $key => $array) {
			$fields .= $key.", ";
			$values .= $array['value']."', '";
		}
		
		//get rid of the trailing comma and space
		$fields = substr($fields, 0, -2);
		$values = substr($values, 0, -3);
		
		$sql = "INSERT INTO $table_name ($fields) VALUES ($values)";
		
		$this->makeStatement($sql);
		
		return $sql;
	
	}	
*/
	
	
	public function updateRow($table_name, $form_array, $id) {
		
		$field_value = "";
		foreach($form_array as $key => $array) {
			$field_value .= $key;
			$field_value .= " = '";
			$field_value .= $array['value'];
			$field_value .= "', ";
		}
		// get rid of the trailing comma
		$field_value = substr($field_value, 0, -2);
		
		$sql = "UPDATE $table_name SET $field_value WHERE id = $id";
		
		$statement = $this->makeStatement($sql);
		
		//return $sql; // for debugging
	}
}


function assignPostToFormArray($form_array)
{
	foreach($form_array as $key => $array)
	{
		$form_array[$key]['value'] = htmlentities($_POST[$form_array[$key]['name']]);
	}
	return $form_array;
}

// $db and $table_name arguments are only required if using a validation test which requires access to the database.
// A test needs to recognise 
function validateFormArray($form_array, $db=null, $table_name=null)
{
	
	foreach($form_array as $key => $array)
	{
		// from Symfony documentation web site
		if($form_array[$key]['validate']=='not_blank')
		{
			if(false === $form_array[$key]['value'] || (empty($form_array[$key]['value']) && '0' != $form_array[$key]['value']))
			{
				$form_array[$key]['error_mssg'] .= 'This field can not be empty';
			}
		}
		if($form_array[$key]['validate']=='FILTER_VALIDATE_EMAIL')
		{
			if (!filter_var($form_array[$key]['value'], FILTER_VALIDATE_EMAIL))
			{
    			$form_array[$key]['error_mssg'] .= "Please enter a valid email address";
			}	
		}
		// the test for !isset($_GET['id']) ensures this validation is not carried out when editing a row...
		// ... because they may want to leave the value unaltered in the unique column and change a different column.
		if($form_array[$key]['validate']=='unique' AND !isset($_GET['id']))
		{
			$column  = $form_array[$key]['name'];
			$sql = ("SELECT * FROM $table_name WHERE $column = ?");
			$stmt = $db->prepare($sql);
			$stmt->execute([$form_array[$key]['value']]);
			$row = $stmt->fetchObject();
			if($row !=  null)
			{
				$form_array[$key]['error_mssg'] .= 'That is already in the database. Please use another value';
			}
		}
	}
	
	return $form_array;
}


function isFormValid($form_array)
{
	$is_form_valid = true;
	foreach($form_array as $key => $array)
	{
		if($form_array[$key]['error_mssg'] != "")
		{
			$is_form_valid = false;
		}
	}
	return $is_form_valid;
}


function showForm($action, $form_array)	{
	$form = "<form method='post' action=".$action.">";
	foreach($form_array as $key => $value) {
		$form .= "<p><label>".$form_array[$key]['form_label'];
		if($form_array[$key]['type']=='select') {
			$form .= " <select name='".$form_array[$key]['name']."'>";
			foreach($form_array[$key]['options'] as $key_2 => $value_2) {
				$form .= "<option value=".$key_2.">".$value_2."</option>";
			}
			$form .= "</select";
		} else {
			
			/*
			$form .= " <input name='".$form_array[$key]['name']
				."' type='".$form_array[$key]['type']
				."' value='".$form_array[$key]['value']
				."'";
			*/
			
			$form .= ' <input name="'.$form_array[$key]["name"]
				.'" type="'.$form_array[$key]["type"]
				.'" value="'.$form_array[$key]["value"]
				.'"';
				
			if($form_array[$key]['required']=='required') {
				$form .=" required";
			}				
		}
	$form .=	"></label> ".$form_array[$key]['error_mssg']."</p>";
	}
	$form .= "<input type='submit'> <a href='index.php'> Cancel </a></form></br>";
	return $form;
}


function replicateForm($action, $form_array)	{
	$form = "<form method='post' action=".$action.">";
	foreach($form_array as $key => $value) {
		$form .= "<p><label>".$form_array[$key]['form_label'];
		if($form_array[$key]['type']=='select') {
			$form .= " <select name='".$form_array[$key]['name']."'>";
			foreach($form_array[$key]['options'] as $key_2 => $value_2) {
				$form .= "<option value=".$key_2.">".$value_2."</option>";
			}
			$form .= "</select";
		} else {
			
			/*
			$form .= " <input name='".$form_array[$key]['name']
				."' type='".$form_array[$key]['type']
				."' value='".$form_array[$key]['value']
				."'";
			*/
			
			$form .= ' <input name="'.$form_array[$key]["name"]
				.'" type="'.$form_array[$key]["type"]
				.'" value="'.$form_array[$key]["value"]
				.'"';
				
			if($form_array[$key]['required']=='required') {
				$form .=" required";
			}				
		}
	$form .=	"></label> ".$form_array[$key]['error_mssg']."</p>";
	}
	$form .= "<input type='submit'> <a href='index.php'> Cancel </a></form></br>";
	return $form;
}


// pasted in from index.php
function showSnippets($statement, $editable) {
	$snippets = "<div><table border=1>";
	while ( $row = $statement->fetchObject() ) {
		$snippets .= "<tr><td><b>".$row->snippet."</b></td><td>".$row->description."</td><td>".$row->language."</td>";
		if($editable) {
			$snippets .= "<td><a href='index.php?pg=edit&id=".$row->id."'>Edit?</a></td>";
			$snippets .= "<td><a href='index.php?pg=delete&id=".$row->id."'>Delete?</a></td>";
		}
		$snippets .= "</tr>";
	}
	$snippets .= "</table>";
	return $snippets;
}

function createTable($statement, $editable=null)
{
	$table = "<div><table border=1>";
	while($row = $statement->fetchObject())
	{
		$table .= "<tr>";
		foreach($row as $key => $value)
		{
			$table .= "<td>".$value."</td>";
		}
		if($editable) {
			$table .= "<td><a href='index.php?pg=edit&id=".$row->id."'>Edit?</a></td>";
			$table .= "<td><a href='index.php?pg=delete&id=".$row->id."'>Delete?</a></td>";
		}
		$table .= "</tr>";
	}
	$table .= "</table></div>";
	return $table;
}

//$db = new PDO("mysql:host=localhost;dbname=snippets;charset=utf8mb4", "root", "");// now in config.php
$table = new Table($db);
$action = "index.php";
If (isset($_GET['id'])) {
		$id = htmlentities($_GET['id']); // this is necessary for editing and deleting a particular row
}

If ($_SERVER['REQUEST_METHOD'] == 'POST')	{
	$snippet_form_array = assignPostToFormArray($snippet_form_array);
	$snippet_form_array = validateFormArray($snippet_form_array, $db, 'snip');
	$is_form_valid = isFormValid($snippet_form_array);

	
	if($is_form_valid === true AND !isset($_GET['id'])) {
		$table->save('snip', $snippet_form_array); // saves post as a new row
	}
	
	// $_GET['id'] is set because the value of the form's action attribute was set...
	// ...to ?id=.$id when the form was generated from clicking on the Edit hyperlink
	if($is_form_valid === true AND isset($_GET['id'])) {
		$table->updateRow('snip', $snippet_form_array, $id);  // updates a row from an edited post
	}
	
	// if $is_form_valid does not === true then $form_array needs to be passed to showForm() with...
	// ...its values and error messages intact.
	// if $is_form_valid === true then the job has been done and we need to refresh the page for a new start.
	if($is_form_valid === true) {
		header('Location: index.php');
	}
}

If ($_SERVER['REQUEST_METHOD'] != 'POST' AND isset($_GET['id']))	{

			if($_GET['pg']=='edit') {
				$action .= "?id=".$id;
				$statement = $table->getRowToEdit('snip', $id); // gets a row to be edited using id of the row
				$row = $statement->fetchObject();
				
				foreach($snippet_form_array as $key => $array) {
					$snippet_form_array[$key]['value'] = $row->$key;
				}			
			}
			if($_GET['pg']=='delete') {
				$table->deleteRow('snip', $id); // deletes a row using id of the row
			header('Location: index.php');
			}
}

$snippet_form = replicateForm($action, $snippet_form_array);
$snippet_form_2 = replicateForm($action, $snippet_form_array_2);
$statement = $table->getAll('snip');
//$editable = true; // this is an optional argument for createTable() so the displayed info will be editable or not.
//$snippets = showSnippets($statement, $editable);
$snippet_table = createTable($statement, false);

//var_dump($row);

echo '<!DOCTYPE html><html><head><meta charset="utf-8" /><title></title></head>';
//echo '<p>'.$row.'</p>';
echo $snippet_form.'</br>'.$snippet_form_2;
//echo '</br>'.$snippet_table.'</br>';
echo '<body></body></html>';