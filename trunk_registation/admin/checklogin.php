<?php # Script 1.0 - checklogon.php	// This page will check the database for the staffer. If they choose to save the information then	// we will create a cookie to save the email address.		//Check the posting of the page to make sure is was not by-passed	if (isset($_POST['login'])) {				//Register the user in the database		require_once ('istetube-conf.php'); //Map the Connection.				//first check to make sure there isn't already an account created with that email address.		$query = "SELECT id			FROM administrators 			WHERE email = '".$_POST['email']."'			AND password = '".sha1($_POST['password'])."'";				$result = @mysql_query ($query); //Run the query.				if ($result) {						$account_verification = mysql_fetch_array ($result, MYSQL_ASSOC);						session_start(); //Start the session.			$_SESSION['admin_id'] = $account_verification['id'];							header ("Location: index.php");			exit();		} else {			header ("Location: error.php");			exit();				}	}	header ("Location: error.php");?>query - <?= $query ?> <br />ID - <?= $account_verification['id'] ?><br />Session_ID - <?= $_SESSION['admin_id'] ?><br />password - <?= $account_verification['password'] ?><br />flag - <?= $flag ?>