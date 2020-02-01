<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//sortable columns script
	if ($_REQUEST['order'] == '' && $_REQUEST['dir'] == '') {
		$order_by = "created_at";
		$dir = "asc";
	} else {
		$order_by = $_REQUEST['order'];
		$dir = $_REQUEST['dir'];
	}
	
	//editable sort constants
	$b_url = "myvideos.php?"; //make sure and have a question mark as the end
	$c_url = "order="; //column name
	$d_url = "&dir="; //direction of sort
	
	//This is for the User Profile. We need to get the information and display it on the page below.
	$sql_query = "select videos.vid, title, DATE_FORMAT(created_at, '%b %D, %Y') as day, DATE_FORMAT(created_at, '%h:%i %p') as time, status, video_status_id,
	(SELECT count(video_id) FROM views WHERE videos.id = views.video_id) as total_views	
	FROM videos
	JOIN video_statuses ON videos.video_status_id = video_statuses.id
	WHERE customer_id = '" . $_SESSION['id'] . "'
	ORDER BY ".$order_by." ".$dir;
	
	$result = @mysql_query ($sql_query); //Run the query.
	
	//Page title.
	$page_title = "My Videos";

	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #efefef;">
				<tr>
					<td>
						<div class="topic">
							My Stories
						</div>
					</td>
					<td>
						<div class="settings">
							<a href="addvideo.php">Post a Story</a>
						</div>
					</td>
				</tr>
			</table>
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sorting">
				<tr>
<?
	$column = "title"; //this is the column name from the DB.
	if ($order_by == 'title') {
		$style = "sort_on";
		if ($dir == 'asc') {
			$direction = "desc";
			$img = "sorted_asc.gif";
		} else {
			$direction = "asc";
			$img = "sorted_desc.gif";
		}
	} else {
		$style = "sort_off";
		$direction = "asc";
		$img = "unsorted.gif";
	}
	$url = $b_url.$c_url.$column.$d_url.$direction; //build the url
?>
					<td class="<?= $style ?>">
						<a href="<?= $url ?>">Title</a> 
						<a href="<?= $url ?>"><img src="images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
					</td>
<?
	$column = "created_at"; //this is the column name from the DB.
	if ($order_by == 'created_at') {
		$style = "sort_on";
		if ($dir == 'asc') {
			$direction = "desc";
			$img = "sorted_asc.gif";
		} else {
			$direction = "asc";
			$img = "sorted_desc.gif";
		}
	} else {
		$style = "sort_off";
		$direction = "asc";
		$img = "unsorted.gif";
	}
	$url = $b_url.$c_url.$column.$d_url.$direction; //build the url
?>
					<td class="<?= $style ?>">
						<a href="<?= $url ?>">Date Uploaded</a> 
						<a href="<?= $url ?>"><img src="images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
					</td>
<?
	$column = "status"; //this is the column name from the DB.
	if ($order_by == 'status') {
		$style = "sort_on";
		if ($dir == 'asc') {
			$direction = "desc";
			$img = "sorted_asc.gif";
		} else {
			$direction = "asc";
			$img = "sorted_desc.gif";
		}
	} else {
		$style = "sort_off";
		$direction = "asc";
		$img = "unsorted.gif";
	}
	$url = $b_url.$c_url.$column.$d_url.$direction; //build the url
?>						
					<td class="<?= $style ?>">
						<a href="<?= $url ?>">Status</a> 
						<a href="<?= $url ?>"><img src="images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
					</td>
<?
	$column = "total_views"; //this is the column name from the DB.
	if ($order_by == 'total_views') {
		$style = "sort_on";
		if ($dir == 'asc') {
			$direction = "desc";
			$img = "sorted_asc.gif";
		} else {
			$direction = "asc";
			$img = "sorted_desc.gif";
		}
	} else {
		$style = "sort_off";
		$direction = "asc";
		$img = "unsorted.gif";
	}
	$url = $b_url.$c_url.$column.$d_url.$direction; //build the url
?>						
					<td class="<?= $style ?>">
						<a href="<?= $url ?>"># Viewed</a> 
						<a href="<?= $url ?>"><img src="images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
					</td>
						
					<td class="sort_off">Options</td>
				</tr>
<? //we need to convert this to work
	$Records = TRUE; //Prime the Record Switch	
	//If there are not records then we need to print an error
	while ($videos = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		if ($color == "odd") {
			$color = "even";
		} else {
			$color = "odd";
		}
?>
				<tr>
					<td class="<?= $color ?>"><a href="watchvideo.php?vid=<?= $videos['vid']?>"><?= $videos['title'] ?></a></td>
					<td class="<?= $color ?>"><?= $videos['day']?> at <?= $videos['time']?> PST</td>
					<td class="<?= $color ?>"><?= $videos['status']?></td>
					<td class="<?= $color ?>"><?= $videos['total_views']?></td>
					<td class="<?= $color ?>" nowrap>
<?
	//we need to figure out the status so that they can do some of the changes.
	$divider = 0;
	if ($videos['video_status_id'] == '1' || $videos['video_status_id'] == '3' || $videos['video_status_id'] == '4') {
?>
						<a href="editvideo.php?vid=<?= $videos['vid']?>">Edit</a>
<?
		$divider = 1;
	}
	if ($videos['video_status_id'] == '1' || $videos['video_status_id'] == '2' || $videos['video_status_id'] == '3') {
		if ($divider == 1) {
?>
						&nbsp;|&nbsp;
<?
		}
?>
						<a href="removevideo.php?vid=<?= $videos['vid']?>">Take Down</a>
<?
	}
?>
					</td>
				</tr>
<?
		$Records = FALSE; //set the records flag to ok			
	} //End the while loop
	
	//If there were no records then print the no records
	if ($Records) {
?>
				<tr align="center">
					<td height="20" colspan="5" style="background:#FFF;"><font size="1" face="Arial, Helvetica, sans-serif">You haven't added any stories yet. <a href="addvideo.php">Add a story today</a></font></td>
				</tr>
<?
	}
?>
			</table>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>