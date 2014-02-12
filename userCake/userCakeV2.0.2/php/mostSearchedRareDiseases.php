<?php
$username = "sharemybike_dk";
$password = "c26gxrkh";
$hostname = "mysql23.unoeuro.com"; 
$database = "sharemybike_dk_db";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
or die("Unable to connect to MySQL");
$selected = mysql_select_db($database,$dbhandle);

$most_searchedd_database_result = mysql_query("SELECT totalQueries.query from totalQueries INNER JOIN mostSearchedRareDiseases ON mostSearchedRareDiseases.rareDiseaseId = totalQueries.id ORDER BY mostSearchedRareDiseases.searchNumber DESC LIMIT 0,5");
$most_searched_result_array = array();
while ($most_searched_row = mysql_fetch_array($most_searchedd_database_result)) {
	$most_searched_row_html_encoded = str_replace(' ', '%20', $most_searched_row{'query'});
	$most_searched_element = '<div class="mostSearchedResult"><a href=searchResult.php?disease_chosen=' . $most_searched_row_html_encoded . '>' . $most_searched_row{'query'} . '</a> </div>';
	array_push($most_searched_result_array, $most_searched_element);
 	//echo $mostSearchedRow{'query'};
 	//searchResult.php?disease_chosen=Acute%20Intermittent%20Porphyria
 }

?>