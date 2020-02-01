<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//prime the information
	if ($_REQUEST['id'] != '') {
		$location_id = $_REQUEST['id'];
		//save the information in a session
		$_SESSION['location_id'] = $_REQUEST['id'];
	} else {
		if ($_SESSION['location_id'] != '') {
			$location_id = $_SESSION['location_id'];
		} else {
			$location_id = 0;
		}
	}
	
	//sortable columns script
	if ($_REQUEST['order'] == '' && $_REQUEST['dir'] == '') {
		if ($_SESSION['session_order'] != '') {
			$order_by = $_SESSION['session_order'];
			$dir = $_SESSION['session_dir'];
		} else {
			$order_by = "lounge_locations.name";
			$dir = "asc";
		}
	} else {
		$order_by = $_REQUEST['order'];
		$dir = $_REQUEST['dir'];
		//Setting the session information so when they come back
		$_SESSION['session_order'] = $_REQUEST['order'];
		$_SESSION['session_dir'] = $_REQUEST['dir'];
	}
	
	//editable sort constants
	$b_url = "index.php?"; //make sure and have a question mark as the end
	$c_url = "order="; //column name
	$d_url = "&dir="; //direction of sort
	$a_url = "&id=";
	
	//Query 1
	$sql_query = "select sid, first_name, last_name, title, DATE_FORMAT(lounge_sessions.date, '%b %D, %Y') as day, DATE_FORMAT(lounge_sessions.begin_time, '%h:%i %p') as begins, DATE_FORMAT(lounge_sessions.end_time, '%h:%i %p') as ends, name
	FROM lounge_sessions
	JOIN lounge_presenters ON lounge_sessions.presenter_id = lounge_presenters.id
	JOIN lounge_locations ON lounge_sessions.location_id = lounge_locations.id ";

	//we need to do an all feature.
	if ($location_id == '0') {
		//There is no need to add in a where clause LEAVE empty
	
	} else {
		//Add in the where clause
		$sql_query .= "WHERE location_id = ".$location_id." ";
	}
	
	$sql_query .= "ORDER BY ".$order_by." ".$dir;
	
	$result = @mysql_query ($sql_query); //Run the query.
	
	$sql_query2 = $sql_query;
		
	//Query 2
	$sql_query = "select id, name
	FROM lounge_locations
	ORDER BY name";
	
	$result2 = @mysql_query ($sql_query); //Run the query.


	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td class="listing_topic">
				NECC Lounge Sessions	
			</td>
			<td class="listing_add">
				
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<form id="form" name="form" method="post" action="index.php">
				<table border="0" cellpadding="3" cellspacing="0" width="100%" bgcolor="#CCCCCC">
					<tr>
						<td align="right" width="50%">
							<strong>Location</strong>
						</td>
						<td align="center">
							<select name="id" size="1" id="id">
<?
	while ($locations = mysql_fetch_array ($result2, MYSQL_ASSOC)) {
?>
							<option value="<?= $locations['id'] ?>" <?=($locations['id']==$location_id?'selected':'') ?>><?= $locations['name'] ?></option>
<?
	}
?>
							<option value="0" <?=($location_id == '0' ? 'selected':'') ?>>All Locations</option>
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
							<a href="<?= $url ?>">Presenter</a> 
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
	$column = "date"; //this is the column name from the DB.
	if ($order_by == 'date') {
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
							<a href="<?= $url ?>">Date</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$column = "begin_time"; //this is the column name from the DB.
	if ($order_by == 'begin_time') {
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
							<a href="<?= $url ?>">Begin Time</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$column = "end_time"; //this is the column name from the DB.
	if ($order_by == 'end_time') {
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
							<a href="<?= $url ?>">End Time</a> 
							<a href="<?= $url ?>"><img src="../images/<?= $img ?>" border="0" style="padding-top: 0px; padding-left: 10px;"></a>
						</td>
<?
	$col_number = "4";
	if ($location_id == '0') { //only show this column if status is ZERO(0)
	
		$col_number = "5";
		
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
							<a href="<?= $url ?>">Location</a> 
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
	while ($sessions = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		if ($color == "odd") {
			$color = "even";
		} else {
			$color = "odd";
		}
		
?>
					<tr>
						<td class="<?= $color ?>"><?= $sessions['first_name'] ?> <?= $sessions['last_name'] ?></td>
						<td class="<?= $color ?>"><a href="viewsession.php?sid=<?= $sessions['sid'] ?>"><?= $sessions['title'] ?></a></td>
						<td class="<?= $color ?>"><?= $sessions['day'] ?></td>
						<td class="<?= $color ?>"><?= $sessions['begins'] ?> PST</td>
						<td class="<?= $color ?>"><?= $sessions['ends'] ?> PST</td>
<?
		if ($location_id == '0') { //only show this column if status is ZERO(0)
?>
						<td class="<?= $color ?>"><?= $sessions['name'] ?></td>
<?
		}
?>
						<td class="<?= $color ?>"><a href="viewsession.php?sid=<?= $sessions['sid'] ?>">Review</a></td>
					</tr>
<?
		$Records = FALSE; //set the records flag to ok			
	} //End the while loop
	
	//If there were no records then print the no records
	if ($Records) {
?>
					<tr>
						<td colspan="<?= $col_number ?>" class="even" style="text-align: center;">There are currently no Sessions to list for this location.</td>
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