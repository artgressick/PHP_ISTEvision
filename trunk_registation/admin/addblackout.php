<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//Get the list of the locations
	$sql_query = "select id, name
	FROM lounge_locations
	ORDER BY name";
	
	$result = @mysql_query ($sql_query); //Run the query.
	
	//$sql_query1 = $sql_query;
	
	//Get the list of the dates
	$sql_query = "select id, date, DATE_FORMAT(date, '%b %D, %Y') as day
	FROM lounge_dates
	ORDER BY date";
	
	$result2 = @mysql_query ($sql_query); //Run the query.
	
	
	
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td class="listing_topic" style="border-bottom: 1px solid #c0c0c0;">
				Add NECC Lounge Black Out Time
			</td>
			<td class="listing_add" style="border-bottom: 1px solid #c0c0c0;">
			
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
				<form id="form1" name="form1" method="post" action="insertdate.php">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
					<tr>
						<td>Lounge Location<br />
						<select name="location_id" size="1" id="select">
<?
	while ($locations = mysql_fetch_array ($result, MYSQL_ASSOC)) {
?>
							<option value="<?= $locations['id'] ?>"><?= $locations['name'] ?></option>
<?
	}
?>
						</select>
					</tr>
					<tr>
						<td>Lounge Date<br />
						<select name="date" size="1" id="select">
<?
	while ($dates = mysql_fetch_array ($result2, MYSQL_ASSOC)) {
?>
							<option value="<?= $dates['date'] ?>"><?= $dates['day'] ?></option>
<?
	}
?>
						</select>
					</tr>
					<tr>
						<td>Lounge Time<br />
				<select name="start_hour" id="start_hour">
<?
				$time = 5;
				while($time <= 20) {
?>
					<option value="<?=($time < 10?'0':'').$time?>"><?=date('g a',strtotime(($time < 10?'0':'').$time.'00'))?></option>
<?			
					$time++;
				}
?>			
				</select>
				<select name="start_min" id="start_min">
<?
				$min = 0;
				while($min <= 45) {
?>
					<option value="<?=($min < 10?'0':'').$min?>"><?=($min < 10?'0':'').$min?></option>
<?			
					$min=$min+15;
				}
?>			
				</select>

				<div>End Time</div>
				<select name="end_hour" id="end_hour">
<?
				$time = 5;
				while($time <= 20) {
?>
					<option value="<?=($time < 10?'0':'').$time?>"><?=date('g a',strtotime(($time < 10?'0':'').$time.'00'))?></option>
<?			
					$time++;
				}
?>			
				</select>
				<select name="end_min" id="end_min">
<?
				$min = 0;
				while($min <= 45) {
?>
					<option value="<?=($min < 10?'0':'').$min?>"><?=($min < 10?'0':'').$min?></option>
<?			
					$min=$min+15;
				}
?>			
				</select>
				
					</tr>
					<tr>
						<td style="padding-top: 15px;"><input type="submit" name="button" id="button" value="Add Date" /></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
<?
	#include('../includes/footer.php');
?>