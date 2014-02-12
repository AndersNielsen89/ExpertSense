<?php
$sessionId = strval($_GET['id']);

echo "./".$sessionId.".txt";
echo "<br />";
$filename =  $sessionId . ".txt";

	$file = file_get_contents($filename, true);
	var_dump($file);



echo "<br />";
?>