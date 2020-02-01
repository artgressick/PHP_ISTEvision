<?php # Script 1.0 - insert channel

if (isset($_POST['name'])) {
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	include('../includes/_lib.php');
	
	session_start(); //Start the session.
		
	//make a sha1 string for the customer linking
	$cid = sha1(uniqid(mt_rand(1000000,9999999).iste.time(), true));
		
	$query = "INSERT INTO channels SET
		name = '".encode($_POST['name'])."',
		homepage = '".$_POST['homepage']."',
		uploadable = '".$_POST['uploadable']."',
		visible = '".$_POST['visible']."',
		display_order = '".$_POST['display_order']."',
		administrator_id = '".$_SESSION['admin_id']."',
		cid = '".$cid."'";
			
		$query2 = $query;
	
		$result = @mysql_query ($query); //Run the query.
	
		//redirect the user to the homepage now.
		header ('Location: channels.php');
		exit();
		

		mysql_close(); //close the connection
} //end the statement and redirect if we went this far.
?>