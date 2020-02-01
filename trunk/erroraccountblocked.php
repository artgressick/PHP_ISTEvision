<?php
	session_start(); //Do not use this code if you include the security above.
	
	#Load some variables in here.
	$tab = "live";
	$page_title = "Error";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
	
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<div style="font-size:14px; font-weight:bold; color:#666; background: #ffffff; height: 250px; padding-top: 80px; text-align: center;">
				<p>We're sorry, there was an error with this request.</p>
				
				<p>Your account has either not been activated or has been blocked by the administrator.</p>
				
				<p>If you just signed up for an account. Please be sure to check the account of the e-mail address you used for important account activation information.</p>
				
				<p>Also check your spam filter and junk mail folders.</p>
			</div>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>