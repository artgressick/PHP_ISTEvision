<?php
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	session_start();	
	$error = '';
	if(isset($_POST['email_address'])) {
		
		$q = "SELECT * FROM lounge_presenters WHERE
				email_address = '".$_POST['email_address']."' AND
				password = '".md5($_POST['password1'])."' AND verified";
		$details = mysql_fetch_assoc(@mysql_query ($q));
		if($details['id'] != '') {
			$_SESSION['first_name'] = $details['first_name'];
			$_SESSION['last_name'] = $details['last_name'];
			$_SESSION['email_address'] = $details['email_address'];
			$_SESSION['id'] = $details['id'];
			$_SESSION['access'] = $details['access_level'];
			$_SESSION['lounges'] = explode(',',$details['lounges']);
			header ('Location: index.php');
			die();			
		} else {
			$error = "Invalid Log In Details";
		}
	}	

	include('includes/header.php');
	include('includes/top.php');
?>
	<tr>
		<td class="contents">
			<form id="form1" name="form1" method="post" action="" onsubmit="">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2">
<?
	if($error != '') {
?>
						<div class='ErrorMessage'><?=$error?></div>
<?				
	}
?>			
						<div id="errors"></div>
						<table cellpadding="0" cellspacing="0" style="width:100%;">
							<tr>
								<td style="vertical-align:top; width:50%;">
									<div class="section_header" style="width:90%; margin-bottom:10px;">Don't have an account?</div>
									<div style="font-size:12px;"><a href="newaccount.php">Register for a new account</a>.</div>
								</td>
								<td style="vertical-align:top;">
									<div class="section_header" style="width:90%; margin-bottom:10px;">Log In:</div>
									<div>E-mail Address:</div>
										<input type="text" name="email_address" id="email_address" size="30" maxlength="150" />
									<div>Password:</div>
										<input type="password" name="password1" id="password1" size="30" maxlength="50" />
									<div style="margin-top:10px;">
										<input type="submit" name="Save" id="Save" value="Submit" />
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
<?
	include('includes/bottom.php');
?>