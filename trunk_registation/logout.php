<?php
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	session_start();
	$_SESSION = array();
	unset($_SESSION);
	
	//include the header information
	include('includes/header.php');
	include('includes/top.php');
?>
	<tr>
		<td class="contents">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2">
						You are now logged out.
					</td>
				</tr>
			</table>
		</td>
	</tr>
<?
	include('includes/bottom.php');
?>