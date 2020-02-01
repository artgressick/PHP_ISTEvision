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
		<td class="contents">
			<form id="login" name="login" method="post" action="checklogin.php">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
        				
        			<td bgcolor="#ffffff" align="center" height="300">
         				<div></div>
        				<div style="padding-bottom: 15px; font-weight: bold;">Sign In</div>
						<div>
							<span style="font-weight: bold;">Email Address</span><br />
							<input name="email" type="text" id="email" size="23" maxlength="100" />
						</div>
						<div>
							<span style="font-weight: bold;">Password</span><br />
							<input name="password" type="password" id="password" size="23" maxlength="25" />
							<input name="user" type="hidden" value="<?= $_REQUEST['type']?>">
						</div>
						<div style="padding-top: 10px;">
							<input type="hidden" name="key" id="key" value="<?=$_REQUEST['type']?>" />
							<input type="submit" name="login" id="login" value="Login" />
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
?>