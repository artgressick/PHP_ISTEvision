<?php

	//start a session
	session_start(); //Start the session.
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	if(!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) {
		header ("Location: index.php"); //return to home page
		exit();		
	}
	
	//Original Channels
	$sql_query = "select id, name
	FROM channels
	WHERE uploadable = 1
	ORDER BY display_order";
	
	$channel_result = @mysql_query ($sql_query); //Run the query.
	
	# Stuff In The Header
	function sith() { 
	global $BF;
?>	
<script language="javascript"> AC_FL_RunContent = 0; </script>
<script language="javascript"> DetectFlashVer = 0; </script>
<script src="AC_RunActiveContent.js" language="javascript"></script>
<script language="JavaScript" type="text/javascript">
<!--
// -----------------------------------------------------------------------------
// Globals
// Major version of Flash required
var requiredMajorVersion = 9;
// Minor version of Flash required
var requiredMinorVersion = 0;
// Revision of Flash required
var requiredRevision = 45;
// -----------------------------------------------------------------------------
// -->
</script>
	<script type='text/javascript'>

			var totalErrors = 0;
			function error_check() {
				if(totalErrors != 0) { totalErrors = 0; } 
				var errorMessage = '';
				
				if(document.getElementById('title').value == '') {
					totalErrors++;
					errorMessage += 'You must enter a Video Title.'+"\n\n";
				}
				if(document.getElementById('description').value == '') {
					totalErrors++;
					errorMessage += 'You must enter a Video Description.'+"\n\n";
				}

				var elems = document.getElementsByName('channels[]');
				var len = elems.length;
				var i=0;
				var count=0;
				while(i<len) {
					if(elems[i].checked) { count++; }
					i++;
				}
				if(count == 0) { 
					totalErrors++;
					errorMessage += 'You must select at least One (1) Channel.'+"\n\n"; 
				}

				var elems = document.getElementsByName('elevel[]');
				var len = elems.length;
				var i=0;
				var count=0;
				while(i<len) {
					if(elems[i].checked) { count++; }
					i++;
				}
				if(count == 0) { 
					totalErrors++;
					errorMessage += 'You must select at least One (1) Education Level.'+"\n\n"; 
				}
				var elems = document.getElementsByName('content[]');
				var len = elems.length;
				var i=0;
				var count=0;
				while(i<len) {
					if(elems[i].checked) { count++; }
					i++;
				}
				if(count == 0) { 
					totalErrors++;
					errorMessage += 'You must select at least One (1) Content Themes.'+"\n\n"; 
				}
				var elems = document.getElementsByName('relates[]');
				var len = elems.length;
				var i=0;
				var count=0;
				while(i<len) {
					if(elems[i].checked) { count++; }
					i++;
				}
				if(count == 0) { 
					totalErrors++;
					errorMessage += 'You must select at least One (1) Story relates to.'+"\n\n"; 
				}
				if(document.getElementById('confirm').checked == false) {
					totalErrors++;
					errorMessage += 'You must agree to allow us to use this video.'+"\n\n"; 
				}
				if(totalErrors > 0) {
					alert(errorMessage);
				}
				return (totalErrors == 0 ? true : false);

			}
	</script>
<?
		
	}


	function sitm() {
		global $channel_result;
		//You have a total height of 1014px in this section to play with
?>
	<table cellpadding="0" cellspacing="0" style="width:100%;">
		<tr>
			<td style='vertical-align:top; text-align:center; padding-top:200px; padding-bottom:100px;'>
				<form id="form1" name="form1" method="post" action="insertvideo.php" onsubmit="return error_check()" style="padding:0; margin:0;">
				<table cellpadding="5" cellspacing="0" style="width:85%;" align="center">
					<tr>
						<td style='width:30%; verical-align:top;'>
<!-- AVRecorder include -->
<script>
	function btPlayPressed(){
		//alert("btPlayPressed");
		//this function is called whenever the Play button is pressed
	}
	function btSavePressed(streamName,streamDuration,userId){
		//alert("btSavePressed("+streamName+","+streamDuration+","+userId+")");
		//this function is called when the SAVE button is pressed and it is called with 3 parameters: 
		//streamName: a string representing the name of the stream recorded on the video server including the .flv extension
		//userId: the userId sent via flash vars or via the avc_settings.XXX file, the value in the avc_settings.XXX file takes precedence if its not empty
		//duration of the recorded video/audio file in seconds but acccurate to the millisecond (like this: 4.322)
	}
	
	function btStopPressed(appState){
		//alert("btStopPressed("+appState+")");
		//the appState parameter specifyes in what state teh recorder is when the STOP button is pressed. Its values are: recording  OR playing
		
		/*
		if (appState=="recording"){
		}else if (appState=="playing"){
		}
		*/

	}
	
	function btRecordPressed(){
		//alert("btRecordPressed");
		//this function is called whenever the Record button is pressed
	}
</script>
		
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) {  // if we've detected an acceptable version
		// embed the flash movie
		
		//original setting where w=340, h=360
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '380',
			'height', '402',
			'src', 'videorecorder',
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', 'window',
			'devicefont', 'false',
			'id', 'videorecorder',
			'bgcolor', '#ffffff',
			'name', 'videorecorder',
			'menu', 'false',
			'allowScriptAccess','sameDomain',
			'allowFullScreen','false',
			'movie', 'videorecorder?sscode=php&userId=XXX',
			'salign', ''
			); //end AC code
	} else {  // flash is too old or we can't detect the plugin
		var alternateContent = 'This content requires the Adobe Flash Player 9 or later: <a href=http://www.macromedia.com/go/getflash/>Get Flash Flash Player 9 </a>.';
		document.write(alternateContent);  // insert non-flash content
	}
}
// -->
</script>
<noscript>
	// Provide alternate content for browsers that do not support scripting
	// or for those that have scripting disabled.
	This content requires Java Script activated in your browser!!!
