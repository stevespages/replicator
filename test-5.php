<?php

include_once 'replicators.php';

function showForm($action, $form_array)	{
	$form = "<form method='post' action=".$action.">";
	$form .= "<input type='submit' value='replicator'></form></br>";
	return $form;
}

$action = 'index.php';
$i = 1;
$j = 0;
while($j<$i+1)
{
	$x = 'replicator_'.$j;
	echo showForm($action, $$x);
	$j = $j + 1;
}
