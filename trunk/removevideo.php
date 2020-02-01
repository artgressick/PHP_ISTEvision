<?php
	include('includes/security.php');
	
	#Load some variables in here.
	$tab = "live";
	$page_title = "Confirmation";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<form id="video" name="video" method="post" action="deletevideo.php">
			<div style="font-size:14px; font-weight:bold; color:#666; background: #ffffff; height: 200px; padding-top: 75px; text-align: center;">
				<div style="font-size:14px; font-weight:bold; color:#666;">
					Take down digital story?
				</div>
							
				<div style="font-size:14px; font-weight:bold; color:#666; padding-top: 25px;">
					Once you take down the story you will have to re-apply to have it activated.
				</div>
							
				<div style="font-size:14px; font-weight:bold; color:#666; padding-top: 25px;">
					If you want to continue taking down your story press the button below.
				</div>
							
				<div style="font-size:14px; font-weight:bold; color:#666; padding-top: 25px;">
					<input type="submit" name="button" id="button" value="Take down story" />
					<input type="hidden" name="vid" id="vid" value="<?= $_REQUEST['vid'] ?>" />
				</div>
			</div>
			</form>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>