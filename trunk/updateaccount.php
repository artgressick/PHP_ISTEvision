<?php # Script 1.0 - Update Profile

// This page will gather all of the information from the previous page and enter it into the database.
include('includes/security.php');

include('includes/_lib.php');

//Check the posting of the page to make sure is was not by-passed
if (isset($_POST['add'])) {
	
	if ($_POST['first_name'] == "" || $_POST['last_name'] == "" || $_POST['email'] == "") {
		header ("Location: errorform.php"); //throw an error
		exit();
	}	
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//Make the query
	$query = "UPDATE customers SET
		first_name = '".encode($_POST['first_name'])."',
		last_name = '".encode($_POST['last_name'])."',
		job_title = '".encode($_POST['job_title'])."',
		affiliation = '".encode($_POST['affiliation'])."',
		address = '".encode($_POST['address'])."',
		city = '".encode($_POST['city'])."',
		state = '".encode($_POST['state'])."',
		zip = '".encode($_POST['zip'])."',
		country = '".encode($_POST['country'])."',
		work_phone = '".encode($_POST['work_phone'])."',
		home_phone = '".encode($_POST['home_phone'])."',
		cell_phone = '".encode($_POST['cell_phone'])."',
		fax = '".encode($_POST['fax'])."',
		ning_url = '".encode($_POST['ning_url'])."',
		alt_email = '".encode($_POST['alt_email'])."',
		state = '".encode($_POST['state'])."',
		student_status = '".$_POST['student_status']."',
		updated_at = '".date('Y-m-d H:i:s')."'";	
	
	
	//we need to check and make sure that they didn't change their email address.
	if ($_POST['org_email'] == $_POST['email']) {
		//do nothing email didn't change
		
	} else {
		//we need to check the DB and see if there is already and account with that information.
		$query2 = "SELECT email from customers where email = '".$_POST['email']."'";
		
		$result2 = @mysql_query ($query2); //Run the query.
		$counter = mysql_num_rows($result2); //get a count

		if ($counter > 0) {
			//there is someone with an email address already
			header ('Location: errorform.php');
			exit();

		} else {
			//change the email address
			$query .= ", email = '".$_POST['email']."'";
			$flag = 1;
		}
	}
	
	if ($_POST['password'] != '') {
		$query .= ", password = '".sha1($_POST['password'])."'";
	}	
		
	//finish the query	
	$query .= " WHERE id = ".$_SESSION['id'];
		
	$result = @mysql_query ($query); //Run the query.
		
	if ($result) {
		//redirect the user to the homepage now.
		header ('Location: index.php');
		exit();
			
	} else { //No match was made
		header ("Location: errorform.php"); //throw an error
		exit();
	}

	mysql_close(); //close the connection
	
} //end the statement and redirect if we went this far.
?>