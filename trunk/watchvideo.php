<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//This is for the User Profile. We need to get the information and display it on the page below.
	$sql_query = "SELECT processed_file, video_status_id, title, h264, description, first_name, last_name, DATE_FORMAT(videos.created_at, '%b %D, %Y') as day, DATE_FORMAT(videos.created_at, '%h:%i %p') as time, status, vid, admin_notes, videos.id, meta_tags, flv_status, jpg_status, ftp_status
	FROM videos
	JOIN customers on videos.customer_id = customers.id
	JOIN video_statuses ON videos.video_status_id = video_statuses.id
	WHERE videos.vid = '". $_REQUEST['vid'] . "'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$videos = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//get the video criteria
	$sql_query = "SELECT *
	FROM video_criteria
	WHERE video_criteria.video_id = '". $videos['id'] . "'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$video_criteria = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//Get the statistics for the video
	$sql_query = "SELECT COUNT(video_id) as total_views
		FROM views
		WHERE video_id = '".$videos['id']."'
		GROUP BY video_id";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$stats_total = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//Get the statistics for the video
	$sql_query = "SELECT first_name, last_name, DATE_FORMAT(views.created_at, '%b %D, %Y') as day, DATE_FORMAT(views.created_at, '%h:%i %p') as time
		FROM views
		LEFT JOIN customers ON views.customer_id = customers.id
		WHERE video_id = '".$videos['id']."'
		ORDER BY views.created_at DESC
		LIMIT 1
		";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$stats_person = mysql_fetch_array ($result, MYSQL_ASSOC);

	//include the header information
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
<!-- this is the old page -->
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="580" align="left" class="contents-watch">
						<div class="watch-title">
							<?= $videos['title']; ?>
						</div>
						<div class="watch-video">
