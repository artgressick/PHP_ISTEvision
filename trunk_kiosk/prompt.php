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
			<td style='vertical-align:top; text-align:center; padding-top:50px; padding-bottom:100px;'>
				<table cellpadding="10" cellspacing="0" style="width:80%;" align="center">
					<tr>
						<td colspan="2" style="font-size:40px; padding-bottom:50px; font-weight:bold;">Choose a prompt and tell our viewers...</td>
					</tr>
					<tr>
						<td style="width:400px; text-align:right;"><img src="images/1.png" alt="1" /></td>
						<td style="font-size:26px; text-align:left; padding-right:300px; font-weight:bold;">how technology has changed how you teach and learn</td>
					</tr>
					<tr>
						<td style="width:400px; text-align:right;"><img src="images/2.png" alt="1" /></td>
						<td style="font-size:26px; text-align:left; padding-right:300px; font-weight:bold;">your favorite digital success story</td>
					</tr>
					<tr>
						<td style="width:400px; text-align:right;"><img src="images/3.png" alt="1" /></td>
						<td style="font-size:26px; text-align:left; padding-right:300px; font-weight:bold;">what it means to you to be a member of ISTE</td>
					</tr>
					<tr>
						<td style="width:400px; text-align:right;"><img src="images/4.png" alt="1" /></td>
						<td style="font-size:26px; text-align:left; padding-right:300px; font-weight:bold;">your vision for the future of ed tech</td>
					</tr>
					<tr>
						<td style="width:400px; text-align:right;"><img src="images/5.png" alt="1" /></td>
						<td style="font-size:26px; text-align:left; padding-right:300px; font-weight:bold;">a little about the person (or people) from the field who has/have inspired you most</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div style="position:absolute; bottom:200px; right:350px;"><img src="images/next.png" alt="ISTE Vision" onclick="location.href='makevideo.php';" style='cursor:pointer;' /></div>
	<div style="position:absolute; bottom:32px; right:10px;"><img src="images/small-logo.png" alt="ISTE Vision"/></div>
	<div style="position:absolute; top:0px; left:0px;"><img src="images/top-left.png" alt="ISTE Vision"/></div>
	<div style="position:absolute; top:0px; right:0px;"><img src="images/top-right.png" alt="ISTE Vision"/></div>
	<div style="position:absolute; bottom:50px; left:0px;"><img src="images/bottom-left.png" alt="ISTE Vision"/></div>

<?
	}
	include('includes/wrapper.php');
?>