<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//sortable columns script
	if ($_REQUEST['order'] == '' && $_REQUEST['dir'] == '') {
		if ($_SESSION['admin_order'] != '') {
			$order_by = $_SESSION['admin_order'];
			$dir = $_SESSION['admin_dir'];
		} else {
			$order_by = "last_name";
			$dir = "asc";
		}
	} else {
		$order_by = $_REQUEST['order'];
		$dir = $_REQUEST['dir'];
		//Setting the session information so when they come back
		$_SESSION['admin_order'] = $_REQUEST['order'];
		$_SESSION['admin_dir'] = $_REQUEST['dir'];
	}
	
	//editable sort constants
	$b_url = "users.php?"; //make sure and have a question mark as the end
	$c_url = "order="; //column name
	$d_url = "&dir="; //direction of sort
	$a_url = "&id=";
	
	//Query 1
	$sql_query = "SELECT aid, first_name, last_name, email, type
	FROM administrators
	JOIN admin_type ON administrators.super = admin_type.id ";

	$sql_query .= "ORDER BY ".$order_by." ".$dir;
	
	$result = @mysql_query ($sql_query); //Run the query.
	
	$sql_query2 = $sql_query;
	
	$result2 = @mysql_query ($sql_query); //Run the query.


	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td>
				<div style="font-size: 12px; font-weight: bold; text-align: left; padding-bottom: 3px;">ISTE Administrators</div>
			</td>
			<td align="right">
				<a href="adduser.php">Add Administrator</a>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div style="font-size: 10px; background: #efefef; padding: 5px; text-align: left;">Administrators have access to work with the data. There are two kinds of Administrators. SuperUser have full access to everything and Standard which only have access to certain channels.</div>
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
							<a href="<?= $url ?>">Last Name</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$column = "first_name"; //this is the column name from the DB.
	if ($order_by == 'first_name') {
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
							<a href="<?= $url ?>">First Name</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$column = "type"; //this is the column name from the DB.
	if ($order_by == 'type') {
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
							<a href="<?= $url ?>">Type</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$column = "email"; //this is the column name from the DB.
	if ($order_by == 'email') {
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
							<a href="<?= $url ?>">Email</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
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
						<td class="<?= $color ?>"><a href="edituser.php?aid=<?= $videos['aid'] ?>"><?= $videos['last_name'] ?></a></td>
						<td class="<?= $color ?>"><a href="edituser.php?aid=<?= $videos['aid'] ?>"><?= $videos['first_name'] ?></a></td>
						<td class="<?= $color ?>"><?= $videos['type'] ?></td>
						<td class="<?= $color ?>"><?= $videos['email'] ?></td>
<?
		if ($status_id == '0') { //only show this column if status is ZERO(0)
?>
						<td class="<?= $color ?>"><?= $videos['status'] ?></td>
<?
		}
?>
						<td class="<?= $color ?>"><a href="edituser?aid=<?= $videos['aid'] ?>">Edit</a></td>
					</tr>
<?
		$Records = FALSE; //set the records flag to ok			
	} //End the while loop
	
	//If there were no records then print the no records
	if ($Records) {
?>
					<tr>
						<td colspan="4" class="even" style="text-align: center;">There are currently no Administrators to list.</td>
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