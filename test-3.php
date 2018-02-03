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


$i = 1;
$action = 'index.php?i='.$i;

$snippet_form_array_0 = array ( 
			"replicator" => array (
						"name" => "replicator",
						"required" => "",
						"value" => "",
						"error_mssg" => "",
						"form_label" => "ask",
						"type" => "text",
						"validate" => ""
						),
);

$snippet_form_array_1 = array ( 
			"replicator" => array (
						"name" => "replicator",
						"required" => "",
						"value" => "",
						"error_mssg" => "",
						"form_label" => "ask_2",
						"type" => "text",
						"validate" => ""
						),
);

$name = $snippet_form_array_0;

var_dump($snippet_form_array_0);

echo '</br>';

echo $$name;

//$f = showForm($action, $$name);
//echo $f;

/*
$j=0;
while($j<$i+1)
{
	$name = 'snippet_form_array_'.$j;
	$display[] = showForm($action, $$name);
	//$display[] = $$name;
	$j=$j+1;
}

var_dump($display);
*/