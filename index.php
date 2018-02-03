<?php



// primary keys are the values of the name attributes of the form input elements...
// ... and the names of the corresponding columns in a MySQL (or other) table.
// Most but not necessarily all the secondary keys are required to avoid an 'undefined index' error.
// Implement radio controlls
// Implement a generic solution for attributes of html elements no matter what they are called
$snippet_form_array = array ( 
			"replicator" => array (
						"name" => "replicator",
						"required" => "required",
						"value" => "",
						"error_mssg" => "",
						"form_label" => "ask",
						"type" => "text",
						"validate" => "unique"
						),
);

$snippet_form_array_2 = array ( 
			"replicator" => array (
						"name" => "replicator",
						"required" => "required",
						"value" => "",
						"error_mssg" => "",
						"form_label" => "ask_2",
						"type" => "text",
						"validate" => "unique"
						),
);

include_once "helper-code.php";
