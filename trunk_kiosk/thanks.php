<?php
	//start a session
	session_start(); //Start the session.
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	if(!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) {
		header ("Location: index.php"); //return to home page
		exit();		
	}


	function sitm() {
		//You have a total height of 1014px in this section to play with
?>
	<table cellpadding="0" cellspacing="0" style="width:100%;">
		<tr>
			<td style="text-align:center; padding-top:50px; font-size:40px; ">THANK YOU!</td>
		</tr>
		<tr>
			<td style="text-align:center; padding-top:20px; font-size:26px; padding-bottom:40px;">Your Video Has Been Submitted Successfully!</td>
		</tr>
		<tr>
			<td style='vertical-align:top; text-align:center; padding-bottom:50px;'><img src="images/medium-logo.png" alt="ISTE Vision"/></td>
		</tr>
		<tr>
			<td style="text-align:center; font-size:28px; padding-bottom:20px;">What do you want to do now?</td>
		</tr>
		<tr>
			<td style='background: url(images/loginbg.gif); height:80px;'>
				<table cellpadding="0" cellspacing="0" style="width:100%;">
					<tr>
						<td style="width:150px;"></td>
						<td style="width:765px; text-align:right; vertical-align:middle;"><img src="images/makeanothervideo.jpg" alt="Make Another Video" style="border:0; cursor:pointer;" onclick="location.href='makevideo.php';" /></td>
						<td style="width:72px;height:80px;"><img src="images/or.png" alt="OR" /></td>
						<td style="vertical-align:middle; padding-left:25px;"><img src="images/logoff.jpg" alt="Logoff" style="border:0; cursor:pointer;" onclick="location.href='logout.php';" /></td>
						<td style="width:150px;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div style="position:absolute; bottom:275px; left:0px;"><img src="images/top-left.png" alt="ISTE Vision"/></div>
	<div style="position:absolute; bottom:275px; right:0px;"><img src="images/top-right.png" alt="ISTE Vision"/></div>
<?
	}
	include('includes/wrapper.php');
?>