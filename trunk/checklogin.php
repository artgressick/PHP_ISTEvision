<?php # Script 1.0 - checklogon.php

	// This page will check the database for the staffer. If they choose to save the information then
	// we will create a cookie to save the email address.
	
	//Check the posting of the page to make sure is was not by-passed
	if (isset($_POST['login'])) {
		
		//Register the user in the database
		require_once ('istetube-conf.php'); //Map the Connection.
		
		//first check to make sure there isn't already an account created with that email address.
		$query = "SELECT id, password, customer_status_id
			FROM customers 
			WHERE email = '".$_POST['email']."'
			AND password = '".sha1($_POST['password'])."'";
		
		$result = @mysql_query ($query); //Run the query.
		
		if ($result) {
			
			$account_verification = mysql_fetch_array ($result, MYSQL_ASSOC);
			
			if ($account_verification['customer_status_id'] == 1) {
				
				header ("Location: erroraccountblocked.php");
				exit();
				
			} else {
				
				session_start(); //Start the session.
				$_SESSION['id'] = $account_verification['id'];
				
				//We want to run a script to change over the views just incase they were browsing the site and then they logged in.
				//This will take the SESSION_ID() from apache and update them with the $_SESSION['id'] information.
				$sql_query = "UPDATE views SET
					customer_id = '".$account_verification['id']."'
					WHERE session_id = '".session_id()."'";
					
				$result = @mysql_query ($sql_query); //Run the query.
				// ------------ DONE --------------
				
				header ("Location: myvideos.php");
				exit();
			}
			
		} else {
			
			header ("Location: error.php");
			exit();
		
		}
		
	}
	header ("Location: error.php");
?>

query - <?= $query ?> <br />
ID - <?= $account_verification['id'] ?><br />
Session_ID - <?= $_SESSION['id'] ?><br />
password - <?= $account_verification['password'] ?><br />
flag - <?= $flag ?>