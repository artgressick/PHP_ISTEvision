<?php
	$BF = "";
	//include('includes/security.php');
	session_start(); //Do not use this code if you include the security above.
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	include('includes/_lib.php');
	
	#SQL goes in here
	$sql_query = "SELECT id, display_order, name
	FROM channels
	WHERE visible = 1 and (select count(id) from video_channels where video_channels.channel_id = channels.id) > 0
	ORDER BY display_order";
	
	$channel_result = @mysql_query ($sql_query);
	
	# Stuff In The Header
	function sith() { 
		global $BF;
?>
		<script type='text/javascript'>
			function show_options() {
				var options = document.getElementById('show_options');
				if(options.style.display == "none") {
					options.style.display = "";
				} else {
					options.style.display = "none";
				}
			}
		</script>
<?
	}

	
	if(count($_POST)) {
		
		$q = "SELECT processed_file, title, first_name, h264, last_name, vid, description, (select count(video_id) from views where videos.id = views.video_id) as watched
				FROM videos
				JOIN customers ON videos.customer_id = customers.id
				WHERE videos.video_status_id=2 AND videos.ftp_status > 0 ";
		
		if($_POST['criteria'] != "") {
			$q .= " AND (LOWER(videos.title) LIKE '%".encode(strtolower($_POST['criteria']))."%' OR LOWER(videos.description) LIKE '%".encode(strtolower($_POST['criteria']))."%' OR LOWER(videos.meta_tags) LIKE '%".encode(strtolower($_POST['criteria']))."%')";
		}
		$q2 = "";
		if($_POST['video_status_id']=='and') { $cond = "AND"; } else { $cond = "OR"; }
		if($_POST['elevel1']==1) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.elevel1"; }
		if($_POST['elevel2']==2) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.elevel2"; }		
		if($_POST['elevel3']==3) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.elevel3"; }
		if($_POST['elevel4']==4) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.elevel4"; }
		if($_POST['elevel5']==5) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.elevel5"; }
		if($_POST['elevel6']==6) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.elevel6"; }
		if($_POST['content1']==1) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.content1"; }
		if($_POST['content2']==2) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.content2"; }
		if($_POST['content3']==3) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.content3"; }
		if($_POST['content4']==4) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.content4"; }
		if($_POST['content5']==5) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.content5"; }
		if($_POST['content6']==6) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.content6"; }
		if($_POST['cirricular1']==1) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.cirricular1"; }
		if($_POST['cirricular2']==2) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.cirricular2"; }
		if($_POST['cirricular3']==3) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.cirricular3"; }
		if($_POST['cirricular4']==4) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.cirricular4"; }
		if($_POST['cirricular5']==5) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.cirricular5"; }
		if($_POST['cirricular6']==6) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.cirricular6"; }
		if($_POST['cirricular7']==7) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.cirricular7"; }
		if($_POST['cirricular8']==8) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.cirricular8"; }
		if($_POST['cirricular9']==9) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.cirricular9"; }
		if($_POST['cirricular10']==10) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.cirricular10"; }
		if($_POST['decade1']==1) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.decade1"; }
		if($_POST['decade2']==2) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.decade2"; }
		if($_POST['decade3']==3) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.decade3"; }
		if($_POST['decade4']==4) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.decade4"; }
		if($_POST['decade5']==5) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.decade5"; }
		if($_POST['decade6']==6) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.decade6"; }
		if($_POST['relates1']==1) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.relates1"; }
		if($_POST['relates2']==2) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.relates2"; }
		if($_POST['relates3']==3) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.relates3"; }
		if($_POST['relates4']==4) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.relates4"; }
		if($_POST['relates5']==5) { $q2 .= ($q2 != "" ? " ".$cond." ":"")."video_criteria.relates5"; }
		
		if($q2 != "") {
			$q .= " AND videos.id IN (SELECT video_criteria.video_id FROM video_criteria WHERE ".$q2.")";
		}
		if($_POST['channel_id'] > 0) {
			$q .= " AND videos.id in (SELECT video_id from video_channels where channel_id = ".$_POST['channel_id'].") ";
		}
		$q .= " LIMIT 50";
		
		$results = @mysql_query ($q); //Get Results
		
		$info = $_POST;
	} else {
		$info = 0;
	}
	$page_title = "Search Results";
	//include the header information
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
<!-- new code above -->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="left">
						<form id="advanced" name="advanced" method="post" action="search.php" style="padding: 0px; margin: 0px;">
							<div style="border: solid 1px #c0c0c0; padding: 3px; background: #f5f5f5;">
								<table cellpadding="2" cellspacing="0" border="0" width="100%">
									<tr>
										<td align="center" width="50%" nowrap="nowrap">
											<strong>Search <select name="channel_id" size="1" id="channel_id">
												<option value="0"<?=($_POST['channel_id']=='0'?' selected="selected"':'')?>>All Channels</option>
