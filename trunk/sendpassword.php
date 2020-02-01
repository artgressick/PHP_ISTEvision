<?php # Script 1.0 - send new password

//

if (isset($_POST['email'])) {

	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
		
	//first check to make sure there isn't already an account created with that email address.
	$query = "SELECT id, first_name, last_name, email from customers where email = '".$_POST['email']."'";
		
	$result = @mysql_query ($query); //Run the query.
	$account_verification = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	if ($account_verification['email'] == $_POST['email']) {
		//found their account
		
		function createRandomPassword() { 
			
			$chars = "abcdefghijkmnopqrstuvwxyz023456789";
			srand((double)microtime()*1000000); 
			$i = 0; 
			$pass = '' ; 
			
			while ($i <= 10) { 
				$num = rand() % 33; 
				$tmp = substr($chars, $num, 1); 
				$pass = $pass . $tmp; 
				$i++; 
			} 
			
			return $pass; 
		}
		
		$new_password = createRandomPassword();
		
		$query = "UPDATE customers
			SET password = '".sha1($new_password)."'
			WHERE id = ".$account_verification['id'];
			
		$result = @mysql_query ($query); //Run the query.
		
		//send an email with the new information
		$to  = $account_verification['first_name']." ".$account_verification['last_name']." <".$account_verification['email']. '>, '; // note the comma
		//$to .= 'wez@example.com'; //only if we need more people
			
		// subject
		$subject = 'ISTE storytelling corps PASSWORD RESET';
			
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
      <td>
      <p>Your password to log into the ISTE storytelling corps website has been reset. Your new password is : '.$new_password.'<p>
      <p><a href="http://www.istevision.org">Click here to log in with your new password</a>.</p>
      <p>Once you log into the website please change your password in the profile area.</p>
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
		$headers .= 'From: ISTE Vision  <newaccounts@istevision.org>' . "\r\n";
		//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
		//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
		$headers .= 'Reply-To: noreply <noreply@istevision.org>' . "\r\n";
		$headers .= 'Return-Path: noreply <noreply@istevision.org>' . "\r\n";
			
		// Mail it
		mail($to, $subject, $message, $headers, '-fwebmaster@istevision.org');
		
		//Display and HTML page now.
		
		//include the header information
		include('includes/page-meta.php');
		include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<div style="font-size:14px; font-weight:bold; color:#666; background: #ffffff; height: 175px; padding-top: 100px; text-align: center;">
				<div style="font-size:14px; font-weight:bold; color:#666;">
					Password Reset, an email should arrive shortly with all of the information
				</div>
							
				<div style="font-size:14px; font-weight:bold; color:#666;">
					If you have not receive your password in up to 30 minutes please check your spam filters.
				</div>
							
				<div style="font-size:14px; font-weight:bold; color:#666; padding-top: 25px;">
					<a href="index.php">Return to main page</a>
				</div>
			</div>
		</td>
	</tr>
</table>
<?
		include('includes/page-bottom.php');

	//whew, the account verification and sending of the email is done.
		
	} else {
	
	//no account can be found so we need to just display and HTML page telling this.
	
		//include the header information
		include('includes/page-meta.php');
		include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<div style="font-size:14px; font-weight:bold; color:#666; background: #ffffff; height: 175px; padding-top: 100px; text-align: center;">
				<div style="font-size:14px; font-weight:bold; color:#666;">
					Sorry, we were not able to find this email address.
				</div>
							
				<div style="font-size:14px; font-weight:bold; color:#666;">
					Did you type the alternate email address instead of primary.
				</div>
							
				<div style="font-size:14px; font-weight:bold; color:#666; padding-top: 25px;">
					Go back to try again or <a href="index.php">Return to main page</a>
				</div>
			</div>
		</td>
	</tr>
</table>
<?
		include('includes/page-bottom.php');
	}
} else {
	header ("Location: index.php");
	exit();
}
?>