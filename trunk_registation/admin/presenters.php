<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//sortable columns script
	if ($_REQUEST['order'] == '' && $_REQUEST['dir'] == '') {
		if ($_SESSION['presenter_order'] != '') {
			$order_by = $_SESSION['presenter_order'];
			$dir = $_SESSION['presenter_dir'];
		} else {
			$order_by = "last_name";
			$dir = "asc";
		}
	} else {
		$order_by = $_REQUEST['order'];
		$dir = $_REQUEST['dir'];
		//Setting the session information so when they come back
		$_SESSION['presenter_order'] = $_REQUEST['order'];
		$_SESSION['presenter_dir'] = $_REQUEST['dir'];
	}
	
	//editable sort constants
	$b_url = "presenters.php?"; //make sure and have a question mark as the end
	$c_url = "order="; //column name
	$d_url = "&dir="; //direction of sort
	$a_url = "&id=";
	
	//Query 1
	$sql_query = "select pid, first_name, last_name, email_address
	FROM lounge_presenters ";
	
	$sql_query .= "ORDER BY ".$order_by." ".$dir;
	
	$result = @mysql_query ($sql_query); //Run the query.
		
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td class="listing_topic">
				NECC Presenters
			</td>
			<td class="listing_add">
				
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
	$column = "email_address"; //this is the column name from the DB.
	if ($order_by == 'email_address') {
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
	while ($presenters = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		if ($color == "odd") {
			$color = "even";
		} else {
			$color = "odd";
		}
		
?>
					<tr>
						<td class="<?= $color ?>"><?= $presenters['last_name'] ?></td>
						<td class="<?= $color ?>"><?= $presenters['first_name'] ?></td>
						<td class="<?= $color ?>"><a href="mailto:<?= $presenters['email_address'] ?>"><?= $presenters['email_address'] ?></a></td>
						<td class="<?= $color ?>"><a href="viewpresenter.php?pid=<?= $presenters['pid'] ?>">Review/Edit</a></td>
					</tr>
<?
		$Records = FALSE; //set the records flag to ok			
	} //End the while loop
	
	//If there were no records then print the no records
	if ($Records) {
?>
					<tr>
						<td colspan="3" class="even" style="text-align: center;">There are currently no Presenters to list.</td>
					</tr>
<?
	}
?>
				</table>
			</td>
		</tr>
<?
	#include('../includes/footer.php');
?>