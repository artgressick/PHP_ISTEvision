<?php
	include('includes/security.php');
	
	//Get the location information
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//Query 1
	$sql_query = "select sid, first_name, last_name, title, DATE_FORMAT(lounge_sessions.date, '%b %D, %Y') as day, DATE_FORMAT(lounge_sessions.begin_time, '%h:%i %p') as begins, DATE_FORMAT(lounge_sessions.end_time, '%h:%i %p') as ends, name, description
	FROM lounge_sessions
	JOIN lounge_presenters ON lounge_sessions.presenter_id = lounge_presenters.id
	JOIN lounge_locations ON lounge_sessions.location_id = lounge_locations.id
	WHERE sid = '".$_REQUEST['sid']."'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	
	$session = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td class="listing_topic" style="border-bottom: 1px solid #c0c0c0;">
				View NECC Lounge Session
			</td>
			<td class="listing_add" style="border-bottom: 1px solid #c0c0c0;">
			
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
					<tr>
						<td width="50%">
							<span class="view_field">Presenter</span><span class="view_output">: <?= $session['first_name'] ?> <?= $session['last_name'] ?></span>
						</td>
						<td width="50%">
							<span class="view_field">Date</span><span class="view_output">: <?= $session['day'] ?></span>
						</td>
					</tr>
					<tr>
						<td>
							<span class="view_field">Location</span><span class="view_output">: <?= $session['name'] ?></span>
						</td>
						<td>
							<span class="view_field">Time</span><span class="view_output">: <?= $session['begins'] ?> to <?= $session['ends'] ?></span>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-top: 15px;">
							<span class="view_field">Session Title</span><span class="view_output">: <?= $session['title'] ?></span>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-top: 5px;">
							<span class="view_field">Session Description</span><span class="view_output">: <?= $session['description'] ?></span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
<?
	#include('../includes/footer.php');
?>