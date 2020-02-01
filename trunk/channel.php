<?php
	//include('includes/security.php');
	session_start(); //Do not use this code if you include the security above.
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	$sql_query = "SELECT id, name
	FROM channels
	WHERE cid = '".$_REQUEST['c']."'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$channel = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//Get the list of videos to watch.
	$sql_query = "SELECT processed_file, title, first_name, h264, last_name, vid, description, (select count(video_id) from views where videos.id = views.video_id) as watched, iste_member
	FROM videos
	JOIN customers ON videos.customer_id = customers.id
	WHERE ftp_status > 0 and video_status_id = 2 and videos.id in (SELECT video_id from video_channels where channel_id = ".$channel['id'].") ";
	
	//Add in the selected criteria
	switch ($_REQUEST['v']) {
		case 1:
			$sql_query .= "and videos.featured = 1 ORDER BY RAND()";
			break;
		case 2:
			$sql_query .= "ORDER BY watched DESC ";
			break;
		case 3:
			$sql_query .= "ORDER BY watched DESC ";
			break;
		case 4:
			$sql_query .= "ORDER BY RAND()";
			break;
		default:
			$sql_query .= "ORDER BY RAND()";
			break;
	}
	
	//finish the query
	//$sql_query .= "ORDER BY RAND()";
	
	$results = @mysql_query ($sql_query); //Run the query.
	
	#Load some variables in here.
	$tab = "channels";
	$page_title = $channel['name'];
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						<div class="topic-title"><?= $channel['name'] ?></div>
					</td>
				</tr>
				<tr>
					<td class="sub-navigation">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="15%">
<?php
	//This is the Just Added Section
	if ($_REQUEST['v'] == 1) {
?>
									<div class="sub-nav-leftactive"></div>
									<div class="sub-nav-active"><a href="channel.php?c=<?= $_REQUEST['c'] ?>&v=1">Featured</a></div>
									<div class="sub-nav-rightactive"></div>
<?php
	} else {
?>
									<div class="sub-nav-inactive">
										<a href="channel.php?c=<?= $_REQUEST['c'] ?>&v=1">Featured</a
									</div>
<?php
	}
?>
								</td>
								<td width="15%">
<?php
	//This is theMost Popular Section
	if ($_REQUEST['v'] == 2) {
?>
									<div class="sub-nav-leftactive"></div>
									<div class="sub-nav-active"><a href="channel.php?c=<?= $_REQUEST['c'] ?>&v=2">Most Popular</a></div>
									<div class="sub-nav-rightactive"></div>
<?php
	} else {
?>
									<div class="sub-nav-inactive">
										<a href="channel.php?c=<?= $_REQUEST['c'] ?>&v=2">Most Popular</a>
									</div>
<?php
	}
?>
								</td>
								<td width="15%">
<?php
	//This is theMost Popular Section
	if ($_REQUEST['v'] == 3) {
?>
									<div class="sub-nav-leftactive"></div>
									<div class="sub-nav-active"><a href="channel.php?c=<?= $_REQUEST['c'] ?>&v=3">Top Rated</a></div>
									<div class="sub-nav-rightactive"></div>
<?php
	} else {
?>
									<div class="sub-nav-inactive">
										<a href="channel.php?c=<?= $_REQUEST['c'] ?>&v=3">Top Rated</a>
									</div>
<?php
	}
?>
								</td>
								<td width="15%">
<?php
	//This is theMost Popular Section
	if ($_REQUEST['v'] == 4) {
?>
									<div class="sub-nav-leftactive"></div>
									<div class="sub-nav-active"><a href="channel.php?c=<?= $_REQUEST['c'] ?>&v=4">All Videos</a></div>
									<div class="sub-nav-rightactive"></div>
<?php
	} else {
?>
									<div class="sub-nav-inactive">
										<a href="channel.php?c=<?= $_REQUEST['c'] ?>&v=4">All Videos</a>
									</div>
<?php
	}
