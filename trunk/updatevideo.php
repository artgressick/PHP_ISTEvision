<?php # Script 1.0 - Update Video

// This page will gather all of the information from the previous page and enter it into the database.
include('includes/security.php');

//Check the posting of the page to make sure is was not by-passed
if (isset($_POST['submit'])) {
	
	if ($_POST['title'] == "" || $_POST['description'] == "" || $_POST['terms'] == "") {
		header ("Location: errorform.php"); //throw an error
		exit();
	}	
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
		
	//Make the query
	$query = "UPDATE videos SET
		title = '".htmlentities($_POST['title'], ENT_QUOTES)."',
		updated_at = '".date('Y-m-d H:i:s')."',
		description = '".htmlentities($_POST['description'], ENT_QUOTES)."',
		meta_tags = '".htmlentities($_POST['meta_tags'], ENT_QUOTES)."',
		video_status_id = '1'
		WHERE vid = '".$_POST['vid']."'";
		
	$result = @mysql_query ($query); //Run the query.
	
	//$query1 = $query;
	
	//Original Channels -------------
	$sql_query = "select id
		FROM channels
		WHERE uploadable = 1
		ORDER BY display_order";
		
	$channel_result = @mysql_query ($sql_query); //Run the query.
		
	//Remove the existing channels and then Cycle through the channels and add them to the table.
	$remove_query = "delete from video_channels where video_id = ".$_POST['video_id'];
	$result = @mysql_query ($remove_query); //Run the query.
		
	$insert_query = "INSERT INTO video_channels (video_id, channel_id) VALUES (";
		
	$error_checker = 0;

	while ($channels = mysql_fetch_array ($channel_result, MYSQL_ASSOC)) {
		$channel_id = $channels['id'];

		if ($_POST[$channels['id']] > 0) {
			$insert_query .= $_POST['video_id'].",".$channels['id']."),(";
				
			$error_checker = 1;
		}
	}
		
	$insert_query = substr($insert_query, 0, -2);  // hack off the last 2 items
		
	if ($error_checker == 1) { //Dont run the insert command unless they checked something.
		$result = @mysql_query ($insert_query); //Run the query.
	}
		
	//Make the query
	$query = "UPDATE video_criteria SET
		elevel1 = '".(isset($_POST['elevel']) && in_array('1',$_POST['elevel'])?'1':'0')."',
		elevel2 = '".(isset($_POST['elevel']) && in_array('2',$_POST['elevel'])?'1':'0')."',
		elevel3 = '".(isset($_POST['elevel']) && in_array('3',$_POST['elevel'])?'1':'0')."',
		elevel4 = '".(isset($_POST['elevel']) && in_array('4',$_POST['elevel'])?'1':'0')."',
		elevel5 = '".(isset($_POST['elevel']) && in_array('5',$_POST['elevel'])?'1':'0')."',
		elevel6 = '".(isset($_POST['elevel']) && in_array('6',$_POST['elevel'])?'1':'0')."',
		content1 = '".(isset($_POST['content']) && in_array('1',$_POST['content'])?'1':'0')."',
		content2 = '".(isset($_POST['content']) && in_array('2',$_POST['content'])?'1':'0')."',
		content3 = '".(isset($_POST['content']) && in_array('3',$_POST['content'])?'1':'0')."',
		content4 = '".(isset($_POST['content']) && in_array('4',$_POST['content'])?'1':'0')."',
		content5 = '".(isset($_POST['content']) && in_array('5',$_POST['content'])?'1':'0')."',
		content6 = '".(isset($_POST['content']) && in_array('6',$_POST['content'])?'1':'0')."',
		cirricular1 = '".(isset($_POST['cirricular']) && in_array('1',$_POST['cirricular'])?'1':'0')."',
		cirricular2 = '".(isset($_POST['cirricular']) && in_array('2',$_POST['cirricular'])?'1':'0')."',
		cirricular3 = '".(isset($_POST['cirricular']) && in_array('3',$_POST['cirricular'])?'1':'0')."',
		cirricular4 = '".(isset($_POST['cirricular']) && in_array('4',$_POST['cirricular'])?'1':'0')."',
		cirricular5 = '".(isset($_POST['cirricular']) && in_array('5',$_POST['cirricular'])?'1':'0')."',
		cirricular6 = '".(isset($_POST['cirricular']) && in_array('6',$_POST['cirricular'])?'1':'0')."',
		cirricular7 = '".(isset($_POST['cirricular']) && in_array('7',$_POST['cirricular'])?'1':'0')."',
		cirricular8 = '".(isset($_POST['cirricular']) && in_array('8',$_POST['cirricular'])?'1':'0')."',
		cirricular9 = '".(isset($_POST['cirricular']) && in_array('9',$_POST['cirricular'])?'1':'0')."',
		cirricular10 = '".(isset($_POST['cirricular']) && in_array('10',$_POST['cirricular'])?'1':'0')."',
		decade1 = '".(isset($_POST['decade']) && in_array('1',$_POST['decade'])?'1':'0')."',
		decade2 = '".(isset($_POST['decade']) && in_array('2',$_POST['decade'])?'1':'0')."',
		decade3 = '".(isset($_POST['decade']) && in_array('3',$_POST['decade'])?'1':'0')."',
		decade4 = '".(isset($_POST['decade']) && in_array('4',$_POST['decade'])?'1':'0')."',
		decade5 = '".(isset($_POST['decade']) && in_array('5',$_POST['decade'])?'1':'0')."',
		decade6 = '".(isset($_POST['decade']) && in_array('6',$_POST['decade'])?'1':'0')."',
		relates1 = '".(isset($_POST['relates']) && in_array('1',$_POST['relates'])?'1':'0')."',
		relates2 = '".(isset($_POST['relates']) && in_array('2',$_POST['relates'])?'1':'0')."',
		relates3 = '".(isset($_POST['relates']) && in_array('3',$_POST['relates'])?'1':'0')."',
		relates4 = '".(isset($_POST['relates']) && in_array('4',$_POST['relates'])?'1':'0')."',
		relates5 = '".(isset($_POST['relates']) && in_array('5',$_POST['relates'])?'1':'0')."'
		WHERE vid = '".$_POST['vid']."'";
		
	$result = @mysql_query ($query); //Run the query.

	$query2 = $query;
	
	if ($result) {
		//redirect the user to the homepage now.
		header ('Location: index.php');
		exit();
			
	} else { //No match was made
		header ("Location: errorform.php"); //throw an error
		exit();
	}

	mysql_close(); //close the connection
	
} //end the statement and redirect if we went this far.
?>
Output = <?= $query1 ?><br />
Output2 = <?= $query2 ?>