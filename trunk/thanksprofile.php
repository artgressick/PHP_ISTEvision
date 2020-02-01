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
			<div style="font-size:14px; font-weight:bold; color:#666; background: #ffffff; height: 300px; padding-top: 80px; text-align: center;">
				<div style="font-size:14px; font-weight:bold; color:#666;">
					Congratulations! Your account has been created.
				</div>
				<BR />
				<div style="font-size:14px; font-weight:bold; color:#666;">
					BEFORE YOU CAN LOG INTO THE STORYTELLING WEBSITE - YOU MUST ACTIVATE YOUR ACCOUNT!
				</div>
				<div style="font-size:14px; font-weight:bold; color:#666; padding-top: 25px;">
					TO ACTIVATE YOUR ACCOUNT - Please check your email for a verification message.
				</div>
				<div style="font-size:14px; font-weight:bold; color:#666; padding-top: 25px;">
					THE EMAIL MESSAGE WILL CONTAIN AN ACTIVATION LINK THAT MUST BE CLICKED TO VERIFY YOUR IDENTITY AND ACTIVATE YOUR ACCOUNT.
				</div>
				<div style="font-size:14px; font-weight:bold; color:#666; padding-top: 25px;">
					<a href="index.php">click here return to the main page</a>
				</div>
			</div>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>