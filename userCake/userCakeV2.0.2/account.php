<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
include 'header.php';

echo "
<body>

<div id='wrapper'>";

include('expertHeader.php');

echo "

<div id='content'>
<div id='left-nav'>";

include("left-nav.php");

echo "
</div>
<div id='main'>
Hey, $loggedInUser->displayname. 
<div>
This page allows you to perform actions related to your account. ";

if ($loggedInUser->checkPermission(array(2)) || $loggedInUser->checkPermission(array(4))){
echo "
<br /> Admin users are also allowed to perform actions related to the users of the site.";
};

echo "
<br /> You registered this account on " . date("M d, Y", $loggedInUser->signupTimeStamp()) . ".
</div>
</div>
<div id='bottom'></div>
</div>
</body>
</html>";

?>
