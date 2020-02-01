<?
 //Take down video. This will change the status of the video to removed. We need to verify the video status and user.
 
 	include('includes/security.php');
 	
 	if (isset($_POST['vid'])) {
 		
		require_once ('istetube-conf.php'); //Map the Connection.
		
		//first check to make sure there isn't already an account created with that email address.
		$query = "UPDATE videos SET
			video_status_id = 4
			WHERE vid = '".$_POST['vid']."'
			AND customer_id = ".$_SESSION['id'];
		
		$result = @mysql_query ($query); //Run the query.
		
		if ($result) {
				//include the header information
				include('includes/page-meta.php');
				include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<div style="font-size:14px; font-weight:bold; color:#666; background: #ffffff; height: 175px; padding-top: 100px; text-align: center;">
				<div style="font-size:14px; font-weight:bold; color:#666;">
					Your digital story was removed successfully.
				</div>
							
				<div style="font-size:14px; font-weight:bold; color:#666; padding-top: 25px;">
					Remember, it will have to be resubmitted to be re-posted.
				</div>
							
				<div style="font-size:14px; font-weight:bold; color:#666; padding-top: 25px;">
					<a href="myvideos.php">Click here to return to your list.</a>
				</div>
			</div>
		</td>
	</tr>
</table>
<?
				include('includes/page-bottom.php');
		} else {
				//include the header information
				include('includes/page-meta.php');
				include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<div style="font-size:14px; font-weight:bold; color:#666; background: #ffffff; height: 175px; padding-top: 100px; text-align: center;">
				<div style="font-size:14px; font-weight:bold; color:#666;">
					There was a problem.
				</div>
							
				<div style="font-size:14px; font-weight:bold; color:#666; padding-top: 25px;">
					The story was not taken down.
				</div>
							
				<div style="font-size:14px; font-weight:bold; color:#666; padding-top: 25px;">
					<a href="index.php">Click here to return to your list.</a>
				</div>
			</div>
		</td>
	</tr>
</table>
<?
				include('includes/page-bottom.php');
		}
 	}
?>