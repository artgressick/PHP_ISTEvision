<?php
	$BF = "";
	include('includes/security.php');

	//get the account information.
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//This is for the User Profile. We need to get the information and display it on the page below.
	$sql_query = "SELECT first_name, last_name, email, job_title, affiliation, address, city, state, zip, country, work_phone, home_phone, cell_phone, fax, ning_url, alt_email, student_status
		FROM customers
		WHERE id = ".$_SESSION['id'];
	
	$result = @mysql_query ($sql_query); //Run the query.
	$customer = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	if ($result) { //we found them if not error page.

		# Stuff In The Header
		function sith() { 
		global $BF;
?>
	<script type='text/javascript' src='<?=$BF?>includes/forms.js'></script>
	<script type='text/javascript'>
		var page = 'edit';
		var totalErrors = 0;
		function error_check() {
			if(totalErrors != 0) { reset_errors(); }  
			
			totalErrors = 0;
		
			if(errEmpty('first_name', "You must enter a First Name.")) { totalErrors++; }
			if(errEmpty('last_name', "You must enter a Last name.")) { totalErrors++; }
			if(errEmpty('job_title', "You must enter a Job Title.")) { totalErrors++; }
			if(errEmpty('address', "You must enter a Street/Mailing Address.")) { totalErrors++; }
			if(errEmpty('city', "You must enter a City/Local.")) { totalErrors++; }
			if(errEmpty('zip', "You must enter a Zip/Postal Code.")) { totalErrors++; }
			if(errEmpty('country', "You must enter a Country.")) { totalErrors++; }
			if(errEmpty('email',"You must enter a E-mail Address.")) { 
				totalErrors++; 
			} else {
				if(errEmail('email','','This is not a valid Email Address.')) { totalErrors++; }
			}
			if(page == 'add') {
				if(errPasswordsEmpty('password','password2',"You Must Enter a Password")) { totalErrors++; }
				else if (errPasswordsMatch('password','password2',"Passwords must match")) { totalErrors++; }
			} else {
				if(errPasswordsMatch('password','password2',"Passwords must match")) { totalErrors++; }
			}
			return (totalErrors == 0 ? true : false);
		}
	</script>
<?
	}

	#Load some variables in here.
	$page_title = "Edit Profile";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<div style="padding: 20px; background: #fff;">
			<form id="create" name="create" method="post" action="updateaccount.php" onsubmit="return error_check()">
				<div id='errors'></div>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" colspan="3">
							<div style="font-size:14px; font-weight:bold; color:#666;">
								Update account.
							</div>
							
							<div style="font-size:12px; color:#666; padding-top: 5px; padding-bottom: 20px;">
								Welcome to ISTE Vision. This site will allow you to upload videos to our multi-media site for all people to view. To begin fill out the form below. All fields in <span class="form_required">BLUE</span> are required.
							</div>
						</td>
					</tr>
					<tr>
						<td width="33%" style="padding-right: 20px;" valign="top">
							
							<div class="form_div">
								<span class="form_required">First Name</span><br />
								<input name="first_name" type="text" id="first_name" size="30" maxlength="50" value="<?= $customer['first_name'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_required">Last Name</span><br />
								<input name="last_name" type="text" id="last_name" size="30" maxlength="50" value="<?= $customer['last_name'] ?>" />
							</div>
							
							<div style="padding: 5px; background: #efefef;">
							
								<div style="padding-bottom: 5px; font-size: 11px; font-weight: bold;">
									Only modify info if you need it changed.
								</div>
								
								<div class="form_div">
									<span class="form_required">Primary Email</span> (Will be your username)<br />
									<input name="email" type="text" id="email" size="30" maxlength="50" value="<?= $customer['email'] ?>" />
								</div>
							
								<div class="form_div">
									<span class="form_required">Password</span><br />
									<input name="password" type="password" id="password" size="30" maxlength="50" />
								</div>
							
								<div class="form_div">
									<span class="form_required">Password</span> (re-type for verification)<br />
									<input name="password2" type="password" id="password2" size="30" maxlength="50" />
								</div>
								
							</div>
							
						</td>
						<td width="34%" style="padding-right: 20px;" valign="top">
							
							<div class="form_div">
								<span class="form_required">Job or Title</span><br />
								<input name="job_title" type="text" id="job_title" size="30" maxlength="50" value="<?= $customer['job_title'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_optional">Affiliation / Company</span><br />
								<input name="affiliation" type="text" id="affiliation" size="30" maxlength="50" value="<?= $customer['affiliation'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_required">Street/Mailing Address</span><br />
								<input name="address" type="text" id="address" size="30" maxlength="50" value="<?= $customer['address'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_required">City/Local</span><br />
								<input name="city" type="text" id="city" size="30" maxlength="50" value="<?= $customer['city'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_required">State/Province</span><br />
								<input name="state" type="text" id="state" size="30" maxlength="50" value="<?= $customer['state'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_required">Zip/Postal Code</span><br />
								<input name="zip" type="text" id="zip" size="30" maxlength="50" value="<?= $customer['zip'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_required">Country</span><br />
								<input name="country" type="text" id="country" size="30" maxlength="50" value="<?= $customer['country'] ?>" />
							</div>
							
						</td>
						<td width="33%" style="padding-right: 20px;" valign="top">
							
							<div class="form_div">
								<span class="form_optional">Work Phone</span><br />
								<input name="work_phone" type="text" id="work_phone" size="30" maxlength="50" value="<?= $customer['work_phone'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_optional">Home Phone</span><br />
								<input name="home_phone" type="text" id="home_phone" size="30" maxlength="50" value="<?= $customer['home_phone'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_optional">Cell Phone</span><br />
								<input name="cell_phone" type="text" id="cell_phone" size="30" maxlength="50" value="<?= $customer['cell_phone'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_optional">Fax</span><br />
								<input name="fax" type="text" id="fax" size="30" maxlength="50" value="<?= $customer['fax'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_optional">Alternate Email</span><br />
								<input name="alt_email" type="text" id="alt_email" size="30" maxlength="50" value="<?= $customer['alt_email'] ?>" />
							</div>
							
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<div class="form_div" style="padding-top: 20px;">
								<span class="form_optional">Ning URL (Links to their session discussion forum on the NECC ning, if applicable)</span><br />
								<input name="ning_url" type="text" id="ning_url" size="75" maxlength="250" value="<?= $customer['ning_url'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_required">Student Status (Are they a K-12 student?</span><br />
								<input type="radio" id="student_status" name="student_status" value="1" <?= ($customer['student_status'] == "1" ? "checked='checked'" : "") ?> /> Yes or <input type="radio" id="student_status" name="student_status" value="0" <?= ($customer['student_status'] == "0" ? "checked='checked'" : "") ?> /> No
							</div>
							
							<div class="form_div" style="padding-top: 20px;">
								<input type="submit" name="add" id="add" value="Update Account" /><input type="hidden" name="org_email" id="org_email" value="<?= $customer['email'] ?>" />
							</div>
						</td>
					</tr>			
				</table>
			</form>
			</div>
		</td>
	</tr>
</table>		
<?
	include('includes/page-bottom.php');
	
	} else {
		header ('Location: errorform.php');
		exit();
	}
?>