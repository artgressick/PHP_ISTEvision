<?
	session_start(); //Start the session.
	//If no session is present then redirect the user.
	
	if (!isset($_SESSION['id'])) {
		header ("Location: login.php");
		exit(); //Quit the script.
	}
?>