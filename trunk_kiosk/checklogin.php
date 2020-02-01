<?php # Script 1.0 - checklogon.php

	// This page will check the database for the staffer. If they choose to save the information then
	// we will create a cookie to save the email address.
	
	//Check the posting of the page to make sure is was not by-passed
	if (isset($_POST['email'])) {
		
		//Register the user in the database
		require_once ('istetube-conf.php'); //Map the Connection.
		
		//first check to make sure there isn't already an account created with that email address.
		$query = "SELECT id, password, customer_status_id, first_name, last_name
			FROM customers 
			WHERE email = '".$_POST['email']."'
			AND password = '".sha1($_POST['password'])."'";
		
		$result = @mysql_query ($query); //Run the query.
		$counter = mysql_num_rows($result);
		
		if ($counter > 0) {
			
			$account_verification = mysql_fetch_array ($result, MYSQL_ASSOC);
			
			session_start(); //Start the session.
			$_SESSION['user_id'] = $account_verification['id'];
			$_SESSION['first_name'] = $account_verification['first_name'];
			$_SESSION['last_name'] = $account_verification['last_name'];
			
			header ("Location: prompt.php");
			exit();
			
			
		} else {
			
			header ("Location: error-noaccount.php");
			exit();
		
		}
		
	}
	header ("Location: error-form.php");
?>