<?php
function autoComplete(){
$username = "sharemybike_dk";
$password = "c26gxrkh";
$hostname = "mysql23.unoeuro.com"; 
$database = "sharemybike_dk_db";

$dbhandle = mysql_connect($hostname, $username, $password) 
or die("Unable to connect to MySQL");
$selected = mysql_select_db($database,$dbhandle);

$result = mysql_query("SELECT query FROM totalQueries");
//$row = mysql_fetch_array($result);
//$vals = var_dump($row);
$vals = "";
 while ($row = mysql_fetch_array($result)) {
	//echo $row{'query'};
	$vals = $vals . $row{'query'} . ",";
 	}
echo $vals;
//echo "<input type=\"hidden\" id=\"hiddenTags\" value=\"" . $vals . "\">";
mysql_close($dbhandle);
return $row;
}

$phpTags = autoComplete();
?>