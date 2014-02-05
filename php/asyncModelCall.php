<?php

$disease = strval($_GET['date']);
$method = strval($_GET['articles']);
$sessionId = strval($_GET['id']);
echo $disease;
echo "<br />";
echo $method;
echo "<br />";
echo $sessionId;
echo "<br />";
// This is the data you want to pass to Python
$data = $sessionId;
// Execute the python script with the JSON data
$result = shell_exec('python Model_async.py ' . escapeshellarg(json_encode($data)));

// Decode the result
$resultData = json_decode($result, true);
//echo $resultData;

// This will contain: array('status' => 'Yes!')
//var_dump($resultData);

?>
