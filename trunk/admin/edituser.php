<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//This is for the User Profile. We need to get the information and display it on the page below.
	$sql_query = "select id, super, first_name, last_name, email
	FROM administrators
	WHERE aid = '".$_REQUEST['aid']."'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$admin = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//Get the list of channels they can administer
	$sql_query = "select id, name, (SELECT admin_channels.id FROM admin_channels WHERE channels.id = admin_channels.channel_id and admin_channels.administrator_id = ".$admin['id'].") as selected
	FROM channels
	ORDER BY name ";
	
	$sql_master = $sql_query;
	
	$result = @mysql_query ($sql_query); //Run the query.
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td style="border-bottom: 1px solid #c0c0c0; text-align: left; font-size: 14px; font-weight: bold;">
				Edit Administrator
			</td>
			<td style="border-bottom: 1px solid #c0c0c0;">
			
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2" style="text-align: left;">
				<form id="form1" name="form1" method="post" action="updateuser.php">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
					<tr>
						<td valign="top" width="50%">
							<div class="form_div">
								<span class="form_required">First Name</span><br />
								<input name="first_name" type="text" id="first_name" size="50" maxlength="50" value="<?= $admin['first_name'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_required">Last Name</span><br />
								<input name="last_name" type="text" id="last_name" size="50" maxlength="50" value="<?= $admin['last_name'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_required">Email</span> (cannot be changed)<br />
								<input name="email" type="text" id="email" size="50" maxlength="100" value="<?= $admin['email'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_required">New Password</span> (leave blank unless changing)<br />
								<input name="password" type="password" id="password" size="20" maxlength="25" />
							</div>
							<div class="form_div">
								<span class="form_required">Super Admin?</span><br />
								<input type="radio" name="super" id="super" value="1" <?=($admin['super']=="1"?"checked":"") ?> /> Yes <input type="radio" name="super" id="super" value="0" <?=($admin['super']=="0"?"checked":"") ?> /> No
							</div>
						</td>
						<td valign="top" width="50%">
							<div class="form_div">
								<span class="form_required">Channels they have access to:</span> (Only necessary for regular Admins)<br />
<?php
	while ($channels = mysql_fetch_array ($result, MYSQL_ASSOC)) {
?>
								<input type="checkbox" id="<?= $channels['id'] ?>" name="<?= $channels['id'] ?>" value="<?= $channels['id'] ?>" <?=($channels['selected'] > "0" ? 'checked' : '') ?> /><?= $channels['name'] ?><br />
<?php
	}
?>
							</div>
							
							
						</td>
					</tr>
					<tr>
						<td style="padding-top: 15px;" colspan="2"><input type="submit" name="button" id="button" value="Update Administrator" />
						<input name="id" type="hidden" value="<?= $admin['id'] ?>"></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
<?
	include('includes/footer.php');
?>