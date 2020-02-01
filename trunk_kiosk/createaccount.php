<?php

	# Stuff In The Header
	function sith() { 

?>	<script type='text/javascript'>
			var totalErrors = 0;
			function error_check() {
				if(totalErrors != 0) { totalErrors = 0; } 
				var errorMessage = '';
				
				if(document.getElementById('first_name').value == '') {
					totalErrors++;
					errorMessage += 'You must enter a First Name.'+"\n\n";
				}

				if(document.getElementById('last_name').value == '') {
					totalErrors++;
					errorMessage += 'You must enter a Last Name.'+"\n\n";
				}

				if(document.getElementById('job_title').value == '') {
					totalErrors++;
					errorMessage += 'You must enter a Job Title.'+"\n\n";
				}

				if(document.getElementById('address').value == '') {
					totalErrors++;
					errorMessage += 'You must enter a Street/Mailing Address.'+"\n\n";
				}

				if(document.getElementById('city').value == '') {
					totalErrors++;
					errorMessage += 'You must enter a City/Local.'+"\n\n";
				}

				if(document.getElementById('country').value == '') {
					totalErrors++;
					errorMessage += 'You must enter a Country.'+"\n\n";
				}

				if(document.getElementById('email').value == '') {
					totalErrors++;
					errorMessage += 'You must enter a E-mail Address.'+"\n\n";
				}

				if(document.getElementById('password').value == '') {
					totalErrors++;
					errorMessage += 'You must enter a Password.'+"\n\n";
				} else if(document.getElementById('password').value != document.getElementById('password2').value) {
					totalErrors++;
					errorMessage += 'Passwords must match.'+"\n\n";
				}

				if(totalErrors > 0) {
					alert(errorMessage);
				}
				return (totalErrors == 0 ? true : false);
			}
	</script>
	
<?
		
	}

	function sitm() {
		//You have a total height of 1013px in this section to play with
?>
	<table cellpadding="0" cellspacing="0" style="width:100%; height:1013px;">
		<tr>
			<td style='vertical-align:top; padding-top:50px; '>
				<table border="0" cellpadding="0" cellspacing="0" width="90%;" align="center">
					<tr>
						<td class="contents">
							<form id="create" name="create" method="post" action="insertaccount.php" onsubmit="return error_check()">
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td colspan="3" class="left_column">
										<div style="font-size:24px; font-weight:bold;">
											Create a new account.
										</div>
										
										<div style="padding-top: 5px; padding-bottom: 20px;">
											Welcome to ISTEVision. This site will allow you to upload videos to our multimedia site. To begin fill out the form below. All fields in <span class="form_required">BLUE</span> are required.
										</div>
									</td>
								</tr>
								<tr>
									<td class="left_column" width="33%;" valign="top">
										<div class="form_div">
											<span class="form_required">First Name</span><br />
											<input name="first_name" type="text" id="first_name" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_required">Last Name</span><br />
											<input name="last_name" type="text" id="last_name" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_required">Job or Title</span><br />
											<input name="job_title" type="text" id="job_title" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_optional">Affiliation / Company</span><br />
											<input name="affiliation" type="text" id="affiliation" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_required">Street/Mailing Address</span><br />
											<input name="address" type="text" id="address" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_required">City/Local</span><br />
											<input name="city" type="text" id="city" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_required">State/Province</span><br />
											<input name="state" type="text" id="state" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_required">Zip/Postal Code</span><br />
											<input name="zip" type="text" id="zip" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_required">Country</span><br />
											<input name="country" type="text" id="country" size="30" maxlength="50" style="width:300px;" />
										</div>
									</td>
									<td class="right_column" width="34%" valign="top">
										<div class="form_div">
											<span class="form_optional">Work Phone</span><br />
											<input name="work_phone" type="text" id="work_phone" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_optional">Home Phone</span><br />
											<input name="home_phone" type="text" id="home_phone" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_optional">Cell Phone</span><br />
											<input name="cell_phone" type="text" id="cell_phone" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_optional">Fax</span><br />
											<input name="fax" type="text" id="fax" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_required">Primary E-mail</span> (Will be your username)<br />
											<input name="email" type="text" id="email" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_optional">Alternate E-mail</span><br />
											<input name="alt_email" type="text" id="alt_email" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_required">Password</span><br />
											<input name="password" type="password" id="password" size="30" maxlength="50" style="width:300px;" />
										</div>
										
										<div class="form_div">
											<span class="form_required">Password</span> (re-type for verification)<br />
											<input name="password2" type="password" id="password2" size="30" maxlength="50" style="width:300px;" />
										</div>
									</td>
									<td width="33%" valign="top">
										<div style="font-weight: bold; font-size: 14px; padding-top: 18px; padding-bottom: 15px;">
											ISTE User Agreement
										</div>
										<div style="padding-right: 20px; font-size:17px;">
											By uploading this video ("work") you:<br /><br />
				
				1. Represent and warrant that the work will be of wholly original material that you hold the copyright to (except for material in the public domain or used with the permission of the owner), will not infringe any copyright, and will not constitute a defamation; or invasion of the right of privacy or publicity; or infringement of any other kind, of any third party.<br /><br />
				
				2. You grant ISTE a non-exclusive worldwide perpetual license to use, modify, and make derivative works of this work. You also grant ISTE the right to use your name, biography, and likeness in advertising and promotion and in any and all ancillary products regardless of the formats in which such use occurs, when used in conjunction with any portion of, or derivative work made from, the work you upload.<br /><br />
				
				3. You also agree to indemnify and hold ISTE harmless from any and all claims, judgments, costs, suits, debts or liabilities, including attorney's fees, arising from ISTE's or your use of this work.
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
											<input type="submit" name="add" id="add" value="Request an Account" style="font-size:18px;" /> &nbsp;&nbsp; <input type=button value="Back" onClick="history.go(-1);" style="font-size:18px;" />
										</div>
									</td>
									<td>&nbsp;</td>
								</tr>
							</table>
							</form>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div style="position:absolute; bottom:32px; right:10px;"><img src="images/small-logo.png" alt="ISTE Vision"/></div>
	<div style="position:absolute; top:0px; left:0px;"><img src="images/top-left.png" alt="ISTE Vision"/></div>
	<div style="position:absolute; top:0px; right:0px;"><img src="images/top-right.png" alt="ISTE Vision"/></div>
	<div style="position:absolute; bottom:50px; left:0px;"><img src="images/bottom-left.png" alt="ISTE Vision"/></div>
<?
	}
	include('includes/wrapper.php');
/*
?>
?>

<?php
	include('includes/page-bottom2.php');
*/
?>