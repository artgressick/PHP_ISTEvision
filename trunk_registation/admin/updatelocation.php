<?php # Script 1.0

	include('includes/security.php');

	if (isset($_POST['name'])) {

		//Register the user in the database
		require_once ('istetube-conf.php'); //Map the Connection.
		include('../_lib.php');
		
		$query = "update lounge_locations SET
			name = '".encode($_POST['name'])."'
			WHERE lid = '".$_POST['lid']."'";
			
		$result = @mysql_query ($query); //Run the query.
	
		//redirect the user
		header ('Location: locations.php');
		exit();
		
		mysql_close(); //close the connection		
	} else {
	
		//redirect the user to the homepage now.
		header ('Location: error.php');
		exit();
		
	}
?>