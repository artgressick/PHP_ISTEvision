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
					<td class="contents-live" valign="top" align="center">
						<div style="padding-top: 100px;">
<!--
/**
 * Copy and paste this HTML snippet between the <body></body> tags of your webpage
 * to embed the video player directly into your page.
 * You may alter the size of the video by changing the playerWidth or playerHeight.
 */
-->
<div id="bg_player_location">
<a href="http://www.adobe.com/go/getflashplayer">
<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
</a>
</div>
<script type="text/javascript" src="http://bitcast-b.bitgravity.com/player/6/functions.js"></script>
<script type="text/javascript">
// <![CDATA[
var flashvars = {};
var playerWidth = 480;
var playerHeight = 320 + 20; // adjust for the "toolbar" at the bottom
flashvars.File = "http://bglive-a.bitgravity.com/techitlive/live/stream";
flashvars.Mode = "live";
flashvars.AutoPlay = "true";
flashvars.ScrubMode = "simple";
flashvars.BufferTime = "1.5";
flashvars.VideoFit = "automatic";
flashvars.DefaultRatio = "1.5";
flashvars.LogoPosition = "topleft";
flashvars.ColorBase = "#FFFFFF";
flashvars.ColorControl = "#666666";
flashvars.ColorHighlight = "#7FBF3C";
flashvars.ColorFeature = "#7FBF3C";
var params = {};
params.allowFullScreen = "true";
params.allowScriptAccess = "always";
var attributes = {};
attributes.id = "bitgravity_player_6";
swfobject.embedSWF(stablerelease, "bg_player_location", playerWidth, playerHeight, "9.0.0", "http://bitcast-b.bitgravity.com/player/expressInstall.swf", flashvars, params, attributes);
// ]]>
</script>
<div id="bg_player_location"></div>
<!-- This is the end of the bit gravity code. -->					
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