<?php
	while ($channels = mysql_fetch_array ($channel_result, MYSQL_ASSOC)) {
?>
												<option value="<?= $channels['id'] ?>"<?=($_POST['channel_id']==$channels['id']?' selected="selected"':'')?>><?= $channels['name'] ?></option>
<?php
	}
?>
											</select> for</strong> <input type="text" size="25" id="criteria" name="criteria" value="<?=$info['criteria']?>" /> <input  type="submit" name="go" id="go" value="Advanced Search" /> <a href="#" onclick="show_options()">more options </a>
 										</td>
									</tr>
								</table>
								<table cellpadding="2" cellspacing="0" border="0" width="100%" style="border-top: solid 1px #c0c0c0; display:none;" id="show_options">
									<tr>
										<td colspan="5" align="center">
											<div style="padding: 10px 0 10px 0;">
												<strong>Search type</strong> <select name="video_status_id" size="1" id="video_status_id">
													<option value="and"<?=($info['video_status_id']=='and'?' selected="selected"':'')?>>Search for only these fields. Results will be very few.</option>
													<option value="or"<?=($info['video_status_id']=='or'?' selected="selected"':'')?>>Search for any of these fields below. Results may be very large.</option>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td valign="top">
											<div class="search_header">Education Level</div>
											<div class="search_field"><input type="checkbox" name="elevel1" id="elevel1" value="1"<?=($info['elevel1']==1?' checked="checked"':'')?> /> PK-8</div>
											<div class="search_field"><input type="checkbox" name="elevel2" id="elevel2" value="2"<?=($info['elevel2']==2?' checked="checked"':'')?> /> 9-12</div>
											<div class="search_field"><input type="checkbox" name="elevel3" id="elevel3" value="3"<?=($info['elevel3']==3?' checked="checked"':'')?> /> Community College</div>
											<div class="search_field"><input type="checkbox" name="elevel4" id="elevel4" value="4"<?=($info['elevel4']==4?' checked="checked"':'')?> /> University</div>
											<div class="search_field"><input type="checkbox" name="elevel5" id="elevel5" value="5"<?=($info['elevel5']==5?' checked="checked"':'')?> /> Continuing Education</div>
											<div class="search_field"><input type="checkbox" name="elevel6" id="elevel6" value="6"<?=($info['elevel6']==6?' checked="checked"':'')?> /> Other</div>
										</td>
										<td valign="top">
											<div class="search_header">Content Themes</div>
											<div class="search_field"><input type="checkbox" name="content1" id="content1" value="1"<?=($info['content1']==1?' checked="checked"':'')?> /> School Improvement</div>
											<div class="search_field"><input type="checkbox" name="content2" id="content2" value="2"<?=($info['content2']==2?' checked="checked"':'')?> /> Ethics & Equity</div>
											<div class="search_field"><input type="checkbox" name="content3" id="content3" value="3"<?=($info['content3']==3?' checked="checked"':'')?> /> Technology Infrastructure</div>
											<div class="search_field"><input type="checkbox" name="content4" id="content4" value="4"<?=($info['content4']==4?' checked="checked"':'')?> /> Professional Learning</div>
											<div class="search_field"><input type="checkbox" name="content5" id="content5" value="5"<?=($info['content5']==5?' checked="checked"':'')?> /> 21st Century Teaching & Learning</div>
											<div class="search_field"><input type="checkbox" name="content6" id="content6" value="6"<?=($info['content6']==6?' checked="checked"':'')?> /> Virtual Schooling/E-learning</div>
										</td>
										<td valign="top">
											<div class="search_header">Curricular Areas</div>
											<div class="search_field"><input type="checkbox" name="cirricular1" id="cirricular1"<?=($info['cirricular1']==1?' checked="checked"':'')?> value="1" /> Language Arts</div>
											<div class="search_field"><input type="checkbox" name="cirricular2" id="cirricular2"<?=($info['cirricular2']==2?' checked="checked"':'')?> value="2" /> Art</div>
											<div class="search_field"><input type="checkbox" name="cirricular3" id="cirricular3"<?=($info['cirricular3']==3?' checked="checked"':'')?> value="3" /> Math</div>
											<div class="search_field"><input type="checkbox" name="cirricular4" id="cirricular4"<?=($info['cirricular4']==4?' checked="checked"':'')?> value="4" /> Science</div>
											<div class="search_field"><input type="checkbox" name="cirricular5" id="cirricular5"<?=($info['cirricular5']==5?' checked="checked"':'')?> value="5" /> Social Studies</div>
											<div class="search_field"><input type="checkbox" name="cirricular6" id="cirricular6"<?=($info['cirricular6']==6?' checked="checked"':'')?> value="6" /> Music/Drama</div>
											<div class="search_field"><input type="checkbox" name="cirricular7" id="cirricular7"<?=($info['cirricular7']==7?' checked="checked"':'')?> value="7" /> ICT</div>
											<div class="search_field"><input type="checkbox" name="cirricular8" id="cirricular8"<?=($info['cirricular8']==8?' checked="checked"':'')?> value="8" /> Physical Education</div>
											<div class="search_field"><input type="checkbox" name="cirricular9" id="cirricular9"<?=($info['cirricular9']==9?' checked="checked"':'')?> value="9" /> Interdisciplinary</div>
											<div class="search_field"><input type="checkbox" name="cirricular10" id="cirricular10"<?=($info['cirricular10']==10?' checked="checked"':'')?> value="10" /> Other</div>
										</td>
										<td valign="top">
											<div class="search_header">Decade</div>
											<div class="search_field"><input type="checkbox" name="decade1" id="decade1"<?=($info['decade1']==1?' checked="checked"':'')?> value="1" /> 1959-1968</div>
											<div class="search_field"><input type="checkbox" name="decade2" id="decade2"<?=($info['decade2']==2?' checked="checked"':'')?> value="2" /> 1969-1978</div>
											<div class="search_field"><input type="checkbox" name="decade3" id="decade3"<?=($info['decade3']==3?' checked="checked"':'')?> value="3" /> 1979-1988</div>
											<div class="search_field"><input type="checkbox" name="decade4" id="decade4"<?=($info['decade4']==4?' checked="checked"':'')?> value="4" /> 1989-1998</div>
											<div class="search_field"><input type="checkbox" name="decade5" id="decade5"<?=($info['decade5']==5?' checked="checked"':'')?> value="5" /> 1999-2009</div>
											<div class="search_field"><input type="checkbox" name="decade6" id="decade6"<?=($info['decade6']==6?' checked="checked"':'')?> value="6" /> Future</div>
										</td>
										<td valign="top">
											<div class="search_header">Relates to</div>
											<div class="search_field"><input type="checkbox" name="relates1" id="relates1"<?=($info['relates1']==1?' checked="checked"':'')?> value="1" /> Educational transformation</div>
											<div class="search_field"><input type="checkbox" name="relates2" id="relates2"<?=($info['relates2']==2?' checked="checked"':'')?> value="2" /> ISTE</div>
											<div class="search_field"><input type="checkbox" name="relates3" id="relates3"<?=($info['relates3']==3?' checked="checked"':'')?> value="3" /> NECC</div>
											<div class="search_field"><input type="checkbox" name="relates4" id="relates4"<?=($info['relates4']==4?' checked="checked"':'')?> value="4" /> General Ed Tech</div>
											<div class="search_field"><input type="checkbox" name="relates5" id="relates5"<?=($info['relates5']==5?' checked="checked"':'')?> value="5" /> Other</div>
										</td>
									</tr>
								</table>
							</div>
						</form>
					</td>
				</tr>
				<tr>
					<td>
						<div class="contents-inner">
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tr>
<?
	//Spit out 4 videos to display
	
	if(isset($results) && mysql_num_rows($results) > 0) {
		if(mysql_num_rows($results) < 5) {
			$cwidth = floor(100 / mysql_num_rows($results)); //get a even width round down
		} else {
			$cwidth = 20;
		}
		$cnt = 1;
		while ($top_videos = mysql_fetch_array ($results, MYSQL_ASSOC)) {
			//counter for hidden
			$popup = $popup + 1;
			
			if($cnt > 5) {
?>
							</tr>
							<tr>
<?			
				$cnt = 1;
			}
?>
								<td width="<?=$cwidth?>%" valign="top">
									<div style="width: 144px; padding-bottom: 20px;">
										<div style="border-left: solid 1px #696969; border-right: solid 1px #696969; border-top: solid 1px #696969;">
											<a rel="#overlay<?= $popup ?>" style="cursor: pointer"><img src="http://bitcast-g.bitgravity.com/techit/<?= $top_videos['processed_file']; ?>.jpg" width="142" height="107" border="0" title="<?= (strlen($top_videos['title'] . " - " .$top_videos['description']) > 150 ? substr($top_videos['title'] . " - " . $top_videos['description'],0,150).'...' : $top_videos['title'] . " - " . $top_videos['description'] ) ?>" /></a>
										</div>
										<div class="thumb-title" style="background-color: #ffffff; border-left: solid 1px #696969; border-right: solid 1px #696969; color: #000000; height: 35px;">
											<a href="watch.php?vid=<?= $top_videos['vid']; ?>"><?= (strlen($top_videos['title']) > 25 ? substr($top_videos['title'],0,25).'...' : $top_videos['title'] ) ?></a>
										</div>
										<div class="thumb-views" style="background-color: #ffffff; border-left: solid 1px #696969; border-right: solid 1px #696969; color: #000000;">
											<?= $top_videos['watched']; ?> views
										</div>
										<div class="thumb-user" style="background-color: #ffffff; border-left: solid 1px #696969; border-right: solid 1px #696969; color: #000000; padding-bottom: 5px;">
											<a href="watch.php?vid=<?= $top_videos['vid']; ?>" style="color: #696969;"><?= $top_videos['first_name'] ?> <?= $top_videos['last_name'] ?></a>
										</div>
<!-- hidden popup div -->
										<div class="overlay" id="overlay<?= $popup ?>">
											<a class="myPlayer" href="http://bitcast-g.bitgravity.com/techit/<?= $top_videos['processed_file']; ?>.<?=($top_videos['h264'] == '0' ? 'flv':'mp4') ?>">
												<img src="http://bitcast-g.bitgravity.com/techit/<?= $top_videos['processed_file']; ?>.jpg" height="425" width="576" alt="Video" border="0"/>
											</a>
											<div style="text-align: center; padding-top: 12px;">To view more information about this video click here: <a href="watch.php?vid=<?= $top_videos['vid']?>">Watch Video</a></div>
										</div>
<!-- end hidden -->
									</div>
								</td>
<?
			$cnt++;
		}
		if($cwidth == 20) {
			while($cnt <= 5) {
?>
								<td width="<?=$cwidth?>%">&nbsp;</td>
<?		
		
				$cnt++;
			}
		}
	} else if(isset($results)) {
?>
								<td>
									<div style="text-align: center; font-size: 14px; height: 250px; padding-top: 200px; color: #efefef;">
										No Videos Found
									</div>
								</td>
<?	
	}
?>
							</tr>	
						</table>
						</div>
					</td>
				</tr>
			</table>
<!-- being code -->
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
<?
	include('includes/page-bottom.php');
?>