<?php
	session_start(); //Start the session.
	//If no session is present then redirec the user.
	
	if (!isset($_SESSION['admin_id'])) {
		header ("Location: login.php");
		exit(); //Quit the script.
	}
?>