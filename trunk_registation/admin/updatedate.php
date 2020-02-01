<?php # Script 1.0

	include('includes/security.php');

	if (isset($_POST['date'])) {

		//Register the user in the database
		require_once ('istetube-conf.php'); //Map the Connection.
		include('../_lib.php');
		
		$query = "update lounge_dates SET
			date = '".date('Y-m-d',strtotime($_POST['date']))."',
			begin_time = '". date('H:i:00.0',strtotime($_POST['begin_time'])) ."',
			end_time = '". date('H:i:00.0',strtotime($_POST['end_time'])) ."'
			WHERE did = '".$_POST['did']."'";
			
		$result = @mysql_query ($query); //Run the query.
	
		//redirect the user
		header ('Location: dates.php');
		exit();
		
		mysql_close(); //close the connection		
	} else {
	
		//redirect the user to the homepage now.
		header ('Location: error.php');
		exit();
		
	}
?>