<?
	if ($videos['ftp_status'] == "0") {
		//We have nothing to show the user so give them an image instead of the video.
?>
							<center><img src="http://www.istevision.org/images/video-processing.jpg" height="352" width="480" border="0"></center>
<?
	} else {
?>
							<center><a id="player" style="display:block; width:480px; height:352px;" href="http://bitcast-g.bitgravity.com/techit/<?= $videos['processed_file']; ?>.<?=($videos['h264'] == '0' ? 'flv':'mp4') ?>">
<?
		//if we have an image that has been completed then let's show it
		if ($videos['jpg_status'] == "1") {
?>
							<img src="http://bitcast-g.bitgravity.com/techit/<?= $videos['processed_file']; ?>.jpg" alt="Play this video" height="352" width="480" />
<?
		}
?>
							</a></center>
<!-- install player -->
<script>

$f("player", "includes/flowplayer.commercial-3.0.7.swf",  {
		
	//Our code
	key: '$4594fc684bc3738aa7e',
	
	// use the first frame of the video as a "splash image"
	clip: {
		autoPlay: true,
		autoBuffering: true,
		sclaing: 'fit'
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
</script>
<?
	}
?>								
						</div>
<?
	if ($videos['admin_notes'] != '') {
?>
						<div class="video_description" style="background: #eee; padding: 10px;">
							<strong>Notes from Administrators</strong>
						</div>
						<div class="video_description" style="background: #eee; padding: 0 10px 10px 10px;">
							<?= $videos['admin_notes']; ?>
						</div>
<?
	}
?>
						<div class="video_description" style="padding: 10px;">
							<strong>Story Description</strong>
						</div>
						<div class="video_description" style="padding: 0 10px 10px 10px;">
							<?= $videos['description']; ?>
						</div>
					</td>
					<td valign="top" width="20">
						
					</td>
					<td valign="top" width="300" align="left" style="background: #bfbfbf; padding: 10px;">
						<div style="border:solid 1px #999; padding:5px; margin-top:20px;">
							<div class="box_items"><strong>Date Entered</strong>: <?= $videos['day']; ?> </div>
							<div class="box_items" style="padding-bottom: 5px;"><strong>Video Status</strong>: <?= $videos['status']; ?></div>
							</div>
							<div class="white_box">
								<div class="box_items"><strong>Last Viewed</strong>: <?= $stats_person['day']; ?> @ <?= $stats_person['time']; ?></div>
								<div class="box_items" style="padding-bottom: 5px;"><strong>View Count</strong>: <?= $stats_total['total_views']; ?></div>
							</div>
							
							<div class="white_box">
								<div class="box_items"><strong>Education Level </strong>: 
<? //build an include file for this 
	$education_level = ""; //start with a clean state.
	
	if ($video_criteria['elevel1'] == "1") {
		$education_level .= "PK-8, ";
	}
	if ($video_criteria['elevel2'] == "1") {
		$education_level .= "9-12, ";
	}
	if ($video_criteria['elevel3'] == "1") {
		$education_level .= "Community College, ";
	}
	if ($video_criteria['elevel4'] == "1") {
		$education_level .= "University, ";
	}
	if ($video_criteria['elevel5'] == "1") {
		$education_level .= "Continuing Education, ";
	}
?>
								<?= substr($education_level, 0, -2) ?></div>
								<div class="box_items"><strong>Content Themes </strong>: 
<? //build an include file for this
	$content_themes = ""; //start with a clean state.
	
	if ($video_criteria['content1'] == "1") {
		$content_themes .= "School Improvement, ";
	}
	if ($video_criteria['content2'] == "1") {
		$content_themes .= "Ethics &amp; Equity, ";
	}
	if ($video_criteria['content3'] == "1") {
		$content_themes .= "Technology Infrastructure, ";
	}
	if ($video_criteria['content4'] == "1") {
		$content_themes .= "Professional Learning, ";
	}
	if ($video_criteria['content5'] == "1") {
		$content_themes .= "21st Century Teaching & Learning, ";
	}
	if ($video_criteria['content6'] == "1") {
		$content_themes .= "Virtual Schooling/E-learning, ";
	}
?>
								<?= substr($content_themes, 0, -2) ?></div>
								<div class="box_items"><strong>Curricular Areas </strong>: 
<? //build an include file for this
	$curricular_areas = ""; //start with a clean state.
	
	if ($video_criteria['cirricular1'] == "1") {
		$curricular_areas .= "Language Arts, ";
	}
	if ($video_criteria['cirricular2'] == "1") {
		$curricular_areas .= "Art, ";
	}
	if ($video_criteria['cirricular3'] == "1") {
		$curricular_areas .= "Math, ";
	}
	if ($video_criteria['cirricular4'] == "1") {
		$curricular_areas .= "Science, ";
	}
	if ($video_criteria['cirricular5'] == "1") {
		$curricular_areas .= "Social Studies, ";
	}
	if ($video_criteria['cirricular6'] == "1") {
		$curricular_areas .= "Music/Drama, ";
	}
	if ($video_criteria['cirricular7'] == "1") {
		$curricular_areas .= "ICT, ";
	}
	if ($video_criteria['cirricular8'] == "1") {
		$curricular_areas .= "Physical Education, ";
	}
	if ($video_criteria['cirricular9'] == "1") {
		$curricular_areas .= "Interdisciplinary, ";
	}
	if ($video_criteria['cirricular10'] == "1") {
		$curricular_areas .= "Other, ";
	}
?>
								<?= substr($curricular_areas, 0, -2) ?></div>
								<div class="box_items"><strong>Story relates to decade </strong>: 
<? //build an include file for this
	$decade = ""; //start with a clean state.
	
	if ($video_criteria['decade1'] == "1") {
		$decade .= "1979-1988, ";
	}
	if ($video_criteria['decade2'] == "1") {
		$decade .= "1989-1998, ";
	}
	if ($video_criteria['decade3'] == "1") {
		$decade .= "1999-2009, ";
	}
	if ($video_criteria['decade4'] == "1") {
		$decade .= "Future, ";
	}
?>
								<?= substr($decade, 0, -2) ?></div>
								<div class="box_items"><strong>Story relates to </strong>: 
<? //build an include file for this
	$relates = ""; //start with a clean state.
	
	if ($video_criteria['relates1'] == "1") {
		$relates .= "Educational transformation, ";
	}
	if ($video_criteria['relates2'] == "1") {
		$relates .= "ISTE, ";
	}
	if ($video_criteria['relates3'] == "1") {
		$relates .= "NECC, ";
	}
	if ($video_criteria['relates4'] == "1") {
		$relates .= "General Ed Tech, ";
	}
	if ($video_criteria['relates5'] == "1") {
		$relates .= "Other, ";
	}
?>
								<?= substr($relates, 0, -2) ?></div>
								<div class="box_items" style="padding-bottom: 5px;"><strong>Meta Tags </strong>: <?= $videos['meta_tags']; ?></div>
						</div>							
					</td>
				</tr>
			</table>
<!-- end of old page -->
		</td>
	</tr>
</table>
<?
	include('includes/page-bottom.php');
?>