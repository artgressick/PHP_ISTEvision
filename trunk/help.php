<?php
	//Page title.
	$page_title = "Add Video";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<div style="background: #fff; padding: 20px;">
				<p><span style="font-size: 14px; font-weight: bold;">Uploading &amp; Formatting Videos</span></p>
				<p>The best results will come from capturing and exporting your videos using software packages such as <a href="http://www.microsoft.com/windowsxp/downloads/updates/moviemaker2.mspx" target="_blank">Windows Movie Maker</a> or <a href="http://www.apple.com/ilife/imovie/" target="_blank">Apple iMovie</a> in their standard formats, WMV and MOV respectively.</p>
				<p>If you wish to share an existing story video file on your computer that is not in any of the accepted formats, you will need to convert it before you can upload to the server. To convert most any video format to one of the accepted formats it is recommended you use <a href="http://www.ffmpeg.org/" target="_blank">FFMPEG</a>. FFMPEG is a powerful command-line tool, so newer users may prefer to use a free tool like <a href="http://handbrake.fr/" target="_blank">HandBrake</a> (available for both PC and Apple Macintosh - PC version requires <a href="http://www.microsoft.com/downloads/details.aspx?familyid=0856eacb-4362-4b0d-8edd-aab15c5e04f5&amp;displaylang=en" target="_blank">.NET framework library</a>). Handbrake has many built-in presets, we would suggest using the <span style="font-style: italic;">Basic-&gt;Normal</span> preset. Other free video converters like <a href="http://www.erightsoft.com/SUPER.html" target="_blank">SUPER</a>, (for PC) which can be found at http://www.erightsoft.org/ can produce acceptable results as well. Operation instructions and support for these software packages can be found on their respective websites. A quick Google or YouTube tutorial search will often provide useful information and instructions as well.</p>
				<p>If you do not think your current video file format is recognized by the ISTE storykeeper corps website, you may get the best results from converting your file to MPEG4 video with MP3 audio. If your format is recognized, but you are experiencing other issues with format errors, feel free to contact us, and we will try our best to fix it.</p>
				<p>Return to <a href="addvideo.php">the Add A Story Page</a></p>
			</div>
		</td>
	</tr>
</table>
<?
	include('includes/page-bottom.php');
?>