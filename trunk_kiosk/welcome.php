<?php

	include('includes/page-meta.php');
	include('includes/page-top.php');
	
?>
<table border="0" cellpadding="0" cellspacing="0" width="1455" height="853" class="main_window">
	<tr>
		<td width="900" valign="top" colspan="2">
			<div class="text_description" style="padding-top: 45px; text-align:center; font-size: 24px; font-weight: bold; width: 800px;">Welcome to<br />
				the ISTEVision Network's<br />
				Storypod Kiosk!</div>
			</div>
			
			<div style="padding-left: 45px;">
				<div class="text_description" style="padding-top: 25px;">Please choose one of the following prompts to capture and upload your video...</div>
			
				<div class="text_description" style="padding-top: 25px;"><span style="font-weight: bold;">Tell our viewers...</span>
					<ol>
						<li> ...about yourself and how technology has changed the ways you teach and learn</li>
						<li> ...your favorite digital success story</li>
						<li> ...what it means to you to be a member of ISTE</li>
						<li> ...your vision for the future of ed tech</li>
						<li> ...a little about the person (or people) from the field who has/have inspired you most!</li>
					</ol>
				</div>
			</div>

			<div class="text_description" style="padding-top: 20px; text-align:center; font-size: 14px; font-weight: bold; width: 800px;">
				Focus on impact and results whenever possible!
			</div>
			
			<div style="padding-left: 45px;">
				<div class="text_description" style="padding-top: 25px;">
					To begin your recording session, you will need to either log into the site with an existing ISTEVision account or create one.
				</div>
			</div>
		</td>
		<td width="555" valign="top" align="center">
			<div style="padding-top: 25px;">
				<img src="images/logo-middle.png" alt="logo-middle" width="405" height="277"/>
			</div>
		</td>
	</tr>
	<tr>
		<td valign="top" width="450">
			<div class="text_description" style="padding-left: 45px;">
				<form id="login" name="login" method="post" action="checklogin.php">
					<div>
						<span style="font-size: 14px; font-weight: bold;">Existing ISTEVision Users</span>
					</div>
								
					<div style="padding-top: 15px;">
						Enter your information below.
					</div>
								
					<div style="padding-top: 15px;">
						<strong>Username</strong> (email address)<br />
						<input type="text" name="email" id="email" />
					</div>
								
					<div>
						<strong>Password</strong><br />
						<input type="password" name="password" id="password" />
					</div>
								
					<div style="padding-top: 15px;">
						<input type="submit" name="button" id="button" value="Log in" />
					</div>
				</form>
			</div>
		</td>
		<td valign="top" width="450">
			<div class="text_description" style="padding-left: 1px;">
				<div>
					<span style="font-size: 14px; font-weight: bold;">New to ISTEVision?</span>
				</div>
							
				<div style="padding-top: 15px;">
					Create an account. Take a few moments and fill out the registration form. Once you have an account you will be able to upload more videos, comment on existing videos and rate videos.
				</div>
							
				<div style="padding-top: 15px;">
					<a href="createaccount.php" style="color: yellow;">Click here to create an account</a>
				</div>
			</div>
		</td>
		<td width="555"></td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>