<?php
	#include('includes/security.php');
	session_start();
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	require_once ('_lib.php');
	
	if(isset($_POST['email_address'])) {
		$verifycode = md5($_POST['email_address']);
		$q = "INSERT INTO lounge_presenters SET
				pid = '".$verifycode."',
				first_name = '".encode($_POST['first_name'])."',
				last_name = '".encode($_POST['last_name'])."',
				email_address = '".$_POST['email_address']."',
				password = '".md5($_POST['password1'])."',
				verifycode = '".$verifycode."'
		";
		if(@mysql_query ($q)) {
			//include_once ('includes/_emailer.php');
			
/*			$message = $_POST['first_name'].",

Thank you for registering an account on ISTE's NECC EnvisionIT! Lounge Scheduler. Click the link below to verify and activate your account:
			
			
http://lounges.istevision.org/verifyaccount.php?d=".$verifycode."

Technical difficulties? Contact programmers@techitsolutions.com

Sincerely,
ISTE's NECC Program Committee";
*/
			//create an email and send it to them proper
			$to  = $_POST['first_name']." ".$_POST['last_name']." <".$_POST['email_address'].">, "; // note the comma
			//$to .= 'wez@example.com'; //only if we need more people
			
			// subject
			$subject = 'EnvisionIT! Verify E-mail Address';
			
			// message
			$message = "
<html>
<head>
  <title>EnvisionIT! Verify E-mail Address</title>
</head>
<body>
<p>THIS IS AN AUTOMATED MESSAGE - PLEASE DO NOT REPLY DIRECTLY TO THIS MESSAGE</p>
<p></p>
<p>Thank you for registering an account on ISTE's NECC EnvisionIT! Lounge Scheduler.</p>
<p><a href='http://lounges.istevision.org/verifyaccount.php?d=".$verifycode."'>PLEASE CLICK THIS LINK TO ACTIVATE YOUR ACCOUNT.</a></p>
<p>Your account will not be activated until you click the link above. You only need to activate your account once.</p>
<p>Thanks</p>
<p>Questions? Contact <a href='mailto:necc@iste.org'>necc@iste.org</a></p>
</body>
</html>
";

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


			
			//if(emailer($_POST['email_address'],"Verify E-mail Address",$message)) {
				header ('Location: checkemail.php');
				die();
			//} else {
			//	header ('Location: error.php');
			//	die();		
			//}
		} else {
			header ('Location: error.php');
			die();		
		}
	}	
function sith() {
?>
<script type="text/javascript" src="includes/forms.js"></script>
<script type='text/javascript'>
	var totalErrors = 0;
	function error_check() {
		if(totalErrors != 0) { reset_errors(); }  
		
		totalErrors = 0;
	
		if(errEmpty('first_name', "You must enter your First Name.")) { totalErrors++; }
		if(errEmpty('last_name', "You must enter your Last Name.")) { totalErrors++; }
		if(errEmpty('email_address', "You must enter your E-mail Address.")) { totalErrors++; } 
		else if(errEmail('email_address','', "You must enter a valid E-mail Address.")) { totalErrors++; }
		else if(errEmailExists('email_address',"This e-mail address is in use.")) { totalErrors++; }
		if(errPasswordsEmpty('password1','password2',"You Must Enter a Password")) { totalErrors++; }
		else if (errPasswordsMatch('password1','password2',"Passwords must match")) { totalErrors++; }
	
		return (totalErrors == 0 ? true : false);
	}

</script>

<?
}
	//include the header information
	include('includes/header.php');
	include('includes/top.php');
?>
	<tr>
		<td class="contents">
			<form id="form1" name="form1" method="post" action="" onsubmit="return error_check()">
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="2">
							<div class="section_header" style="margin-bottom:10px;">Registration is required in order to manage your events on the scheduler.</div>
							<div id="errors"></div>
							<table cellpadding="0" cellspacing="0" style="width:80%;" align="center">
								<tr>
									<td style="vertical-align:top; width:50%;">
										<div style="font-weight:bolder;">First Name:</div>
										<input type="text" name="first_name" id="first_name" size="30" maxlength="50" />
										<div style="font-weight:bolder;margin-top:5px;">Last Name:</div>
										<input type="text" name="last_name" id="last_name" size="30" maxlength="50" />
										<div style="font-weight:bolder;margin-top:5px;">E-mail Address:</div>
										<input type="text" name="email_address" id="email_address" size="30" maxlength="150" />
									</td>
									<td style="vertical-align:top;">
										<div style="font-weight:bolder;">Password:</div>
										<input type="password" name="password1" id="password1" size="30" maxlength="50" />
										<div style="font-weight:bolder;margin-top:5px;">Confirm Password:</div>
										<input type="password" name="password2" id="password2" size="30" maxlength="50" />
									</td>
								</tr>
								<tr>
									<td colspan='2' style="padding-top:10px;"><input type="submit" name="Save" id="Save" value="Submit" /></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
<?
	include('includes/bottom.php');
?>