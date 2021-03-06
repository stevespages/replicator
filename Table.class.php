<?php
/* 
 * models/Table.class.php
 *
 * This class should be a cross application parent class for providing a useful PDO tool for interacting with databases.
 *
 *	Classes extending this class should be made for application specific PDO transactions with databases.
 *
 * One extension of this class should be made for each (major?) table in the database if it is necessary.
 * 
 * The class requires a PDO object as an argument ($db) when instantiating.
 *
 * The constructor function assigns the PDO object to the protected property, Table->dbObj referred to as $this->dbObj in the definition.
 */
 
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
