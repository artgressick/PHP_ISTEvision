<?php
	$BF = "";
	//include('includes/security.php');


	# Stuff In The Header
	function sith() { 
	global $BF;
?>	<script type='text/javascript' src='<?=$BF?>includes/forms.js'></script>
	<script type='text/javascript'>
		var page = 'add';
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
	$tab = "live";
	$page_title = "Create Account";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
	
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<form id="create" name="create" method="post" action="insertaccount.php" onsubmit="return error_check()">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
        			<td bgcolor="#ffffff" width="100%">
        				<table cellpadding="5" cellspacing="0" border="0" width="100%">
        					<tr>
        						<td colspan="2">
        							<div id='errors'></div>
        							<div style="font-size:14px; font-weight:bold; color:#666;">
        								Create a new account.
        							</div>
        							
        							<div style="font-size:12px; color:#666; padding-top: 5px; padding-bottom: 20px;">
        								Welcome to ISTEVision. This site will allow you to upload videos to our multi-media site. To begin fill out the form below. All fields in <span class="form_required">BLUE</span> are required.
        							</div>
        						</td>
        					</tr>
        					<tr>
        						<td valign="top">
        							<div class="form_div">
        								<span class="form_required">First Name</span><br />
        								<input name="first_name" type="text" id="first_name" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_required">Last Name</span><br />
        								<input name="last_name" type="text" id="last_name" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_required">Job or Title</span><br />
        								<input name="job_title" type="text" id="job_title" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_optional">Affiliation / Company</span><br />
        								<input name="affiliation" type="text" id="affiliation" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_required">Street/Mailing Address</span><br />
        								<input name="address" type="text" id="address" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_required">City/Local</span><br />
        								<input name="city" type="text" id="city" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_required">State/Province</span><br />
        								<input name="state" type="text" id="state" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_required">Zip/Postal Code</span><br />
        								<input name="zip" type="text" id="zip" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_required">Country</span><br />
        								<input name="country" type="text" id="country" size="30" maxlength="50" />
        							</div>
        						</td>
        						<td valign="top">
        							<div class="form_div">
        								<span class="form_optional">Work Phone</span><br />
        								<input name="work_phone" type="text" id="work_phone" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_optional">Home Phone</span><br />
        								<input name="home_phone" type="text" id="home_phone" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_optional">Cell Phone</span><br />
        								<input name="cell_phone" type="text" id="cell_phone" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_optional">Fax</span><br />
        								<input name="fax" type="text" id="fax" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_required">Primary E-mail</span> (Will be your username)<br />
        								<input name="email" type="text" id="email" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_optional">Alternate E-mail</span><br />
        								<input name="alt_email" type="text" id="alt_email" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_required">Password</span><br />
        								<input name="password" type="password" id="password" size="30" maxlength="50" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_required">Password</span> (re-type for verification)<br />
        								<input name="password2" type="password" id="password2" size="30" maxlength="50" />
        							</div>
        						</td>
        					</tr>
        					<tr>
        						<td colspan="2">
        							<div class="form_div" style="padding-top: 20px;">
        								<span class="form_optional">Ning URL (Links to their session discussion forum on the NECC ning, if applicable)</span><br />
        								<input name="ning_url" type="text" id="ning_url" size="75" maxlength="250" />
        							</div>
        							
        							<div class="form_div">
        								<span class="form_required">Student Status (Are you a K-12 student?)</span><br />
        								<input type="radio" id="student_status" name="student_status" value="1" /> Yes or <input type="radio" id="student_status" name="student_status" value="0" checked="checked" /> No
        							</div>
        							
        							<div class="form_div" style="padding-top: 20px;">
        								<input type="submit" name="add" id="add" value="Request an Account" />
        							</div>
        						</td>
        					</tr>
        				</table>
        			</td>
        			<td bgcolor="#ffffff">
        				<div style="text-align:center;"><img src="images/RightSidebar-ISTE30thLogo.jpg" width="180" height="345" /></div>
        			</td>
      			</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>