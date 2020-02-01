<?php # Script 1.0

	include('includes/security.php');

	if (isset($_POST['name'])) {

		//Register the user in the database
		require_once ('istetube-conf.php'); //Map the Connection.
		include('../_lib.php');
		
		//make a sha1 string for the customer linking
		$lid = sha1(uniqid(mt_rand(1000000,9999999).iste.time(), true));
		
		$query = "INSERT INTO lounge_locations SET
			lid = '".$lid."',
			name = '".encode($_POST['name'])."'";
			
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