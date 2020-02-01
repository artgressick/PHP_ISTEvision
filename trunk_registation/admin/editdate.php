<?php
	include('includes/security.php');
	
	//Get the location information
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//Query 1
	$sql_query = "select id, did, DATE_FORMAT(date, '%c/%d/%Y') as day, begin_time, end_time
	FROM lounge_dates
	WHERE did = '".$_REQUEST['did']."'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	
	$date = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td class="listing_topic" style="border-bottom: 1px solid #c0c0c0;">
				Edit NECC Date
			</td>
			<td class="listing_add" style="border-bottom: 1px solid #c0c0c0;">
			
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
				<form id="form1" name="form1" method="post" action="updatedate.php">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
					<tr>
						<td>Location Name<br />
						<input name="date" type="text" id="date" size="25" maxlength="50" value="<?= $date['day'] ?>" /> (Please use format: 12/30/2009)</td></td>
					</tr>
					<tr>
						<td>Lounge Session Begin Time<br />
						<input name="begin_time" type="text" id="name" size="25" maxlength="50" value="<?=date('g:ia',strtotime($date['begin_time']))?>" /> (Please use format: 7:00am)</td>
					</tr>
					<tr>
						<td>Lounge Session End Time<br />
						<input name="end_time" type="text" id="name" size="25" maxlength="50" value="<?=date('g:ia',strtotime($date['end_time']))?>" /> (Please use format: 7:00pm)</td>
					</tr>

					<tr>
						<td style="padding-top: 15px;"><input type="submit" name="button" id="button" value="Update Date" />
						<input type="hidden" name="did" value="<?= $_REQUEST['did'] ?>"></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
<?
	#include('../includes/footer.php');
?>