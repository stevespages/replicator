<?php

include_once 'replicators.php';
include_once '../functions.php';

If ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$i = $_GET['i'] + 1;
	$new_replicator_name = 'replicator_form_array_'.$i;
	$$new_replicator_name = assignPostToFormArray($replicator_form_array_0);
	$$new_replicator_name = validateFormArray($$new_replicator_name);
	$is_form_valid = isFormValid($$new_replicator_name);
	if($is_form_valid)
	{
		$file = 'replicators.php';
		file_put_contents($file,
		'$replicator_form_array_'.$i.' = array (
				"replicator" => array ( 
						"name" => "replicator",
						"required" => "",
						"value" => "",
						"error_mssg" => "",
						"form_label" => "ask",
						"type" => "text",
						"validate" => ""
						),
		);$i='.$i.';', FILE_APPEND); // probably should be FILE_APPEND | LOCK_EX
	}
	header('Location: index.php');
}

$action = 'index.php?i='.$i;
$display = "";
$j = 0;
while ($j < $i + 1)
{
	$name = 'replicator_form_array_'.$j;
	$display .= showForm($action, $$name);
	$j = $j + 1;
}
echo $display;
