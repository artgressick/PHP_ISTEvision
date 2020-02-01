<?php # Script 1.0 - insert account

//Check the posting of the page to make sure is was not by-passed
$flag = 0;
if (isset($_POST['email'])) {

	$flag = 1;
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	include('includes/_lib.php');
		
	//first check to make sure there isn't already an account created with that email address.
	$query = "SELECT email from customers where email = '".$_POST['email']."'";
		
	$result = @mysql_query ($query); //Run the query.
	$account_verification = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	if ($account_verification['email'] == $_POST['email']) {
		header ('Location: erroraccount.php');
		exit();
	} else {
		//make a sha1 string for the customer linking
		$aid = sha1(uniqid(mt_rand(1000000,9999999).iste.time(), true));
		
		$query = "INSERT INTO customers SET
			first_name = '".encode($_POST['first_name'])."',
			last_name = '".encode($_POST['last_name'])."',
			email = '".encode($_POST['email'])."',
			password = '".sha1($_POST['password'])."',
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
			student_status = '".$_POST['student_status']."',
			created_at = '".date('Y-m-d H:i:s')."',
			aid = '".$aid."'";
			
		$query2 = $query;
	
		$result = @mysql_query ($query); //Run the query.
	
		if ($result) {
			//create an email and send it to them proper
			$to  = $_POST['first_name']." ".$_POST['last_name']." <".$_POST['email'].">, "; // note the comma
			//$to .= 'wez@example.com'; //only if we need more people
			
			// subject
			$subject = 'Account Creation';
			
			// message
			$message = '
<html>
<head>
  <title>ISTE storytelling corps</title>
</head>
<body>
<p>THIS IS AN AUTOMATED MESSAGE - PLEASE DO NOT REPLY DIRECTLY TO THIS MESSAGE</p>
<p></p>
<p>IMPORTANT INFORMATION REGARDING YOUR ACCOUNT ON THE ISTE STORYTELLING CORP WEBSITE - PLEASE READ CAREFULLY.</p>
  <table>
    <tr>
      <td><a href="http://www.istevision.org/accountverification.php?aid='.$aid.'">PLEASE CLICK THIS LINK TO ACTIVATE YOUR ACCOUNT.</a>
      <p></p>
      <p>Your account will not be activated until you click the link above. You only need to activate your account once.</p>
      <p></p>
      <p>Thank you</p>
      </td>
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
			$headers .= 'From: istevision <webmaster@istevision.org>' . "\r\n";
			//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
			//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
			$headers .= 'Reply-To: noreply <noreply@istevision.org>' . "\r\n";
			$headers .= 'Return-Path: noreply <noreply@istevision.org>' . "\r\n";
			
			// Mail it
			mail($to, $subject, $message, $headers, '-fwebmaster@istevision.org');
		
			//redirect the user to the homepage now.
			header ('Location: thanksprofile.php');
			exit();
		}
		

		mysql_close(); //close the connection
	}
} //end the statement and redirect if we went this far.
?>