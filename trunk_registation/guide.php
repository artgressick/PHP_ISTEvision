<?php
	#include('includes/security.php');
	
	//Register the user in the database
	session_start();
	require_once ('istetube-conf.php'); //Map the Connection.
	
	
	//Get Lounges
	$q = "select id, lid, name
	FROM lounge_locations
	ORDER BY name";
	$temp_lounges = @mysql_query ($q); //Run the query.

	//Get Dates
	$q = "select date
	FROM lounge_dates
	ORDER BY date";
	$dates = @mysql_query ($q); //Run the query.
	if(!isset($_REQUEST['date'])) {
		$date = mysql_fetch_assoc($dates);
		$_REQUEST['date'] = $date['date'];
		mysql_data_seek($dates,0);
	}


	$lounges = array();
	while($row = mysql_fetch_assoc($temp_lounges)) {
		$lounges[$row['id']] = $row['name'];
	}
	
	//Get Sessions
	$q = "select kind_id, date, begin_time, end_time, location_id, presenter_id, sid
			FROM lounge_sessions
			WHERE date='".$_REQUEST['date']."'";
	$tmp_sessions = @mysql_query ($q); //Run the query.
	$sessions = array();
	while($row = mysql_fetch_assoc($tmp_sessions)) {
		$time = strtotime($row['date'].' '.$row['begin_time']);
		$end = strtotime($row['date'].' '.$row['end_time']);
		while($time < $end) {
			$sessions[$row['location_id'].'-'.$time] = array('kind'=>$row['kind_id'],'pid'=>$row['presenter_id'],'sid'=>$row['sid']);
			$time += 900;
		}
	}


	//include the header information
	#include('includes/head.php');
	#include('includes/top.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>NECC Presentation Lounges</title>
<link href="includes/main.css" rel="stylesheet" type="text/css" />
</head>

<body leftmargin="0" marginwidth="0">
<form id="form1" name="form1" method="post" action="">
	<table width="790" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td><div class="title">NECC Lounges</div></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" bgcolor="#999999">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" style="height:20px"></td>
		</tr>
		<tr>
			<td colspan="2">
<? // Start Body of Page ?>
			<table cellpadding="0" cellspacing="0" style="width:100%;">
				<tr>
					<td style="width:5px;">&nbsp;</td>
<?
					while($row = mysql_fetch_assoc($dates)) {
?>
					<td style="white-space:nowrap; width:50px; border:1px solid #666; border-bottom:none; padding:5px;<?=($_REQUEST['date']==$row['date']?'':'cursor:pointer; background:lightgrey;')?>" onclick="location.href='guide.php?date=<?=$row['date']?>'"><?=date('n/j/Y',strtotime($row['date']))?></td><td style="width:5px;">&nbsp;</td>
<?					
					}
?>
					<td>&nbsp;</td>					
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" style="width:100%; border:1px solid #666;">
				<tr>
					<td style="padding:5px;">
<?
			$col_width = floor(100 / count($lounges))
?>
						<table cellpadding="0" cellspacing="0" style="width:100%;">
							<tr>
								<th style="width:50px; border-right:1px solid #666;">&nbsp;</th>
<?
							foreach($lounges as $id => $name) {
?>
								<th style="padding:5px; text-align:left; border:1px solid #666; border-left:none; width:<?=$col_width?>%"><?=$name?></th>
<?
							}
?>								
							</tr>
<?
	$time = strtotime($_REQUEST['date'].' 6:00am');
	$end_time = strtotime($_REQUEST['date'].' 9:00pm');
	$fifteen = 900;
	$row_ct = 1;
						while($time < $end_time) {
							if($row_ct > 4) {
								$row_ct = 1;
							}
?>
							<tr>
								<td style="width:50px; border-right:1px solid #666; text-align:right; vertical-align:top;"><?=($row_ct==1?date('ga',$time):'&nbsp;')?></td>
<?
							foreach($lounges as $id => $name) {
							
							if(isset($sessions[$id.'-'.$time])) {
								if($sessions[$id.'-'.$time]['kind'] == 1) {
									$bg_color = '1f1f1f';
									$link = "";
									$cursor = 'auto';
								} else if($sessions[$id.'-'.$time]['kind'] == 0 && $sessions[$id.'-'.$time]['pid']==@$_SESSION['id']) {
									$bg_color = '1d429b';
									$link = ' onclick="location.href=\'editevent.php?sid='.$sessions[$id.'-'.$time]['sid'].'\'"';
									$cursor = 'pointer';
								} else if($sessions[$id.'-'.$time]['kind'] == 0 && $sessions[$id.'-'.$time]['pid']!=@$_SESSION['id']) {
									$bg_color = 'ff6666';
									$link = "";
									$cursor = 'auto';
								}
							
							} else {
								$bg_color = ($row_ct%2?'FFF':'EEE');
								$link = ' onclick="location.href=\'register.php?d='.$_REQUEST['date'].'&l='.$id.'&ts='.date('H:i',$time).'&te='.date('H:i',$time+900).'\'"';
								$cursor = 'pointer';
							}
?>
								<th style="padding:5px; text-align:left; border-right:1px solid #666; border-bottom:1px solid <?=($bg_color == 'FFF' || $bg_color == 'EEE' ? ($row_ct==4?'#666':'#bbb') : $bg_color)?>; width:<?=$col_width?>%; background:#<?=$bg_color?>;cursor:<?=$cursor?>;"<?=$link?>>&nbsp;</th>
<?
							}
?>								

							</tr>
<?						
							$row_ct++;
							$time += $fifteen;
						}
?>
		

							
						</table>
					</td>
				</tr>
			</table>


			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding:5px; text-align:center;">
				<table cellpadding="0" cellspacing="5" align="center">
					<tr>
						<th colspan="2">Legend</th>
					</tr>
					<tr>
						<td>Your Event(s)</td>
						<td>Reserved</td>
						<td>Black-out</td>
					</tr>
					<tr>
						<td style="background:#1d429b;">&nbsp;</td>
						<td style="background:#ff6666;">&nbsp;</td>
						<td style="background:#1f1f1f;">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><div class="copyright">NECC Lounge Assistant written by techIT Solutions</div></td>
		</tr>
	</table>
</form>
</body>
</html>