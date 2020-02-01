<?php
	//include('includes/security.php');
	session_start(); //Do not use this code if you include the security above.
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	#SQL goes in here
	$sql_query = "SELECT cid, display_order, name,
	(SELECT processed_file FROM videos JOIN video_channels ON videos.id = video_channels.video_id
	WHERE video_channels.channel_id = channels.id and video_status_id = 2 order by created_at desc limit 1) as image
	FROM channels
	WHERE visible = 1 and homepage = 1 and (select count(video_channels.id) from video_channels 
		JOIN videos ON video_channels.video_id = videos.id
		WHERE video_channels.channel_id = channels.id AND videos.video_status_id = 2) > 0
	ORDER BY display_order";
	
	$result = @mysql_query ($sql_query);
	
	#Load some variables in here.
	$tab = "live";
	$page_title = "Welcome";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="contents-live" valign="top">
						<div class="count-down" style="display:none;">
							<div style="text-align: center; font-size: 14px; color: #000000; padding: 10px;">
								The next session will be available in...
							</div>
							<div>
								<script language="JavaScript">
									TargetDate = "06/30/2009 7:00 AM UTC-0500";
									BackColor = "white";
									ForeColor = "black";
									CountActive = true;
									CountStepper = -1;
									LeadingZero = true;
									DisplayFormat = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
									FinishMessage = "NECC is Live!";
								</script>
								<script language="JavaScript" src="includes/counter.js"></script>
							</div>
							<table cellpadding="5" cellspacing="0">
								<tr>
									<td id='time_days'></td>
									<td>Days</td>
									<td id='time_hours'></td>
									<td>Hours</td>
									<td id='time_minutes'></td>
									<td>Minutes</td>
									<td id='time_seconds'></td>
									<td>Seconds</td>
								</tr>
							</table>
							<script language="Javascript">
								document.getElementById('time_seconds').innerHTML = "<img src='images/counter/"+seconds0+".gif' /><img src='images/counter/"+seconds1+".gif' />";
								document.getElementById('time_minutes').innerHTML = "<img src='images/counter/"+minutes0+".gif' /><img src='images/counter/"+minutes1+".gif' />";
								document.getElementById('time_hours').innerHTML = "<img src='images/counter/"+hours0+".gif' /><img src='images/counter/"+hours1+".gif' />";
								document.getElementById('time_days').innerHTML = "<img src='images/counter/"+days0+".gif' /><img src='images/counter/"+days1+".gif' />";    
							</script>
						</div>
					</td>
					<td class="contents-live-sidebar" align="center" valign="top">
<?php
	while ($channels = mysql_fetch_array ($result, MYSQL_ASSOC)) {
?>						
						<div class="sidebar-bubble-top"><?= $channels['name'] ?></div>
						<div class="sidebar-bubble-image"><a href="channel.php?c=<?= $channels['cid'] ?>&v=1"><img src="http://bitcast-g.bitgravity.com/techit/<?= $channels['image'] ?>.jpg" alt="Click Here" width="198" height="150" border="0" /></a></div>
						<div class="sidebar-bubble-bottom"><a href="channel.php?c=<?= $channels['cid'] ?>&v=1">Watch This Channel</a></div>
<?php
	}
?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>