?>
								</td>
								<td align="right" width="40%">
									<div style="padding-right: 10px;">
										<form id="form1" name="form1" method="post" action="search.php" class="search" style="margin:0; padding:0;">
											<input type="hidden" name="channel_id" value="<?= $channel['id'] ?>"><input type="search" name="criteria" id="criteria" />
										</form>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<div class="contents-inner">
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
<?php
	//We can only fit 4 channels wide.
	$counter = 0;
	$maxwide = 5;
	$popup = 0;
	
	//predictive
	//$totalrecords = mysql_num_rows($result);
	
	while ($videos = mysql_fetch_array ($results, MYSQL_ASSOC)) {
		$popup = $popup + 1;
?>
									<td align="center" width="20%" valign="top" style="padding-top: 10px;">
<!-- visible thumbnail part -->
										<div style="width: 144px;">
											<div style="border-left: solid 1px #696969; border-right: solid 1px #696969; border-top: solid 1px #696969;"><a rel="#overlay<?= $popup ?>" style="cursor: pointer"><img src="http://bitcast-g.bitgravity.com/techit/<?= $videos['processed_file']; ?>.jpg" width="142" height="107" border="0" title="<?= (strlen($videos['title'] . " - " .$videos['description']) > 150 ? substr($videos['title'] . " - " . $videos['description'],0,150).'...' : $videos['title'] . " - " . $videos['description'] ) ?>" /></a></div>
											
											<div class="thumb-title" style="background-color: #ffffff; border-left: solid 1px #696969; border-right: solid 1px #696969; color: #000000; height: 35px;"><a href="watch.php?vid=<?= $videos['vid']; ?>"><?= (strlen($videos['title']) > 25 ? substr($videos['title'],0,25).'...' : $videos['title'] ) ?></a></div>
											
											<div class="thumb-views" style="background-color: #ffffff; border-left: solid 1px #696969; border-right: solid 1px #696969; color: #000000;"><?= $videos['watched']; ?> views</div>
											
											<div class="thumb-user" style="background-color: #ffffff; border-left: solid 1px #696969; border-right: solid 1px #696969; color: #000000; padding-bottom: 5px;"><a href="watch.php?vid=<?= $videos['vid']; ?>"><?= $videos['first_name'] ?> <?= $videos['last_name'] ?></a></div>
										</div>
<!-- hidden popup div -->
										<div class="overlay" id="overlay<?= $popup ?>">
<?
		if(!$videos['iste_member'] || ($videos['iste_member'] && isset($_SESSION['id']) && is_numeric($_SESSION['id']))) {
?>
											<a class="myPlayer" href="http://bitcast-g.bitgravity.com/techit/<?= $videos['processed_file']; ?>.<?=($videos['h264'] == '0' ? 'flv':'mp4') ?>">
												<img src="http://bitcast-g.bitgravity.com/techit/<?= $videos['processed_file']; ?>.jpg" height="425" width="576" alt="Video" border="0"/>
											</a>
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
									<td align="center" colspan="<?= $leftover ?>" width="<?= $leftover*20 ?>"></td>
<?php
	}
?>								
								</tr>
							</table>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- Javascript for Scrollable this will work for all and only needs to be declared once.-->
<script>

flowplayer("a.myPlayer", "includes/flowplayer-3.0.7.swf", { 
    // product key from your account 
    key: '$4594fc684bc3738aa7e',
    
    // use the first frame of the video as a "splash image"
	clip: {
		// track start event for this clip
		onStart: function(clip) {
			google._trackPageview("start: " + clip.url);
		},
		// track finish event for this clip
		onFinish: function(clip) {
			google._trackPageview("finish: " + clip.url);
		},
		autoPlay: true,
		autoBuffering: true,
		scaling: 'fit'
	},
	
	// controlbar settings
	plugins:  {
		controls: {			
			
			// setup a background image
			//background: 'url(images/videooverlay-big.jpg) repeat',
			
			/* you may want to remove the gradient */
			// backgroundGradient: 'none',
			
			// these buttons are visible
			all:false,
			scrubber:true,
			play:true,
			mute:true,
			volume: true,
			time: true,
			
			// custom colors
			//bufferColor: '#333333',
			//progressColor: '#cc0000',			
			//buttonColor: '#cc0000',
			//buttonOverColor: '#ff0000',
			
			// custom height
			//height: 30,
			
			// setup auto hide
			autoHide: 'always'
			
			
			// a little more styling 			
			//width: '98%', 
			//bottom: 5,
			//left: '50%',
			//borderRadius: 15
			
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

});
</script>
<!-- End the slider -->
<?php
	include('includes/page-bottom.php');
?>