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
					<td><div class="title">NECC Lounges</div></td>
					<td align="right"></td>
				</tr>
				<tr>
					<td colspan="2" bgcolor="#999999">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" style="height:20px">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" style="color:red;">
						There was an error. Check the information and try again.
					</td>
				</tr>
			</table>
		</td>
	</tr>
<?
	include('includes/bottom.php');
?>