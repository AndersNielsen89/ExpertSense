<?php

$username = "sharemybike_dk";
$password = "c26gxrkh";
$hostname = "mysql23.unoeuro.com"; 
$database = "sharemybike_dk_db";

/*
$username = "root";
$password = "";
$hostname = "localhost"; 
$database = "expert_search";
*/

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
or die("Unable to connect to MySQL");
$selected = mysql_select_db($database,$dbhandle);



$result = mysql_query("SELECT query FROM totalQueries order by query");
  //fetch tha data from the database
  $indexCounter = 0;
  while ($row = mysql_fetch_array($result)) {
    echo "<li>";
    echo "<a value=\"" . $indexCounter . "\" onclick=\"updateExpertRow(this.text)\" href=\"#\">" . $row{'query'} . "</a>";
    echo "</li>";
  }


mysql_close($dbhandle);

  ?>