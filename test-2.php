<?php



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


include_once 'helper-code.php';

$j=0;
while($j<$i+1)
{
	$name = 'snippet_form_array_'.$j;
	$display[] = showForm($action, $$name);
	//$display[] = $$name;
	$j=$j+1;
}

var_dump($display);