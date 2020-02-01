<?php # Script 1.0 - update the approved videos

	include('includes/security.php');
	include('../includes/_lib.php');
	
	//Check the posting of the page to make sure is was not by-passed
	if (isset($_POST['name'])) {
		
		require_once ('istetube-conf.php'); //Map the Connection.
	
		$sql_query = "UPDATE channels SET
			homepage = ". $_POST['homepage'] .",
			uploadable = ". $_POST['uploadable'] .",
			visible = ". $_POST['visible'] .",
			name = '". encode($_POST['name']) ."',
			display_order = '". $_POST['display_order'] ."'
			WHERE cid = '". $_POST['cid'] ."'";
		$result = @mysql_query ($sql_query); //Run the query.
		
		header ("Location: channels.php");
		
	} else {
		
		header ("Location: error.php");
		
	}
?>