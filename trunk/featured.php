<?php
	session_start(); //Do not use this code if you include the security above.
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	include('includes/_lib.php');
	
	//Get the channels that need to be displayed.
	$sql_query = "SELECT id, cid, display_order, name
	FROM channels
	WHERE visible = 1 and (select count(video_channels.id) from video_channels 
		JOIN videos ON video_channels.video_id = videos.id
		WHERE video_channels.channel_id = channels.id AND videos.video_status_id = 2 AND featured = 1) > 0
	ORDER BY display_order";
	
	$channel_result = @mysql_query ($sql_query);
	
	#Load some variables in here.
	$tab = "featured";
	$page_title = "Featured Videos";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
	
	//Start out with the first style
	$style = "1";
	
	//Counter setup
	$counter = 0
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
<?php
	//Display the list of channels
	while ($channels = mysql_fetch_array ($channel_result, MYSQL_ASSOC)) {
	
		//Get the list of videos for the channel
		$sql_query = "SELECT processed_file, title, first_name, h264, last_name, vid, description, (select count(video_id) from views where videos.id = views.video_id) as watched, iste_member
		FROM videos
		JOIN customers ON videos.customer_id = customers.id
		WHERE ftp_status > 0 and video_status_id = 2 and featured = 1 and videos.id in (SELECT video_id from video_channels where channel_id = ".$channels['id'].") 
		ORDER BY videos.created_at desc
		LIMIT 30";
		
		//Load the temp counter into memory
		$temp_counter = $counter;
		$video_results = @mysql_query ($sql_query); //Run the query.
?>		
<!-- Begin Slider Section including the Overlayer code -->
				<tr>
					<td>
						<div class="slider-header">
								Featured <?= $channels['name'] ?> <a href="channel.php?c=<?= $channels['cid'] ?>&v=4"><img src="images/goto-channel.png" alt="Go to channel" width="97" height="18" class="goto-channel" border="0" /></a>
						</div>
						<div class="slider-<?=$style?>">
							<a class="prev"></a>
							<div class="scrollable">
								<div id="thumbs">
<?
		while ($videos = mysql_fetch_array ($video_results, MYSQL_ASSOC)) {
			$counter = $counter + 1; //This will be used for the hidden divs
?>
									<div>
										<a rel="#overlay<?= $counter ?>"><img src="http://bitcast-g.bitgravity.com/techit/<?= $videos['processed_file']; ?>.jpg" width="124" height="76" border="0" title="<?= (strlen($videos['title'] . " - " .$videos['description']) > 150 ? substr($videos['title'] . " - " . $videos['description'],0,150).'...' : $videos['title'] . " - " . $videos['description'] ) ?>" /></a>
												
										<p class="thumbs_title"><a href="watch.php?vid=<?= $videos['vid']; ?>"><?= (strlen($videos['title']) > 25 ? substr($videos['title'],0,25).'...' : $videos['title'] ) ?></a></p>
										<p class="thumbs_views"><?= $videos['watched']; ?> views</p>
										<p class="thumbs_poster"><a href="watch.php?vid=<?= $videos['vid']; ?>"><?= $videos['first_name'] ?> <?= $videos['last_name'] ?></a></p>
									</div>
<?
		}
?>
								</div>
							</div>
							<a class="next"></a>
							<div class="navi"></div>
													
<!-- Code for the overlay videos. -->
<?
		
		mysql_data_seek($video_results,0);
		//Move back the counter to temp status.
		$counter = $temp_counter;
		while ($videos = mysql_fetch_array ($video_results, MYSQL_ASSOC)) {
			$counter = $counter + 1; //new code.
?>
		<div class="overlay" id="overlay<?= $counter ?>">
<?
		if(!$videos['iste_member'] || ($videos['iste_member'] && isset($_SESSION['id']) && is_numeric($_SESSION['id']))) {
?>
			<a class="myPlayer" href="http://bitcast-g.bitgravity.com/techit/<?= $videos['processed_file']; ?>.<?=($videos['h264'] == '0' ? 'flv':'mp4') ?>">
				<img src="http://bitcast-g.bitgravity.com/techit/<?= $videos['processed_file']; ?>.jpg" height="425" width="576" alt="Video" border="0"/></a>
			<div style="text-align: center; padding-top: 12px;">To view more information about this video click here: <a href="watch.php?vid=<?= $videos['vid']?>">Watch Video</a></div>

<?
		} else {
?>
			<img src="http://bitcast-g.bitgravity.com/techit/<?= $videos['processed_file']; ?>.jpg" height="425" width="576" alt="Video" border="0"/><br />
			<div style="text-align: center; padding-top: 8px;"><span style="color:red;">You must be a ISTEVision member to watch this video.</span><br />To view more information about this video click here: <a href="watch.php?vid=<?= $videos['vid']?>">Watch Video</a></div>
<?
		}
?>	
		</div>
<?
		}
?>
<!-- End code for the overlay -->
						</div>
					</td>
				</tr>
<?php
	//Important to note is that there are 4 styles or we need to rotate the styles.
	switch ($style) {
		case 1:
			$style = "2";
			break;
		case 2:
			$style = "3";
			break;
		case 3:
			$style = "4";
			break;
		case 4:
			$style = "1";
			break;
		default:
			$style = "1";
			break;
	}
	//From the Channel
	}
?>
<!-- End -->
			</table>
<!-- Javascript for Scrollable this will work for all and only needs to be declared once.-->
<script>

	var google = _gat._getTracker("UA-6291470-3");

	google._trackPageview();

	flowplayer("a.myPlayer", "includes/flowplayer-3.0.7.swf", { 
    	// product key from your account 
    	key: '$4594fc684bc3738aa7e',
    
    	// use the first frame of the video as a "splash image"
		clip: {
			// track start event for this clip
			onStart: function(clip) {
				google._trackEvent("Videos", "Play", clip.url);
			},
				
			// track pause event for this clip. time (in seconds) is also tracked
			onPause: function(clip) {
				google._trackEvent("Videos", "Pause", clip.url, parseInt(this.getTime()));
			},
				
			// track stop event for this clip. time is also tracked
			onStop: function(clip) {
				google._trackEvent("Videos", "Stop", clip.url, parseInt(this.getTime()));
			},
				
			// track finish event for this clip
			onFinish: function(clip) {
				google._trackEvent("Videos", "Finish", clip.url);
			},
			autoPlay: true,
			autoBuffering: true,
			scaling: 'fit'
		},
	
		// controlbar settings
		plugins:  {
			controls: {			
						
				// these buttons are visible
				all:false,
				scrubber:true,
				play:true,
				mute:true,
				volume: true,
				time: true,
				autoHide: 'always'
			}
		}
	});

	$(function() {		

		// setup overlay actions to buttons
		$("a[rel]").overlay({
	
			// start exposing when overlay starts to load
			onBeforeLoad: function() {
			
				// this line does the magic. it makes the background image sit on top of the mask
				this.getBackgroundImage().expose({color: '#000'});
			}, 
		
			// when overlay is closed take the expose instance and close it as well
			onClose: function() {
				$.expose.close();
			}
	
		});
		
		$("div.scrollable").scrollable({
			size: 6,
			items: '#thumbs'
			//hoverClass: 'hover'
		});

	});
</script>
<!-- End the slider -->
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>