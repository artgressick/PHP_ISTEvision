<?php

	include('includes/page-meta.php');
	include('includes/page-top.php');
	
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#efefef">
				<tr>
					<td colspan="3">
						<div style="padding: 25px;">	
							Before you begin making a video please either log into the site or make a new account. This will allow you to upload more videos or track your video in the future. This will also allow us to award prizes in the future should there be any prize for your video.
						</div>
					</td>
				</tr>
				<tr>
					<td width="33%" valign="top">
						<form id="login" name="login" method="post" action="checklogin.php">
							<table width="100%" border="0" cellspacing="0" cellpadding="10">
								<tr>
									<td>
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
									</td>
								</tr>
								<tr>
							</table>
						</form>
					</td>
					<td width="34%" valign="top">
						<form id="form2" name="form2" method="post" action="">
							<table width="100%" border="0" cellspacing="0" cellpadding="10">
								<tr>
									<td>
										<div>
											<span style="font-size: 14px; font-weight: bold;">New to ISTEVision?</span>
										</div>
										<div style="padding-top: 15px;">
											Create an account. Take a few moments and fill out the registration form. Once you have an account you will be able to upload more videos, comment on existing videos and rate videos.
										</div>
										<div style="padding-top: 15px;">
											<a href="createaccount.php">Click here to create an account</a>.
										</div>
									</td>
								</tr>
							</table>
						</form>
					</td>
					<td width="33%" valign="top">
						<form id="form2" name="form2" method="post" action="">
							<table width="100%" border="0" cellspacing="0" cellpadding="10">
								<tr>
									<td>
										<div>
											<span style="font-size: 14px; font-weight: bold;">Post Anonymously</span>
										</div>
										<div style="padding-top: 15px;">
											If you just want to make a quick video and don't want to create an account. We won't be able to contact you for further information and you won't be able to remove your videos in the future.
										</div>
										<div style="padding-top: 15px;">
											<a href="makevideo.php">Click here to get started.</a>.
										</div>
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>