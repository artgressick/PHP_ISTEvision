<?
	//Log off script
	
	session_start(); //Start the session.
	
	//remove the session id to log them out.
	unset($_SESSION['admin_id']);
	
	//now redirect to the homepage
	header ("Location: index.php");
?>