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
	WHERE visible = 1 and (select count(video_channels.id) from video_channels 
		JOIN videos ON video_channels.video_id = videos.id
		WHERE video_channels.channel_id = channels.id AND videos.video_status_id = 2) > 0
	ORDER BY display_order";
	
	$result = @mysql_query ($sql_query);
	
	#Load some variables in here.
	$tab = "channels";
	$page_title = "Channels";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
<?php
	//We can only fit 4 channels wide.
	$counter = 0;
	$maxwide = 4;
	
	//predictive
	//$totalrecords = mysql_num_rows($result);
	
	while ($channels = mysql_fetch_array ($result, MYSQL_ASSOC)) {
?>
					<td align="center" width="25%">
						<div class="channel-bubble-top"><a href="channel.php?c=<?= $channels['cid'] ?>&v=1" style="text-decoration: none; color: #fff;"><?= $channels['name'] ?></a></div>
						<div class="channel-bubble-image"><a href="channel.php?c=<?= $channels['cid'] ?>&v=1"><img src="http://bitcast-g.bitgravity.com/techit/<?= $channels['image'] ?>.jpg" alt="information here" width="198" height="150" border="0" /></a></div>
						<div class="channel-bubble-links">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td><div class="channel-bubble-link"><a href="channel.php?c=<?= $channels['cid'] ?>&v=1">Featured</a></div></td>
									<td><div class="goto-image"><a href="channel.php?c=<?= $channels['cid'] ?>&v=1"><img src="images/goto.gif" alt="goto" width="18" height="18" border="0" vspace="5" /></a></div></td>
								</tr>
								<tr>
									<td><div class="channel-bubble-link"><a href="channel.php?c=<?= $channels['cid'] ?>&v=2">Most Popular</a></div></td>
									<td><div class="goto-image"><a href="channel.php?c=<?= $channels['cid'] ?>&v=2"><img src="images/goto.gif" alt="goto" width="18" height="18" border="0" vspace="5" /></a></div></td>
								</tr>
								<tr>
									<td><div class="channel-bubble-link"><a href="channel.php?c=<?= $channels['cid'] ?>&v=3">Top Rated</a></div></td>
									<td><div class="goto-image"><a href="channel.php?c=<?= $channels['cid'] ?>&v=3"><img src="images/goto.gif" alt="goto" width="18" height="18" border="0" vspace="5" /></a></div></td>
								</tr>								
							</table>
						</div>
					</td>
<?php
		$counter = $counter + 1;
		if ($counter == $maxwide) {
			$counter = 0;
?>
				</tr>
				<tr>
<?php
		}
	}
	
	//we might need to add some blank cells and then close out the column
	$leftover = $maxwide - $counter;
	if ($counter < $maxwide) {
?>
					<td align="center" colspan="<?= $leftover ?>" width="<?= $leftover*25 ?>"></td>
<?php
	}
?>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>