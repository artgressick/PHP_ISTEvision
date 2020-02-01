<?php

	//start a session
	session_start(); //Start the session.


	# Stuff In The Header
	function sith() { 
	global $BF;
?>	
	<script src="AC_OETags.js" language="javascript"></script>

	<!--  BEGIN Browser History required section -->
	<script src="history/history.js" language="javascript"></script>
	<!--  END Browser History required section -->
	
	<script language="JavaScript" type="text/javascript">
	<!--
	// -----------------------------------------------------------------------------
	// Globals
	// Major version of Flash required
	var requiredMajorVersion = 9;
	// Minor version of Flash required
	var requiredMinorVersion = 0;
	// Minor version of Flash required
	var requiredRevision = 28;
	// -----------------------------------------------------------------------------
	// -->
	</script>
	
<?
		
	}

	include('includes/page-meta.php');
	include('includes/page-top.php');
	
	//build the name
	if ($_SESSION['user_id'] == '') {
		//set it to Anonymous
		$_SESSION['user_id'] = 1; //change to the kiosk ID user later.
		$_SESSION['first_name'] = "Anonymous";
	}
	
	//Make a video ID for storing the videos.
	$vid = substr(md5(kiosk.time()),0,15);
	
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#efefef">
      <tr>
        <td>
        	<div style="padding: 25px;">Welcome, <strong><?= $_SESSION['first_name'] ?> <?= $_SESSION['last_name'] ?></strong>. Let's make a video.</div>
        </td>
      </tr>
      <tr>
        <td><form id="form1" name="form1" method="post" action="thanks.php">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%"><div style="padding:20px;"><p>Video Title<br />
                <input type="text" name="textfield" id="textfield" />
              </p>
                <p>Video Description<br />
                  <textarea name="textarea" id="textarea" cols="45" rows="5"></textarea>
                </p>
                <p>Meta Tags<br />
                  <textarea name="textarea2" id="textarea2" cols="45" rows="5"></textarea>
                </p></div></td>
              <td width="50%" align="center">
<!-- Begin Red5Recorder Programming -->

<script language="JavaScript" type="text/javascript">
<!--
// Version check for the Flash Player that has the ability to start Player Product Install (6.0r65)
var hasProductInstall = DetectFlashVer(6, 0, 65);

// Version check based upon the values defined in globals
var hasRequestedVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);

if ( hasProductInstall && !hasRequestedVersion ) {
	// DO NOT MODIFY THE FOLLOWING FOUR LINES
	// Location visited after installation is complete if installation is required
	var MMPlayerType = (isIE == true) ? "ActiveX" : "PlugIn";
	var MMredirectURL = window.location;
    document.title = document.title.slice(0, 47) + " - Flash Player Installation";
    var MMdoctitle = document.title;

	AC_FL_RunContent(
		"src", "playerProductInstall",
		"FlashVars", "server=rtmp://66.35.209.254/red5recorder/&fps=20&quality=90&keyFrame=6&MMredirectURL="+MMredirectURL+'&MMplayerType='+MMPlayerType+'&MMdoctitle='+MMdoctitle+"",
		"width", "480",
		"height", "352",
		"align", "middle",
		"id", "red5recorder",
		"quality", "high",
		"bgcolor", "#869ca7",
		"name", "red5recorder",
		"allowScriptAccess","sameDomain",
		"type", "application/x-shockwave-flash",
		"pluginspage", "http://www.adobe.com/go/getflashplayer"
	);
} else if (hasRequestedVersion) {
	// if we've detected an acceptable version
	// embed the Flash Content SWF when all tests are passed
	
	//These seem to work
	
	AC_FL_RunContent(
			"src", "red5recorder",
			"FlashVars", "server=rtmp://66.35.209.254/red5recorder/&fps=20&quality=90&keyFrame=6&width=384&height=288&fileName=<?=$vid?>&maxLength=180&MMredirectURL="+MMredirectURL+'&MMplayerType='+MMPlayerType+'&MMdoctitle='+MMdoctitle+"",
			"width", "384",
			"height", "288",
			"align", "middle",
			"id", "red5recorder",
			"quality", "high",
			"bandwidth", "600000",
			"bgcolor", "#869ca7",
			"name", "red5recorder",
			"allowScriptAccess","sameDomain",
			"type", "application/x-shockwave-flash",
			"pluginspage", "http://www.adobe.com/go/getflashplayer"
	);
  } else {  // flash is too old or we can't detect the plugin
    var alternateContent = 'Alternate HTML content should be placed here. '
  	+ 'This content requires the Adobe Flash Player. '
   	+ '<a href=http://www.adobe.com/go/getflash/>Get Flash</a>';
    document.write(alternateContent);  // insert non-flash content
  }
// -->
</script>

<!-- End Red5Recorder -->              
              </td>
            </tr>
            <tr>
              <td colspan="2">More information</td>
              </tr>
            <tr>
              <td valign="top"><img src="images/left.png" width="450" height="247" /></td>
              <td valign="top"><img src="images/right.png" width="445" height="175" /></td>
            </tr>
            <tr>
              <td colspan="2"><div style="padding:20px;"><p>By uploading this video (&quot;work&quot;) you:</p>
                <p>1. Represent and warrant that the work will be of wholly original material that you hold the copyright to (except for material in the public domain or used with the permission of the owner), will not infringe any copyright, and will not constitute a defamation; or invasion of the right of privacy or publicity; or infringement of any other kind, of any third party.</p>
                <p>2. You grant ISTE a non-exclusive worldwide perpetual license to use, modify, and make derivative works of this work. You also grant ISTE the right to use your name, biography, and likeness in advertising and promotion and in any and all ancillary products regardless of the formats in which such use occurs, when used in conjunction with any portion of, or derivative work made from, the work you upload.</p>
                <p>3. You also agree to indemnify and hold ISTE harmless from any and all claims, judgments, costs, suits, debts or liabilities, including attorney's fees, arising from ISTE's or your use of this work.</p></div></td>
              </tr>
              <tr>
              <td colspan="2"><div style="padding:20px;"><input type="submit" name="button" id="button" value="submit Video to ISTEVision" /></div></td>
              </tr>
          </table>
        </form></td>
        </tr>
    </table></td>
  </tr>
</table>
<?php
	include('includes/page-bottom.php');
?>