<?php # Script 1.0 - update the approved videos

	include('includes/security.php');
	include('../includes/_lib.php');
	
	//Check the posting of the page to make sure is was not by-passed
	if (isset($_POST['first_name'])) {
		
		require_once ('istetube-conf.php'); //Map the Connection.
	
		$sql_query = "UPDATE administrators SET
			first_name = '". encode($_POST['first_name']) ."',
			last_name = '". encode($_POST['last_name']) ."',
			super = '". $_POST['super'] ."'";
		//check to see if they entered a new password
		if ($_POST['password'] != "") {
			$sql_query .= ", password = '".sha1($_POST['password'])."' ";
		}
		
		$sql_query .= " WHERE id = '". $_POST['id'] ."'";
		
		$result = @mysql_query ($sql_query); //Run the query.
		
		//add in the channels
		$sql_query = "SELECT id
		FROM channels
		ORDER BY display_order";
		
		$channel_result = @mysql_query ($sql_query); //Run the query.
		
		//Remove the existing channels and then Cycle through the channels and add them to the table.
		$remove_query = "DELETE FROM admin_channels where administrator_id = ".$_POST['id'];
		$result = @mysql_query ($remove_query); //Run the query.
		
		$insert_query = "INSERT INTO admin_channels (administrator_id, channel_id) VALUES (";
		
		$error_checker = 0;

		while ($channels = mysql_fetch_array ($channel_result, MYSQL_ASSOC)) {
			$channel_id = $channels['id'];

			if ($_POST[$channels['id']] > 0) {
				$insert_query .= $_POST['id'].",".$channels['id']."),(";
				
				$error_checker = 1;
			}
		}
		
		$insert_query = substr($insert_query, 0, -2);  // hack off the last 2 items
		
		if ($error_checker == 1) { //Dont run the insert command unless they checked something.
			$result = @mysql_query ($insert_query); //Run the query.
		}

		
		header ("Location: users.php");
		
	} else {
		
		header ("Location: error.php");
		
	}
?>