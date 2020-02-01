<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//prime the information
	if ($_POST['id'] > 0) {
		$status_id = $_POST['id'];
	} else {
		$status_id = 1;
	}
	
	//Query 1
	$sql_query = "select videos.id, title, created_at, first_name, last_name, DATE_FORMAT(created_at, '%b %D, %Y') as day, DATE_FORMAT(created_at, '%h:%i %p') as time
	FROM videos
	JOIN customers on videos.customer_id = customers.id
	WHERE video_status_id = ". $status_id ."
	ORDER BY created_at";
	
	$result = @mysql_query ($sql_query); //Run the query.
	
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
				I am going to put in some stats here to help with the site. Goto the videos at the top to see what has been uploaded.
			</td>
		</tr>
<?
	include('includes/footer.php');
?>