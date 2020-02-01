<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//prime the information
	if ($_REQUEST['id'] != '') {
		$status_id = $_REQUEST['id'];
		//save the information in a session
		$_SESSION['video_status_id'] = $_REQUEST['id'];
	} else {
		if ($_SESSION['video_status_id'] != '') {
			$status_id = $_SESSION['video_status_id'];
		} else {
			$status_id = 1;
		}
	}
	
	//sortable columns script
	if ($_REQUEST['order'] == '' && $_REQUEST['dir'] == '') {
		if ($_SESSION['video_order'] != '') {
			$order_by = $_SESSION['video_order'];
			$dir = $_SESSION['video_dir'];
		} else {
			$order_by = "videos.created_at";
			$dir = "asc";
		}
	} else {
		$order_by = $_REQUEST['order'];
		$dir = $_REQUEST['dir'];
		//Setting the session information so when they come back
		$_SESSION['video_order'] = $_REQUEST['order'];
		$_SESSION['video_dir'] = $_REQUEST['dir'];
	}
	
	//editable sort constants
	$b_url = "videos.php?"; //make sure and have a question mark as the end
	$c_url = "order="; //column name
	$d_url = "&dir="; //direction of sort
	$a_url = "&id=";
	
	//Query 1
	$sql_query = "select videos.id, vid, title, first_name, last_name, DATE_FORMAT(videos.created_at, '%b %D, %Y') as day, DATE_FORMAT(videos.created_at, '%h:%i %p') as time, status, featured
	FROM videos
	JOIN customers ON videos.customer_id = customers.id
	JOIN video_statuses ON videos.video_status_id = video_statuses.id ";

	//we need to do an all feature.
	if ($status_id == '0') {
		//There is no need to add in a where clause LEAVE empty
		$sql_query .= "WHERE !bad_video ";
	} else {
		//Add in the where clause
		$sql_query .= "WHERE !bad_video AND video_status_id = ".$status_id." ";
	}
	
	$sql_query .= "ORDER BY ".$order_by." ".$dir;
	
	$result = @mysql_query ($sql_query); //Run the query.
	
	$sql_query2 = $sql_query;
		
	//Query 2
	$sql_query = "select id, status
	FROM video_statuses
	ORDER BY id";
	
	$result2 = @mysql_query ($sql_query); //Run the query.


	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td colspan="2">
				<form id="form" name="form" method="post" action="videos.php">
				<table border="0" cellpadding="3" cellspacing="0" width="100%" bgcolor="#CCCCCC">
					<tr>
						<td align="right" width="50%">
							<strong>Current Status</strong>
						</td>
						<td align="center">
							<select name="id" size="1" id="id">
<?
	while ($statuses = mysql_fetch_array ($result2, MYSQL_ASSOC)) {
?>
							<option value="<?= $statuses['id'] ?>" <?=($statuses['id']==$status_id?'selected':'') ?>><?= $statuses['status'] ?></option>
<?
	}
?>
							<option value="0" <?=($status_id == '0' ? 'selected':'') ?>>All Statuses</option>
							</select>
						</td>
						<td align="left" width="50%">
							<input type="submit" name="button" id="button" value="Submit" />
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sorting">
					<tr>
<?
	$column = "last_name"; //this is the column name from the DB.
	if ($order_by == 'last_name') {
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
	$url = $b_url.$c_url.$column.$d_url.$direction.$a_url.$status_id; //build the url
?>
						<td class="<?= $style ?>">
							<a href="<?= $url ?>">Customer</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$column = "featured"; //this is the column name from the DB.
	if ($order_by == 'featured') {
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
	$url = $b_url.$c_url.$column.$d_url.$direction.$a_url.$status_id; //build the url
?>
						<td class="<?= $style ?>">
							<a href="<?= $url ?>">Featured</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
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
	$url = $b_url.$c_url.$column.$d_url.$direction.$a_url.$status_id; //build the url
?>
						<td class="<?= $style ?>">
							<a href="<?= $url ?>">Title</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$column = "videos.created_at"; //this is the column name from the DB.
	if ($order_by == 'videos.created_at') {
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
	$url = $b_url.$c_url.$column.$d_url.$direction.$a_url.$status_id; //build the url
?>
						<td class="<?= $style ?>">
							<a href="<?= $url ?>">Uploaded</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$col_number = "4";
	if ($status_id == '0') { //only show this column if status is ZERO(0)
	
		$col_number = "5";
		
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
		
		$url = $b_url.$c_url.$column.$d_url.$direction.$a_url.$status_id; //build the url
?>
						<td class="<?= $style ?>">
							<a href="<?= $url ?>">Status</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	}
?>
						<td class="sort_off">Options</td>
					</tr>
<?
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
						<td class="<?= $color ?>"><?= $videos['first_name'] ?> <?= $videos['last_name'] ?></td>
						<td class="<?= $color ?>"><?= ($videos['featured'] == "1" ? 'Yes' : 'No') ?></td>
						<td class="<?= $color ?>"><a href="videoapprovals.php?vid=<?= $videos['vid'] ?>"><?= $videos['title'] ?></a></td>
						<td class="<?= $color ?>"><?= $videos['day'] ?> at <?= $videos['time'] ?> PST</td>
<?
		if ($status_id == '0') { //only show this column if status is ZERO(0)
?>
						<td class="<?= $color ?>"><?= $videos['status'] ?></td>
<?
		}
?>
						<td class="<?= $color ?>"><a href="videoapprovals.php?vid=<?= $videos['vid'] ?>">Review</a></td>
					</tr>
<?
		$Records = FALSE; //set the records flag to ok			
	} //End the while loop
	
	//If there were no records then print the no records
	if ($Records) {
?>
					<tr>
						<td colspan="<?= $col_number ?>" class="even" style="text-align: center;">There are currently no Videos to list for this status.</td>
					</tr>
<?
	}
?>
				</table>
			</td>
		</tr>
<?
	include('includes/footer.php');
?>