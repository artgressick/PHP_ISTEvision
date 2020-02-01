<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//sortable columns script
	if ($_REQUEST['order'] == '' && $_REQUEST['dir'] == '') {
		if ($_SESSION['channel_order'] != '') {
			$order_by = $_SESSION['channel_order'];
			$dir = $_SESSION['channel_dir'];
		} else {
			$order_by = "display_order";
			$dir = "asc";
		}
	} else {
		$order_by = $_REQUEST['order'];
		$dir = $_REQUEST['dir'];
		//Setting the session information so when they come back
		$_SESSION['channel_order'] = $_REQUEST['order'];
		$_SESSION['channel_dir'] = $_REQUEST['dir'];
	}
	
	//editable sort constants
	$b_url = "channels.php?"; //make sure and have a question mark as the end
	$c_url = "order="; //column name
	$d_url = "&dir="; //direction of sort
	$a_url = "&id=";
	
	//Query 1
	$sql_query = "select channels.id, cid, homepage, uploadable, visible, display_order, name, first_name, last_name
	FROM channels
	JOIN administrators ON channels.administrator_id = administrators.id ";

	$sql_query .= "ORDER BY ".$order_by." ".$dir;
	
	$result = @mysql_query ($sql_query); //Run the query.
	
	$sql_query2 = $sql_query;
		
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td>
				<div style="font-size: 12px; font-weight: bold; text-align: left; padding-bottom: 3px;">ISTE Channels</div>
			</td>
			<td align="right">
				<a href="addchannel.php">Add Channel</a>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div style="font-size: 10px; background: #efefef; padding: 5px; text-align: left;">Channels are used to break up all of the videos into sections. You can decide to display the channels on the homepage, hide them, or change the order of the channels are they are displayed.</div>
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sorting">
					<tr>
<?
	$column = "name"; //this is the column name from the DB.
	if ($order_by == 'name') {
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
							<a href="<?= $url ?>">Channel</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$column = "homepage"; //this is the column name from the DB.
	if ($order_by == 'homepage') {
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
							<a href="<?= $url ?>">Homepage Display</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$column = "uploadable"; //this is the column name from the DB.
	if ($order_by == 'uploadable') {
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
							<a href="<?= $url ?>">Uploadable</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$column = "visible"; //this is the column name from the DB.
	if ($order_by == 'visible') {
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
							<a href="<?= $url ?>">Visible</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$column = "display_order"; //this is the column name from the DB.
	if ($order_by == 'display_order') {
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
							<a href="<?= $url ?>">Display Order</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
						<td class="sort_off">Options</td>
					</tr>
<?
	$Records = TRUE; //Prime the Record Switch	
	//If there are not records then we need to print an error
	while ($channels = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		if ($color == "odd") {
			$color = "even";
		} else {
			$color = "odd";
		}
		
?>
					<tr>
						<td class="<?= $color ?>"><?= $channels['name'] ?></td>
						<td class="<?= $color ?>"><?= ($channels['homepage'] == "1" ? 'Yes' : 'No') ?></td>
						<td class="<?= $color ?>"><?= ($channels['uploadable'] == "1" ? 'Yes' : 'No') ?></td>
						<td class="<?= $color ?>"><?= ($channels['visible'] == "1" ? 'Yes' : 'No') ?></td>
						<td class="<?= $color ?>"><?= $channels['display_order'] ?></td>
						<td class="<?= $color ?>"><a href="editchannel.php?cid=<?= $channels['cid'] ?>">Edit</a></td>
					</tr>
<?
		$Records = FALSE; //set the records flag to ok			
	} //End the while loop
	
	//If there were no records then print the no records
	if ($Records) {
?>
					<tr>
						<td colspan="6" class="even" style="text-align: center;">There are currently no Channels to list.</td>
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