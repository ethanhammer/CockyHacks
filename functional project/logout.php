<?php

session_start();

//kills current session
if(isset($_SESSION['userid'])) {
	$_SESSION['userid'] = NULL;
	unset($_SESSION['userid']);
}

header("Location: login.php");
die;