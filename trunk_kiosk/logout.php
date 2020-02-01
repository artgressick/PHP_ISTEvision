<?php
	//start a session
	session_start(); //Start the session.

	$_SESSION['user_id'] = '';
	$_SESSION['first_name'] = '';
	$_SESSION['last_name'] = '';
	$_SESSION['videofile'] = '';
	
	header ("Location: index.php");
?>