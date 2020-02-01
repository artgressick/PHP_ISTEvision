<?php
	include('includes/security.php');
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td style="border-bottom: 1px solid #c0c0c0; text-align: left; font-size: 14px; font-weight: bold;">
				Add Channel
			</td>
			<td style="border-bottom: 1px solid #c0c0c0;">
			
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2" style="text-align: left;">
				<form id="form1" name="form1" method="post" action="insertchannel.php">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
					<tr>
						<td valign="top" width="50%">
							<div class="form_div">
								<span class="form_required">Channel Name</span><br />
								<input name="name" type="text" id="name" size="50" maxlength="75" />
							</div>
							
							<div class="form_div">
								<span class="form_required">Display Order</span><br />
								<input name="display_order" type="text" id="display_order" size="5" maxlength="5" /> (from 0 to 999)
							</div>
						</td>
						<td valign="top" width="50%">
							<div class="form_div">
								<span class="form_required">Display on Homepage</span><br />
								<input type="radio" name="homepage" id="homepage" value="1" /> Yes <input type="radio" name="homepage" id="homepage" value="0" checked /> No
							</div>
							
							<div class="form_div">
								<span class="form_required">Members Can Upload to this channel</span><br />
								<input type="radio" name="uploadable" id="uploadable" value="1" /> Yes <input type="radio" name="uploadable" id="uploadable" value="0" checked /> No
							</div>
							
							<div class="form_div">
								<span class="form_required">Visible to members</span><br />
								<input type="radio" name="visible" id="visible" value="1" checked /> Yes <input type="radio" name="visible" id="visible" value="0" /> No
							</div>
						</td>
					</tr>
					<tr>
						<td style="padding-top: 15px;" colspan="2"><input type="submit" name="button" id="button" value="Add Channel" /></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
<?
	include('includes/footer.php');
?>