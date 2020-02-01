<?php # Script 1.0 - insert account

//Check the posting of the page to make sure is was not by-passed
if ($_REQUEST['aid'] == "") {
	
	//nothing was sent into the page
	//header ('Location: errorconfirmation.php');
	//exit();
	
} else {
	
	//connect to the DB
	require_once ('istetube-conf.php'); //Map the Connection.
		
	//first check to make sure there isn't already an account created with that email address.
	$query = "SELECT id, customer_status_id from customers where aid = '".$_REQUEST['aid']."'";
		
	$result = @mysql_query ($query); //Run the query.
	$account_verification = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	if ($account_verification['customer_status_id'] == '1') {
		//update the
		$query = "UPDATE customers 
			SET customer_status_id  = 2
			WHERE aid = '".$_REQUEST['aid']."'";
			
		$result = @mysql_query ($query); //Run the query.
		
		header ('Location: thanksconfirmation.php');
		exit();
		
	} else {
		
		header ('Location: errorconfirmation.php');
		exit();
		
	}
} //end the statement and redirect if we went this far.
?>
request variable = <?= $_REQUEST['aid']; ?>