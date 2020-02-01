<?php
	include('includes/security.php');
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td class="listing_topic" style="border-bottom: 1px solid #c0c0c0;">
				Add NECC Location
			</td>
			<td class="listing_add" style="border-bottom: 1px solid #c0c0c0;">
			
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
				<form id="form1" name="form1" method="post" action="insertlocation.php">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
					<tr>
						<td>Location Name<br />
						<input name="name" type="text" id="name" size="75" maxlength="150" /></td>
					</tr>
					<tr>
						<td style="padding-top: 15px;"><input type="submit" name="button" id="button" value="Add Location" /></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
<?
	#include('../includes/footer.php');
?>