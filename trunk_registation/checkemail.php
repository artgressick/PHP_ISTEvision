<?php
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	session_start();
	//include the header information
	include('includes/header.php');
	include('includes/top.php');
?>
	<tr>
		<td class="contents">
			<table width="790" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2" style="padding:20px; font-size:12px; font-weight:bold;">
						You have been sent a e-mail to the e-mail address you provided.  Within that e-mail is a URL to verify your e-mail address. Once you have done this you will be able to add an event.
					</td>
				</tr>
			</table>
		</td>
	</tr>
<?
	include('includes/bottom.php');
?>