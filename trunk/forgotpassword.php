<?php
	session_start(); //Do not use this code if you include the security above.
	
	#Load some variables in here.
	$tab = "live";
	$page_title = "Confirmation";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<form id="create" name="create" method="post" action="sendpassword.php">
			<div style="font-size:14px; font-weight:bold; color:#666; background: #ffffff; height: 225px; padding-top: 75px; text-align: left; padding-left: 25px;">
				<div id='errors'></div>
				
				<div style="font-size:14px; font-weight:bold; color:#666;">
					Lost password?
				</div>
							
				<div style="font-size:10px; color:#666; padding-top: 5px; padding-bottom: 20px;">
					If you have forgotten your password, we can send you a new one. Enter your primary email address below and we will send you a new password.
				</div>
				
				<div class="form_div">
					<span class="form_required">Primary Email Address</span><br />
					<input name="email" type="text" id="email" size="50" maxlength="100" />
				</div>
				
				<div class="form_div" style="padding-top: 20px;">
					<input type="submit" name="add" id="add" value="Send me a new password" />
				</div>
			</div>
			</form>
		</td>
	</tr>
</table>
<?
	include('includes/page-bottom.php');
?>