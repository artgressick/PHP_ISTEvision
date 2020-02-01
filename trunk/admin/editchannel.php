<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//This is for the User Profile. We need to get the information and display it on the page below.
	$sql_query = "select homepage, uploadable, visible, display_order, name
	FROM channels
	WHERE cid = '".$_REQUEST['cid']."'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$channel = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td style="border-bottom: 1px solid #c0c0c0; text-align: left; font-size: 14px; font-weight: bold;">
				Edit Channel
			</td>
			<td style="border-bottom: 1px solid #c0c0c0;">
			
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2" style="text-align: left;">
				<form id="form1" name="form1" method="post" action="updatechannel.php">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
					<tr>
						<td valign="top" width="50%">
							<div class="form_div">
								<span class="form_required">Channel Name</span><br />
								<input name="name" type="text" id="name" size="50" maxlength="75" value="<?= $channel['name'] ?>" />
							</div>
							
							<div class="form_div">
								<span class="form_required">Display Order</span><br />
								<input name="display_order" type="text" id="display_order" size="5" maxlength="5" value="<?= $channel['display_order'] ?>" /> (from 0 to 999)
							</div>
						</td>
						<td valign="top" width="50%">
							<div class="form_div">
								<span class="form_required">Display on Homepage</span><br />
								<input type="radio" name="homepage" id="homepage" value="1" <?=($channel['homepage']=="1"?"checked":"") ?> /> Yes <input type="radio" name="homepage" id="homepage" value="0" <?=($channel['homepage']=="0"?"checked":"") ?> /> No
							</div>
							
							<div class="form_div">
								<span class="form_required">Members Can Upload to this channel</span><br />
								<input type="radio" name="uploadable" id="uploadable" value="1" <?=($channel['uploadable']=="1"?"checked":"") ?> /> Yes <input type="radio" name="uploadable" id="uploadable" value="0" <?=($channel['uploadable']=="0"?"checked":"") ?> /> No
							</div>
							
							<div class="form_div">
								<span class="form_required">Visible to members</span><br />
								<input type="radio" name="visible" id="visible" value="1" <?=($channel['visible']=="1"?"checked":"") ?> /> Yes <input type="radio" name="visible" id="visible" value="0" <?=($channel['visible']=="0"?"checked":"") ?> /> No
							</div>
						</td>
					</tr>
					<tr>
						<td style="padding-top: 15px;" colspan="2"><input type="submit" name="button" id="button" value="Update Channel" />
						<input name="cid" type="hidden" value="<?= $_REQUEST['cid'] ?>"></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
<?
	include('includes/footer.php');
?>