</noscript>
<!-- end of AVrecorder -->
							
						</td>
						<td style='width:33%; vertical-align:top; text-align:left;'>
							<div id='errors'></div>
							
							<div class="form_div">
								<span class="form_required">Video Title</span><br />
								<input name="title" type="text" id="title" size="52" maxlength="200" style="width:397px;" />
							</div>
							
							<div class="form_div">
								<span class="form_required">Video Description</span><br />
								<textarea name="description" id="description" cols="50" rows="5" wrap="virtual" style="width:400px; height:100px;"></textarea>
							</div>
							
							<div class="form_div">
								<span class="form_required">Meta Tags</span><br />
								<textarea name="meta_tags" id="meta_tags" cols="50" rows="5" style="width:400px; height:100px;"></textarea>
							</div>
<?php
	$channel_counter = mysql_num_rows($channel_result);
	$divider = round($channel_counter/2); //We need to see how many will fit in a row.
	$counter = 0;
?>
						<div class="form_div">
							<span class="form_required">Channels</span> <span class="at_least">(check at least one.)</span>
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
											<input type="checkbox" id="<?= $channels['id'] ?>" name="channels[]" value="<?= $channels['id'] ?>" /><?= $channels['name'] ?>
										</div>
<?php
	}
?>
									</td>
								</tr>
							</table>

						</td>
						<td style='vertical-align:top; text-align:left;'>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="4">
									<div class="form_div">
										<span class="form_required">Education Level</span> <span class="at_least">(check at least one.)</span>
									</div>
								</td>
							</tr>
							<tr>
								<td><input name="elevel[]" type="checkbox" id="elevel-0" value="1" /></td>
								<td width="50%">PK-8</td>
								<td><input type="checkbox" name="elevel[]" id="elevel-3" value="4" /></td>
								<td width="50%">University</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="elevel[]" id="elevel-1" value="2" /></td>
								<td width="50%">9-12</td>
								<td><input type="checkbox" name="elevel[]" id="elevel-4" value="5" /></td>
								<td width="50%">Continuing Education</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="elevel[]" id="elevel-2" value="3" /></td>
								<td width="50%">Community College</td>
								<td><input type="checkbox" name="elevel[]" id="elevel-5" value="6" /></td>
								<td width="50%">Other</td>
							</tr>
						</table>
						
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="4">
									<div class="form_div">
										<span class="form_required">Content Themes</span> <span class="at_least">(check at least one.)</span>
									</div>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="content[]" id="content-0" value="1" /></td>
								<td width="50%">School Improvement</td>
								<td><input type="checkbox" name="content[]" id="content-3" value="4" /></td>
								<td width="50%">Professional Learning</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="content[]" id="content-1" value="2" /></td>
								<td width="50%">Ethics &amp; Equity</td>
								<td><input type="checkbox" name="content[]" id="content-4" value="5" /></td>
								<td width="50%">21st Century Teaching & Learning</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="content[]" id="content-2" value="3" /></td>
								<td width="50%">Technology Infrastructure</td>
								<td><input type="checkbox" name="content[]" id="content-5" value="6" /></td>
								<td width="50%">Virtual Schooling/E-learning</td>
							</tr>
						</table>
						
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="4">
									<div class="form_div">
										<span class="form_required">Curricular Areas</span> <span class="at_least">(check at least one.)</span>
									</div>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="cirricular[]" id="cirricular-0" value="1" /></td>
								<td width="50%">Language Arts</td>
								<td><input type="checkbox" name="cirricular[]" id="cirricular-5" value="6" /></td>
								<td width="50%">Music/Drama</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="cirricular[]" id="cirricular-1" value="2" /></td>
								<td width="50%">Art</td>
								<td><input type="checkbox" name="cirricular[]" id="cirricular-6" value="7" /></td>
								<td width="50%">ICT</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="cirricular[]" id="cirricular-2" value="3" /></td>
								<td width="50%">Math</td>
								<td><input type="checkbox" name="cirricular[]" id="cirricular-7" value="8" /></td>
								<td width="50%">Physical Education</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="cirricular[]" id="cirricular-3" value="4" /></td>
								<td width="50%">Science</td>
								<td><input type="checkbox" name="cirricular[]" id="cirricular-8" value="9" /></td>
								<td width="50%">Interdisciplinary</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="cirricular[]" id="cirricular-4" value="5" /></td>
								<td width="50%">Social Studies</td>
								<td><input type="checkbox" name="cirricular[]" id="cirricular-9" value="10" /></td>
								<td width="50%">Other</td>
							</tr>
						</table>
						
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="4">
									<div class="form_div">
										<span class="form_required">Story relates to decade</span> <span class="at_least">(check at least one.)</span>
									</div>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="decade[]" id="decade-0" value="1" /></td>
								<td width="50%">1959-1968</td>
								<td><input type="checkbox" name="decade[]" id="decade-3" value="4" /></td>
								<td width="50%">1989-1998</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="decade[]" id="decade-1" value="2" /></td>
								<td width="50%">1969-1978</td>
								<td><input type="checkbox" name="decade[]" id="decade-4" value="5" /></td>
								<td width="50%">1999-2009</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="decade[]" id="decade-2" value="3" /></td>
								<td width="50%">1979-1988</td>
								<td><input type="checkbox" name="decade[]" id="decade-5" value="6" /></td>
								<td width="50%">Future</td>
							</tr>
						</table>
						
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="4">
									<div class="form_div">
										<span class="form_required">Story relates to:</span> <span class="at_least">(check at least one.)</span>
									</div>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="relates[]" id="relates-0" value="1" /></td>
								<td width="50%">Educational transformation</td>
								<td><input type="checkbox" name="relates[]" id="relates-3" value="4" /></td>
								<td width="50%">General Ed Tech</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="relates[]" id="relates-1" value="2" /></td>
								<td width="50%">ISTE</td>
								<td><input type="checkbox" name="relates[]" id="relates-4" value="5" /></td>
								<td width="50%">Other</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="relates[]" id="relates-2" value="3" /></td>
								<td width="50%">NECC</td>
								<td></td>
								<td width="50%"></td>
							</tr>
						</table>
						</td>
					</tr>
					<tr>
						<td colspan="3" style='padding-top:50px;'>
<div style="padding-top: 5px;">
							<input type="checkbox" name="confirm" id="confirm" value="1" style="width:20px; height:20px;" /> <span style='font-size:18px;'>Please confirm that your are giving us the right to use this video on our website.</span>
						</div>
						
						<div style="padding-top: 10px;">
							<input type="submit" name="button" id="button" value="Submit Video to ISTEVision" style='font-size:20px' /> &nbsp;&nbsp; <input type=button value="Cancel and Logout" onClick="location.href='logout.php';" style='font-size:20px' />
						</div>						
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
	<div style="position:absolute; bottom:32px; right:10px;"><img src="images/small-logo.png" alt="ISTE Vision"/></div>
	<div style="position:absolute; top:0px; left:0px;"><img src="images/top-left.png" alt="ISTE Vision"/></div>
	<div style="position:absolute; top:0px; right:0px;"><img src="images/top-right.png" alt="ISTE Vision"/></div>
	<div style="position:absolute; bottom:50px; left:0px;"><img src="images/bottom-left.png" alt="ISTE Vision"/></div>
	

<?
	}
	include('includes/wrapper.php');
?>