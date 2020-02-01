<?php
	$BF = "";
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//This is for the User Profile. We need to get the information and display it on the page below.
	$sql_query = "SELECT processed_file, video_status_id, title, h264, description, first_name, last_name, DATE_FORMAT(videos.created_at, '%M %D, %Y') as day, DATE_FORMAT(videos.created_at, '%h:%i %p') as time, status, vid, admin_notes, videos.id, meta_tags
	FROM videos
	JOIN customers on videos.customer_id = customers.id
	JOIN video_statuses ON videos.video_status_id = video_statuses.id
	WHERE videos.vid = '". $_REQUEST['vid'] . "'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$videos = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//Original Channels
	$sql_query = "select id, name, (select id from video_channels where channels.id = video_channels.channel_id and video_channels.video_id = ".$videos['id'].") as selected
	FROM channels
	WHERE uploadable = 1
	ORDER BY display_order";
	
	$channel_result = @mysql_query ($sql_query); //Run the query.
	//$my_sql = $sql_query;
	
	//get the video criteria
	$sql_query = "SELECT *
	FROM video_criteria
	WHERE video_criteria.video_id = '". $videos['id'] . "'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$video_criteria = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	# Stuff In The Header
	function sith() { 
	global $BF;
?>	<script type='text/javascript' src='includes/forms.js'></script>
	<script type='text/javascript'>
		var page = 'edit';
		var totalErrors = 0;
		function error_check() {
			if(totalErrors != 0) { reset_errors(); }  
			
			totalErrors = 0;
		
			if(errEmpty('title', "You must enter a Video Title.")) { totalErrors++; }
			if(errEmpty('description', "You must enter a Video Description.")) { totalErrors++; }
			
			if(errEmpty('elevel[]', "You must select at least One (1) Education Level.","array")) { totalErrors++; }
			
			if(errEmpty('content[]', "You must only select up to Three (3) Content Themes.","array",3)) { totalErrors++; }

			if(errEmpty('relates[]', "You must select at least One (1) Story relates to.","array")) { totalErrors++; }

			
			if(document.getElementById('terms').checked == false) {
				errCustom('terms','You must agree to the Terms.');
				totalErrors++;
			}
			return (totalErrors == 0 ? true : false);
		}
	</script>
	
<?
		
	}
	
	//Page title.
	$page_title = "Edit Video";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<div style="padding: 10px; background: #ffffff;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
<!-- old code -->
					<td>
					<form id="form1" name="update" method="post" action="updatevideo.php" onsubmit="return error_check()">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td valign="top" width="580" align="left" class="video_playback">
									<div class="video_playback_big" style="background: #000;">
										<center>
											<a id="player" style="display:block; width:480px; height:352px;" href="http://bitcast-g.bitgravity.com/techit/<?= $videos['processed_file']; ?>.<?=($videos['h264'] == '0' ? 'flv':'mp4') ?>"></a>
										</center>
								
<!-- install player -->
<script>

