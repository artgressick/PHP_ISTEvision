<?php # Script 1.0 - update the approved videos

	include('includes/security.php');
	include('../includes/_lib.php');
	
	// This page will check the database for the staffer. If they choose to save the information then
	// we will create a cookie to save the email address.

	//Check the posting of the page to make sure is was not by-passed
	if (isset($_POST['update'])) {
		
		require_once ('istetube-conf.php'); //Map the Connection.
	
		//
		$sql_query = "UPDATE customers SET
			customer_status_id = ". $_POST['customer_status_id'] ."
			WHERE aid = '". $_POST['aid'] ."'";
		$result = @mysql_query ($sql_query); //Run the query.
		
		$query3 = $sql_query;
		
		//build and email -----------
		
		//get the user information
		$sql_query = "SELECT first_name, last_name, email
			FROM customers
			WHERE customers.aid = '". $_REQUEST['aid'] . "'";
			
			$result = @mysql_query ($sql_query); //Run the query.
			$customer = mysql_fetch_array ($result, MYSQL_ASSOC);
			
			$to  = $customer['first_name']." ".$customer['last_name']." <".$customer['email'].">, "; // note the comma
			//$to .= 'wez@example.com'; //only if we need more people
			
			switch ($_POST['customer_status_id']) {
				case 1:
					$customer_status = "NEW";
					break;
				case 2:
					$customer_status = "APPROVED";
					break;
				case 3:
					$customer_status = "SUSPENDED/BLOCKED";
					break;
			}
			
			// subject
			$subject = 'ISTE storytelling corps - '. $video_status;
			
			// message
			$message = '
<html>
<head>
  <title>testing</title>
</head>
<body>
  <p>THIS IS AN AUTOMATED MESSAGE - PLEASE DO NOT REPLY DIRECTLY TO THIS MESSAGE</p>
  <table>
    <tr>
      <td><p>Your account on the ISTE storyteller corps website has been '.$customer_status.'</p>
      <p></p>
      <p><a href="http://www.istevision.org/">Click this link to access your storykeepers account.</a></p></td>
    </tr>
  </table>
</body>
</html>
';

			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
			$headers .= 'From: istevisionision  <webmaster@istevision.org>' . "\r\n";
			//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
			//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
			$headers .= 'Reply-To: noreply <noreply@istevision.org>' . "\r\n";
			$headers .= 'Return-Path: noreply <noreply@istevision.org>' . "\r\n";
			
			// Mail it
			mail($to, $subject, $message, $headers, '-fwebmaster@istevision.org');
			
		//end email
	}
	header ("Location: members.php");
?>