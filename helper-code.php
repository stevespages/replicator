<?php




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

If ($_SERVER['REQUEST_METHOD'] == 'POST')	{
	
	$i = $_GET['i'] + 1;
	
	$snippet_form_array = '$snippet_form_array_'.$i.' = array("replicator" => array (
						"name" => "replicator",
						"required" => "",
						"value" => "",
						"error_mssg" => "",
						"form_label" => "ask_2",
						"type" => "text",
						"validate" => ""
						));';
	$j=0;
while($j<$i+1)
{
	$name = 'snippet_form_array_'.$j;
	$display[] = $$name;
	$j=$j+1;
}
}

If ($_SERVER['REQUEST_METHOD'] != 'POST')	{
$i=0;
$action = 'index.php?i='.$i;
$snippet_form = showForm($action, $snippet_form_array_0);
$display = $snippet_form;
}


echo '<!DOCTYPE html><html><head><meta charset="utf-8" /><title></title></head>';
//echo '<p>'.$row.'</p>';
echo $display.'</br>'.$i;
//echo '</br>'.$snippet_table.'</br>';
echo '<body></body></html>';