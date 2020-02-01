<?php
	//include('includes/security.php');
	session_start(); //Do not use this code if you include the security above.
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//This is for the User Profile. We need to get the information and display it on the page below.
	$sql_query = "SELECT videos.id, processed_file, video_status_id, title, description, first_name, last_name, DATE_FORMAT(videos.created_at, '%b %D, %Y') as day, iste_member,  DATE_FORMAT(videos.created_at, '%h:%i %p') as time, status, vid, admin_notes, videos.id, flv_status, jpg_status, ftp_status, meta_tags
	FROM videos
	JOIN customers on videos.customer_id = customers.id
	JOIN video_statuses ON videos.video_status_id = video_statuses.id
	WHERE videos.vid = '". $_REQUEST['vid'] . "'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$videos = mysql_fetch_array ($result, MYSQL_ASSOC);
		
	//Get the statistics for the video
	$sql_query = "SELECT COUNT(video_id) as total_views
		FROM views
		WHERE video_id = '".$videos['id']."'
		GROUP BY video_id";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$stats_total = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//stats
	
	$sql_query = "INSERT INTO views SET
		video_id = '".$videos['id']."',
		customer_id = '".$_SESSION['id']."',
		created_at = '".date('Y-m-d H:i:s')."',
		session_id = '".session_id()."'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	// ------------- DONE ---------------------------------------------	
	
	function sith() {
?>
	<script src="includes/ajax.js"></script>
	<script type='text/javascript'>
		function exp_cont(id) {
			var box = document.getElementById("related_"+id);
			if(box) {
				var arrow = document.getElementById("arrow_"+id);
				if(box.style.display == "none") { //compressed
					box.style.display = "";
					arrow.src = "images/arrow-expand.gif";
				} else {	//expanded
					box.style.display = "none";
					arrow.src = "images/arrow-compress.gif";
				}
			}
		}
		function caption_change(field) {
			if(field == 'vid_desc') {
				document.getElementById('vid_comm').style.display = 'none';
				document.getElementById('vid_desc').style.display = '';
				document.getElementById('vid_desc_tab').className = 'video_tab_top_active';
				document.getElementById('vid_comm_tab').className = 'video_tab_top_inactive';
			} else {
				document.getElementById('vid_desc').style.display = 'none';
				document.getElementById('vid_comm').style.display = '';
				document.getElementById('vid_comm_tab').className = 'video_tab_top_active';
				document.getElementById('vid_desc_tab').className = 'video_tab_top_inactive';
			}
		}
		function char_counter(field, cntfield, maxlimit) {
			if(document.getElementById(field).value.length > 0) {
				document.getElementById('submit_comment').style.display='';;
			} else {
				document.getElementById('submit_comment').style.display = 'none';
			}
			if(document.getElementById(field).value.length > maxlimit) {
				document.getElementById(field).value = document.getElementById(field).value.substring(0, maxlimit);
			} else {
				document.getElementById(cntfield).value = maxlimit - document.getElementById(field).value.length;
			}
		}
	</script>
<?php
	}
	
	$bodyParams = "get_comments('','".$videos['id']."');";
	
	
	#Load some variables in here.
	$tab = "channels";
	$page_title = $videos['title'];
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="420" class="contents-watch" valign="top">
						<div class="watch-title"><?= (strlen($videos['title']) > 50 ? substr($videos['title'],0,50).'...' : $videos['title'] ) ?>
						</div>
						<div class="watch-video">
<?
	if ($videos['video_status_id'] !== "2") {
		//We have nothing to show the user so give them an image instead of the video.
?>
							<center><img src="images/video-removed.jpg" height="286" width="380" border="0"></center>
<?
	} else if ($videos['ftp_status'] == "0") {
?>
							<center><img src="images/video-processing.jpg" height="286" width="380" border="0"></center>
<?
	} else {
		if(!$videos['iste_member'] || ($videos['iste_member'] && isset($_SESSION['id']) && is_numeric($_SESSION['id']))) {
?>
							<center><div id="player" style="display:block; width:380px; height:286px;"></div></center>
<!-- install player -->
<script>

	var google = _gat._getTracker("UA-6291470-3");
	
	google._trackPageview();

	$f("player", "includes/flowplayer-3.1.1.swf",  {

		//Our code
		//key: '$4594fc684bc3738aa7e',
			
		// use the first frame of the video as a "splash image"
		playlist: [
			//Show an image
			{
				url: 'http://bitcast-g.bitgravity.com/techit/<?= $videos['processed_file']; ?>.jpg',
				scaling: 'fit'
			},
			//Play the video
			{
				url: 'http://bitcast-g.bitgravity.com/techit/h264-malcolm.mp4',
				provider: 'bitgravity',
				//Google Analytics
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
        
				autoPlay: false,
				autoBuffering: false,
				scaling: 'fit'
			}
		],
	
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
			},
			
			bitgravity: {
				url: 'includes/flowplayer.pseudostreaming-3.1.2.swf',
				
				// use ${start} as a placeholder for the target keyframe
				queryString: escape('?starttime=${start}') 
			} 
		}
	});