$f("player", "includes/flowplayer.commercial-3.0.7.swf",  {
		
	//Our code
	key: '$4594fc684bc3738aa7e',
	
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
									<div id='errors'></div>
<?php
	$channel_counter = mysql_num_rows($channel_result);
	$divider = round($channel_counter/2); //We need to see how many will fit in a row.
	$counter = 0;
?>
            						<div class="form_div" style="padding-top: 10px;">
										<span class="form_required">Channels</span> <span style="font-size:10px; color:#000;">(You can choose more then one.)</span>
										<table width="100%" cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td width="50%" valign="top">
<?php
	while ($channels = mysql_fetch_array ($channel_result, MYSQL_ASSOC)) {
		$counter = $counter + 1;
		if ($counter > $divider) {
?>
												</td>
												<td width="50%" valign="top">
<?php
			$counter = 0;
		}
?>
												<div>
													<input type="checkbox" id="<?= $channels['id'] ?>" name="<?= $channels['id'] ?>" value="<?= $channels['id'] ?>" <?=($channels['selected'] > "0" ? 'checked' : '') ?> /><?= $channels['name'] ?>
												</div>
<?php
	}
?>
												<input type="hidden" name="video_id" value="<?= $videos['id'] ?>">
												</td>
											</tr>
										</table>
									</div>
									
									<div class="form_div">
										<span class="form_required">Story Title</span><br />
										<input name="title" type="text" id="title" size="75" maxlength="200" value="<?= $videos['title']; ?>" />
									</div>
									
									<div class="form_div">
										<span class="form_required">Story Description</span><br />
										<textarea name="description" id="description" cols="75" rows="10" wrap="virtual"><?= $videos['description']; ?></textarea>
									</div>
									
									<div style="padding-top: 10px;">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td colspan="4">
													<div class="form_div">
														<span class="form_required">Education Level</span> (Check all that apply)
													</div>
												</td>
											</tr>
											<tr>
												<td><input name="elevel[]" type="checkbox" id="elevel-0" value="1" <?= ($video_criteria['elevel1'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">PK-8</td>
												<td><input type="checkbox" name="elevel[]" id="elevel-3" value="4" <?= ($video_criteria['elevel4'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">University</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="elevel[]" id="elevel-1" value="2" <?= ($video_criteria['elevel2'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">9-12</td>
												<td><input type="checkbox" name="elevel[]" id="elevel-4" value="5" <?= ($video_criteria['elevel5'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">Continuing Education</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="elevel[]" id="elevel-2" value="3" <?= ($video_criteria['elevel3'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">Community College</td>
												<td><input type="checkbox" name="elevel[]" id="elevel-5" value="6" <?= ($video_criteria['elevel6'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">Other</td>
											</tr>
										</table>
									</div>
									<div style="padding-top: 10px;">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td colspan="4">
													<div class="form_div">
														<span class="form_required">Content Themes</span> (Check up to 3)
													</div>
												</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="content[]" id="content-0" value="1" <?= ($video_criteria['content1'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">School Improvement</td>
												<td><input type="checkbox" name="content[]" id="content-3" value="4" <?= ($video_criteria['content4'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">Professional Learning</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="content[]" id="content-1" value="2" <?= ($video_criteria['content2'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">Ethics &amp; Equity</td>
												<td><input type="checkbox" name="content[]" id="content-4" value="5" <?= ($video_criteria['content5'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">21st Century Teaching & Learning</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="content[]" id="content-2" value="3" <?= ($video_criteria['content3'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">Technology Infrastructure</td>
												<td><input type="checkbox" name="content[]" id="content-5" value="6" <?= ($video_criteria['content6'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">Virtual Schooling/E-learning</td>
											</tr>
										</table>
									</div>
									<div style="padding-top: 10px;">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td colspan="4">
													<div class="form_div">
														<span class="form_required">Curricular Areas</span> (check all that apply)
													</div>
												</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="cirricular[]" id="cirricular-0" <?= ($video_criteria['cirricular1'] == "1" ? "checked":"" ) ?> value="1" /></td>
												<td width="50%">Language Arts</td>
												<td><input type="checkbox" name="cirricular[]" id="cirricular-5" <?= ($video_criteria['cirricular6'] == "1" ? "checked":"" ) ?> value="6" /></td>
												<td width="50%">Music/Drama</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="cirricular[]" id="cirricular-1" <?= ($video_criteria['cirricular2'] == "1" ? "checked":"" ) ?> value="2" /></td>
												<td width="50%">Art</td>
												<td><input type="checkbox" name="cirricular[]" id="cirricular-6" <?= ($video_criteria['cirricular7'] == "1" ? "checked":"" ) ?> value="7" /></td>
												<td width="50%">ICT</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="cirricular[]" id="cirricular-2" <?= ($video_criteria['cirricular3'] == "1" ? "checked":"" ) ?> value="3" /></td>
												<td width="50%">Math</td>
												<td><input type="checkbox" name="cirricular[]" id="cirricular-7" <?= ($video_criteria['cirricular8'] == "1" ? "checked":"" ) ?> value="8" /></td>
												<td width="50%">Physical Education</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="cirricular[]" id="cirricular-3" <?= ($video_criteria['cirricular4'] == "1" ? "checked":"" ) ?> value="4" /></td>
												<td width="50%">Science</td>
												<td><input type="checkbox" name="cirricular[]" id="cirricular-8" <?= ($video_criteria['cirricular9'] == "1" ? "checked":"" ) ?> value="9" /></td>
												<td width="50%">Interdisciplinary</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="cirricular[]" id="cirricular-4" <?= ($video_criteria['cirricular5'] == "1" ? "checked":"" ) ?> value="5" /></td>
												<td width="50%">Social Studies</td>
												<td><input type="checkbox" name="cirricular[]" id="cirricular-9" <?= ($video_criteria['cirricular10'] == "1" ? "checked":"" ) ?> value="10" /></td>
												<td width="50%">Other</td>
											</tr>
										</table>
									</div>
									<div style="padding-top: 10px;">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td colspan="4">
													<div class="form_div">
														<span class="form_required">Story relates to decade</span> (check all that apply)
													</div>
												</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="decade[]" id="decade-0" value="1" <?= ($video_criteria['decade1'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">1959-1968</td>
												<td><input type="checkbox" name="decade[]" id="decade-3" value="4" <?= ($video_criteria['decade4'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">1989-1998</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="decade[]" id="decade-1" value="2" <?= ($video_criteria['decade2'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">1969-1978</td>
												<td><input type="checkbox" name="decade[]" id="decade-4" value="5" <?= ($video_criteria['decade5'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">1999-2009</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="decade[]" id="decade-2" value="3" <?= ($video_criteria['decade3'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">1979-1988</td>
												<td><input type="checkbox" name="decade[]" id="decade-5" value="6" <?= ($video_criteria['decade6'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">Future</td>
											</tr>
										</table>
									</div>
									<div style="padding-top: 10px;">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td colspan="4">
													<div class="form_div">
														<span class="form_required">Story relates to:</span> (check all that apply)
													</div>
												</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="relates[]" id="relates-0" value="1" <?= ($video_criteria['relates1'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">Educational transformation</td>
												<td><input type="checkbox" name="relates[]" id="relates-3" value="4" <?= ($video_criteria['relates4'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">General Ed Tech</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="relates[]" id="relates-1" value="2" <?= ($video_criteria['relates2'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">ISTE</td>
												<td><input type="checkbox" name="relates[]" id="relates-4" value="5" <?= ($video_criteria['relates5'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">Other</td>
											</tr>
											<tr>
												<td><input type="checkbox" name="relates[]" id="relates-2" value="3" <?= ($video_criteria['relates3'] == "1" ? "checked":"" ) ?> /></td>
												<td width="50%">NECC</td>
												<td></td>
												<td width="50%"></td>
											</tr>
										</table>
									</div>
									<div class="form_div" style="padding-top: 10px;">
										<span class="form_optional">Extra search tags</span> (seperate tags with commas please)<br />
										<textarea name="meta_tags" id="meta_tags" cols="75" rows="5" wrap="virtual"><?= $videos['meta_tags'] ?></textarea>
									</div>
									
									<div class="form_div" style="padding-top: 10px;">
										<input name="terms" type="checkbox" id="terms" value="Yes" /> <span class="form_required">Please check the box to confirm that you have read and understand the ISTE User Agreement.</span>
									</div>
									
									<div style="height:25px;"></div>
									
									<div class="form_div" style="padding-top: 10px;">
										<input name="submit" type="submit" id="button" value="Submit" /><input name="vid" type="hidden" id="vid" value="<?= $_REQUEST['vid'] ?>" /> <span style=" font-size:10px; color:#00F; font-style:italic;">NOTE: Do not click the button more then once or click back.</span>
									</div>
								</td>
								
								<td valign="top" width="20"></td>
								
								<td valign="top" width="300" align="left">
									<div style="text-align: center; background:#C66; padding: 3px;">
										ISTE/NECC User Agreement
									</div>
									<div style=" text-align: left; background:#FFF; color:#F00; padding: 5px; border: solid 1px #C66;">
										<p>By uploading this video ("work") you:</p>
										
										<p>1. Represent and warrant that the work will be of wholly original material that you hold the copyright to (except for material in the public domain or used with the permission of the owner), will not infringe any copyright, and will not constitute a defamation; or invasion of the right of privacy or publicity; or infringement of any other kind, of any third party.</p>
										
										<p>2. You grant ISTE a non-exclusive worldwide perpetual license to use, modify, and make derivative works of this work.  You also grant ISTE the right to use your name, biography, and likeness in advertising and promotion and in any and all ancillary products regardless of the formats in which such use occurs, when used in conjunction with any portion of, or derivative work made from, the work you upload.</p>
										
										<p>3. You also agree to indemnify and hold ISTE harmless from any and all claims, judgments, costs, suits, debts or liabilities, including attorney's fees, arising from ISTE's or your use of this work.</p>
									</div>
								</td>
							</tr>
						</table>
					</form>
					</td>
<!-- end old code -->
				</tr>
			</table>
			</div>
		</td>
	</tr>
</table>		
<?
	include('includes/page-bottom.php');
?>