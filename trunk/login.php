<?php
	session_start(); //Do not use this code if you include the security above.
	
	#Load some variables in here.
	$tab = "live";
	$page_title = "Login";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
	
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents" style="padding-top:40px; padding-bottom:40px;">
			<form id="login" name="login" method="post" action="checklogin.php">
			<table cellpadding="0" cellspacing="0" border="0" width="350" style="width:350px; height:450px; vertical-align:middle; background: url(./images/signin.png);" valign="middle" align="center">
				<tr>
        			<td style="height:128px;"></td>
        		</tr>
        		<tr>
        			<td style='color:white; vertical-align:top; text-align:center;'>
        				<div style=''>
        					username / email address:<br ?>
        					<input name="email" type="text" id="email" size="23" maxlength="100" style='width:200px;' />
        				</div>
        				<div style='padding-top:5px;'>
        					password:<br />
        					<input name="password" type="password" id="password" size="23" maxlength="25" style='width:200px;' />
        				</div>
        				<div style='padding-top:30px;'>
        					<input type="submit" name="login" value="log in" /> &nbsp;&nbsp; 
        					<input type="button" value="forgot password" onclick="location.href='forgotpassword.php';" />
        				</div>
        				<div style='margin-top:20px; padding-top:20px; border-top:2px solid #AAA; margin-left:100px; margin-right:100px;' /></div>
        				<div style=''>
        					<input type="button" value="create an account" onclick="location.href='createaccount.php';" />
        				</div>
        			</td>
      			</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');

/*
        				<img src="images/main_splash2.jpg" width="520" height="450" />
        				<div style="padding: 10px;"><a href="createaccount.php">Create an Account today. Click Here</a></div>
        			</td>
        			<td bgcolor="#ffffff" valign="top">
        				<div><img src="images/RightSidebar-ISTE30thLogo.jpg" width="180" height="345" /></div>
        				<div style="padding-bottom: 15px; font-weight: bold;">Sign In</div>
						<div>
							<span style="font-weight: bold;">Email Address</span><br />
							<input name="email" type="text" id="email" size="23" maxlength="100" />
						</div>
						<div>
							<span style="font-weight: bold;">Password</span><br />
							<input name="password" type="password" id="password" size="23" maxlength="25" />
						</div>
						<div style="padding-top: 10px;">
							<input type="submit" name="login" id="login" value="Login" />
							&nbsp;<a href="forgotpassword.php">Forgot Password</a>.
						</div>
*/

?>