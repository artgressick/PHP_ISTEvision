<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//sortable columns script
	if ($_REQUEST['order'] == '' && $_REQUEST['dir'] == '') {
		if ($_SESSION['location_order'] != '') {
			$order_by = $_SESSION['location_order'];
			$dir = $_SESSION['location_dir'];
		} else {
			$order_by = "lounge_locations.name";
			$dir = "asc";
		}
	} else {
		$order_by = $_REQUEST['order'];
		$dir = $_REQUEST['dir'];
		//Setting the session information so when they come back
		$_SESSION['location_order'] = $_REQUEST['order'];
		$_SESSION['location_dir'] = $_REQUEST['dir'];
	}
	
	//editable sort constants
	$b_url = "locations.php?"; //make sure and have a question mark as the end
	$c_url = "order="; //column name
	$d_url = "&dir="; //direction of sort
	$a_url = "&id=";
	
	//Query 1
	$sql_query = "select id, lid, name
	FROM lounge_locations ";
	
	$sql_query .= "ORDER BY ".$order_by." ".$dir;
	
	$result = @mysql_query ($sql_query); //Run the query.
			
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td class="listing_topic">
				NECC Lounge Locations	
			</td>
			<td class="listing_add">
				<a href="addlocation.php">Add Location</a>
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
							<a href="<?= $url ?>">Location Name</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
						<td class="sort_off">Options</td>
					</tr>
<?
	$Records = TRUE; //Prime the Record Switch	
	//If there are not records then we need to print an error
	while ($locations = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		if ($color == "odd") {
			$color = "even";
		} else {
			$color = "odd";
		}
		
?>
					<tr>
						<td class="<?= $color ?>"><?= $locations['name'] ?></td>
						<td class="<?= $color ?>"><a href="editlocation.php?lid=<?= $locations['lid'] ?>">Edit</a></td>
					</tr>
<?
		$Records = FALSE; //set the records flag to ok			
	} //End the while loop
	
	//If there were no records then print the no records
	if ($Records) {
?>
					<tr>
						<td colspan="2" class="even" style="text-align: center;">There are currently no locations to list.</td>
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