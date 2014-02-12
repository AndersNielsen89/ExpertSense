<?php
	require_once("models/config.php");

	if(isUserLoggedIn()) {
		echo "
		<ul class=loginHeader>
			<li class=loginElement><a href='account.php'>My account</a></li>
			<li class=loginElement><a href='logout.php'>Log out</a></li>
		</ul>
		";
	} 
//Links for users not logged in
else {
	echo "
		<ul class=loginHeader>
			<li class=loginElement><a href='login.php'>Login</a></li>
			<li class=loginElement><a href='register.php'>Request Access</a></li>
		</ul>
	";
}

?>