</script>
<?
		} else {
?>
							<center><img src="http://bitcast-g.bitgravity.com/techit/<?= $videos['processed_file']; ?>.jpg" style="" /></center>
							<div style='padding-top:15px; color:yellow; font-weight:bold;'>You must be a ISTEVision member to watch this video. <br /><a href="login.php" style="color:yellow;">Sign In</a> or <a href="createaccount.php" style="color:yellow;">Register</a></div>
<?
		}

	}
?>
						</div>
						<div>
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td width="50%">
										<div class="watch-posted">Posted <?= $videos['day']; ?></div>
									</td>
									<td width="50%">
										<div class="watch-views">Views <?= $stats_total['total_views']; ?></div>
									</td>
								</tr>
							</table>
						</div>
						<div class="watch-comments" style="margin-top: 10px;">
<?
						if(!isset($_SESSION['id'])) {
?>
							<div class="watch-comments-post">
								You must be logged in to add a comment.
							</div>
<?
						} else {
?>								
							<div class="watch-comments-post">
								<textarea id="comment" name="comment" style="width:100%; height:50px;" onkeyup="char_counter('comment', 'char_count', 500)"></textarea>
								<div><input type='text' disabled='disabled' id="char_count" value='500' style=' width:30px; border:none; color:black;' /> character(s) left</div>
							</div>
							<div class="watch-comments-button"><img src="images/goto-comment.png" alt="goto-comment" id="submit_comment" width="97" height="18" style="display:none;" onclick="char_counter('comment', 'char_count', 500); add_comment('',<?=$videos['id']?>,'comment');" /></div>
<?
						}
?>

							
							<div class="watch-comments-topic">Member Comments</div>
							<div id="comments" style='margin-top:10px;'>
							</div>
						</div>
					</td>
					<td width="500" valign="top">
						<div class="watch-description"><?= $videos['description']; ?></div>
						<div class="watch-criteria" style="margin-top: 10px;">
							<table cellpadding="0" cellspacing="3" border="0">
								<tr>
									<td nowrap valign="top"><strong>Author:</strong></td>
									<td width="100%"><?=$videos['first_name']?> <?=$videos['last_name']?></td>
								</tr>
<?php
	include('includes/video_criteria.php');
?>
								<tr>
									<td nowrap valign="top"><strong>Meta Tags:</strong></td>
									<td><?=str_replace(",", ", ", $videos['meta_tags'])?></td>
								</tr>
							</table>
						</div>
						<div class="watch-embed" style="margin-top: 10px;">
							<div style="color: #ffffff;">Embed Code</div>
							<div class=""><textarea id="textarea" cols="35" rows="4" wrap="virtual" style="color: #5b5b5b; font-size: 10px; margin-bottom: 10px; width: 100%;" readonly onclick="document.getElementById('textarea').focus();document.getElementById('textarea').select();"></textarea></div>
<!-- Embed Code -->
<script>
	var code = $f().embed().getEmbedCode();
	document.getElementById("textarea").innerHTML = code;
</script>
<!-- end Embed code -->
						</div>
						<div style="padding: 10px; background: #ffffff; margin-left: 15px; margin-top: 10px;">
							<div style="font-size: 14px; font-weight: bold;">
								Related Videos
							</div>
<?
	//Education Level
	include('includes/compress-elevel.php');
	//Content Themes
	include('includes/compress-themes.php');
	//Curriculum Areas
	include('includes/compress-curriculum.php');
	//Decade
	include('includes/compress-decades.php');
	//Related to
	include('includes/compress-related.php');
?>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>