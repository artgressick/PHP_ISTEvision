<?php
	include('includes/security.php');
	
	//Get the location information
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//Query 1
	$sql_query = "select id, lid, name
	FROM lounge_locations
	WHERE lid = '".$_REQUEST['lid']."'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	
	$locations = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td class="listing_topic" style="border-bottom: 1px solid #c0c0c0;">
				Edit NECC Location
			</td>
			<td class="listing_add" style="border-bottom: 1px solid #c0c0c0;">
			
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
				<form id="form1" name="form1" method="post" action="updatelocation.php">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
					<tr>
						<td>Location Name<br />
						<input name="name" type="text" id="name" size="75" maxlength="150" value="<?= $locations['name'] ?>" /></td>
					</tr>
					<tr>
						<td style="padding-top: 15px;"><input type="submit" name="button" id="button" value="Update Location" />
						<input type="hidden" name="lid" value="<?= $_REQUEST['lid'] ?>"></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
<?
	#include('../includes/footer.php');
?>