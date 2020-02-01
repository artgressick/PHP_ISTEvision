<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//This is for the User Profile. We need to get the information and display it on the page below.
	$sql_query = "select videos.id, processed_file, video_status_id, title, description, first_name, last_name, DATE_FORMAT(videos.created_at, '%b %D, %Y') as day, DATE_FORMAT(videos.created_at, '%h:%i %p') as time, admin_notes, meta_tags, flv_status, jpg_status
	FROM videos
	JOIN customers on videos.customer_id = customers.id
	WHERE videos.vid = '". $_REQUEST['vid'] . "'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$videos = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//get the video criteria
	$sql_query = "SELECT *
	FROM video_criteria
	WHERE video_criteria.video_id = '". $videos['id'] . "'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$video_criteria = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//video statuses
	$sql_query = "select id, status
	FROM video_statuses
	ORDER BY id";
	
	$result2 = @mysql_query ($sql_query); //Run the query.
	
	//Get the statistics for the video
	$sql_query = "SELECT COUNT(video_id) as total_views
		FROM views
		WHERE video_id = '".$videos['id']."'
		GROUP BY video_id";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$stats_total = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//Get the statistics for the video
	$sql_query = "SELECT first_name, last_name, DATE_FORMAT(views.created_at, '%M %D, %Y') as day, DATE_FORMAT(views.created_at, '%h:%i %p') as time
		FROM views
		LEFT JOIN customers ON views.customer_id = customers.id
		WHERE video_id = '".$videos['id']."'
		ORDER BY views.created_at DESC
		LIMIT 1
		";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$stats_person = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
  		<tr>
			<td width="100%" colspan="2" valign="top">
				<form id="form1" name="approval" method="post" action="updateapproval.php">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" width="580">
							<div class="video_title">
								<?= $videos['title']; ?>
							</div>
							<div class="video_playback_big">
<?
	if ($videos['flv_status'] == "0") {
		//We have nothing to show the user so give them an image instead of the video.
?>
								<center><img src="../images/video-processing.jpg" height="352" width="480" border="0"></center>
<?
	} else {
?>
								<center><a id="player" style="display:block; width:480px; height:352px;" href="<?= $BF; ?>videos/flv/<?= $videos['processed_file']; ?>.flv">
<?
		//if we have an image that has been completed then let's show it
		if ($videos['jpg_status'] == "1") {
?>
									<img src="../videos/jpg/<?= $videos['processed_file']; ?>.jpg" alt="Play this video" height="352" width="480" />
<?
		}
?>
								</a></center>
								
<!-- install player -->
<script>

$f("player", "../includes/flowplayer-3.0.3.swf",  {
		
	// use the first frame of the video as a "splash image"
	clip: {
		autoPlay: false,
		autoBuffering: true
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
			
			// custom colors
			//bufferColor: '#333333',
			//progressColor: '#cc0000',			
			//buttonColor: '#cc0000',
			//buttonOverColor: '#ff0000',
			
			// custom height
			//height: 30,
			
			// setup auto hide
			autoHide: 'always',
			
			
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
							<div class="video_description">
								<p><strong>Video Description</strong>:</p>
								<p><?= $videos['description']; ?></p>
							</div>
							
							<div style="background: #dfdfdf; text-align:left;">
								<div class="form_div" style="padding: 5px;">
									<strong>Video Status</strong>: <select name="video_status_id" size="1" id="video_status_id">
<?
	while ($statuses = mysql_fetch_array ($result2, MYSQL_ASSOC)) {
?>
                	  				<option value="<?= $statuses['id'] ?>" <?=($statuses['id']==$videos['video_status_id']?'selected':'') ?>><?= $statuses['status'] ?></option>
<?
	}
?>
            						</select>
            					</div>
            					<div class="form_div" style="padding: 5px;">
									<strong>Notes to Poster</strong> <span style="font-size:10px; color:#00F;">(If you reject a video please tell them why below.)</span><br />
									<textarea name="admin_notes" cols="75" rows="5" id="admin_notes" wrap="virtual"><?= $videos['admin_notes']; ?></textarea>
								</div>
								<div class="form_div" style="padding: 5px;">
									<input type="submit" name="approval" id="approval" value="Update status and post notes" /><input  type="hidden" name="vid" value="<?= $_REQUEST['vid']; ?>" />
								</div>
							</div>
						</td>
						<td valign="top" width="20">
						
						</td>
						<td valign="top" width="300" align="left">
							<div class="white_box">
								<div class="box_items"><strong>Customer</strong>: <?= $videos['first_name']; ?> <?= $videos['last_name']; ?></div>
								<div class="box_items" style="padding-bottom: 5px;"><strong>Date Entered</strong>: <?= $videos['day']; ?> @ <?= $videos['time']; ?></div>
							</div>
							<div class="gray_box">
								<div class="box_items"><strong>Last Viewed</strong>: <?= $stats_person['day']; ?> @ <?= $stats_person['time']; ?></div>
								<div class="box_items" style="padding-bottom: 5px;"><strong>View Count</strong>: <?= $stats_total['total_views']; ?></div>
							</div>

							<div class="white_box">
								<div class="box_items"><strong>Education Level</strong>: 
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
								<div class="box_items"><strong>Content Themes</strong>: 
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
								<div class="box_items"><strong>Curricular Areas</strong>: 
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
								<div class="box_items"><strong>Story relates to decade</strong>: 
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
								<div class="box_items"><strong>Story relates to</strong>: 
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
								<div class="box_items" style="padding-bottom: 5px;"><strong>Meta Tags</strong>: <?= $videos['meta_tags']; ?></div>
							</div>
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
<?
	include('includes/footer.php');
?>