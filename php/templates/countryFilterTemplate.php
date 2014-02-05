<?php

$totalFilter = $filter_title . "</br>";
	foreach ($filter_checkboxes as $filter_checkbox_value => $filter_checkbox_key){
		$totalFilter = $totalFilter . "<input type=\"checkbox\" name=\"country\" value=\"" . $filter_checkbox_value . "\">  " . $filter_checkbox_value  ." </br>";
	}
	
$totalFilter =  $totalFilter . "";

return $totalFilter;
?>