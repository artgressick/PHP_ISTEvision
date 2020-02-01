<?php # Script 1.0 - update the approved videos

	include('includes/security.php');
	include('../includes/_lib.php');
	
	// This page will check the database for the staffer. If they choose to save the information then
	// we will create a cookie to save the email address.

	//Check the posting of the page to make sure is was not by-passed
	if (isset($_POST['approval'])) {
		
		require_once ('istetube-conf.php'); //Map the Connection.
	
		//we have to get the featured checkbox to make sure that it is not blank
		if ($_POST['featured'] == "1") {
			$featured = 1;
		} else {
			$featured = 0;
		}
		if ($_POST['iste_member'] == "1") {
			$iste_member = 1;
		} else {
			$iste_member = 0;
		}
		
		$sql_query = "UPDATE videos SET
			video_status_id = ". $_POST['video_status_id'] .",
			admin_notes = '". encode($_POST['admin_notes']) ."',
			featured = '". $featured ."',
			iste_member = '". $iste_member ."'
			
			WHERE vid = '". $_POST['vid'] ."'";
		$result = @mysql_query ($sql_query); //Run the query.
		
		//Original Channels -------------
		$sql_query = "select id
		FROM channels
		ORDER BY display_order";
		
		$channel_result = @mysql_query ($sql_query); //Run the query.
		
		//Remove the existing channels and then Cycle through the channels and add them to the table.
		$remove_query = "delete from video_channels where video_id = ".$_POST['video_id'];
		$result = @mysql_query ($remove_query); //Run the query.
		
		$insert_query = "INSERT INTO video_channels (video_id, channel_id) VALUES (";
		
		$error_checker = 0;

		while ($channels = mysql_fetch_array ($channel_result, MYSQL_ASSOC)) {
			$channel_id = $channels['id'];

			if ($_POST[$channels['id']] > 0) {
				$insert_query .= $_POST['video_id'].",".$channels['id']."),(";
				
				$error_checker = 1;
			}
		}
		
		$insert_query = substr($insert_query, 0, -2);  // hack off the last 2 items
		
		if ($error_checker == 1) { //Dont run the insert command unless they checked something.
			$result = @mysql_query ($insert_query); //Run the query.
		}
		
		//build and email -----------
		
		//get the user information
		$sql_query = "SELECT first_name, last_name, email
			FROM customers
			JOIN videos ON customers.id = videos.customer_id
			WHERE videos.vid = '". $_REQUEST['vid'] . "'";
			
			$result = @mysql_query ($sql_query); //Run the query.
			$customer = mysql_fetch_array ($result, MYSQL_ASSOC);
			
			$to  = $customer['first_name']." ".$customer['last_name']." <".$customer['email'].">, "; // note the comma
			//$to .= 'wez@example.com'; //only if we need more people
			
			switch ($_POST['video_status_id']) {
				case 1:
					$video_status = "NEW";
					break;
				case 2:
					$video_status = "APPROVED";
					break;
				case 3:
					$video_status = "REJECTED";
					break;
				case 4:
					$video_status = "REMOVED by User";
					break;
				case 5:
					$video_status = "REMOVED by Administrator";
					break;
			}
			
			// subject
			$subject = 'ISTE storytelling VIDEO STATUS - '. $video_status;
			
			// message
			$message = '
<html>
<head>
  <title>ISTE storytelling corps</title>
</head>
<body>
<p>THIS IS AN AUTOMATED MESSAGE - PLEASE DO NOT REPLY DIRECTLY TO THIS MESSAGE</p>
<P></P>
  <p>Thank you for sharing your story with us on the ISTE storytelling corps website. Some important information related to your submission is below.</p>
  
  <table>
    <tr>
      <td><p>Your digital story has been:  '.$video_status.'</p>
      <p>Here is a message from the project administrator regarding this status change:  '.$_POST['admin_notes'].'</p>
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
			$headers .= 'From: istevision  <webmaster@istevision.org>' . "\r\n";
			//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
			//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
			$headers .= 'Reply-To: noreply <noreply@istevision.org>' . "\r\n";
			$headers .= 'Return-Path: noreply <noreply@istevision.org>' . "\r\n";
			
			// Mail it
			mail($to, $subject, $message, $headers, '-fwebmaster@istevision.org');
			
		//end email
	}
	header ("Location: videos.php");
?>
