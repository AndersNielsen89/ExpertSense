<?php

$totalFilter = $filter_title . "</br><form>";
	foreach ($filter_checkboxes as $filter_checkbox_value => $filter_checkbox_key){
		
		$totalFilter = $totalFilter . "<input type=\"checkbox\" name=\"" . $filter_title . "\" value=\"" . $filter_checkbox_key . "\">  " . $filter_checkbox_key  . "</br>";
	}
	
$totalFilter =  $totalFilter . "</form>";

return $totalFilter;
?>