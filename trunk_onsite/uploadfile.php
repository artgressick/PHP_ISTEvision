<?php # Script 1.0 - Upload Video

// This page will gather all of the information from the previous page and enter it into the database.
include('includes/security.php');
include('includes/_lib.php');

//Check the posting of the page to make sure is was not by-passed
if (isset($_POST['upload'])) {
	
	if ($_POST['title'] == "" || $_POST['description'] == "" || $_POST['terms'] == "") {
		header ("Location: errorform.php"); //throw an error
		exit();
	}	
	
	//check the file upload information before processing any information
	if ((($_FILES['org_file']['type'] == "video/x-msvideo") || ($_FILES['org_file']['type'] == "video/x-ms-wmv") || ($_FILES['org_file']['type'] == "video/quicktime") ||
	($_FILES['org_file']['type'] == "video/x-m4v")) && ($_FILES['org_file']['size'] < 185000000)) {
		
		//Register the user in the database
		require_once ('istetube-conf.php'); //Map the Connection.
		
		//make a sha1 string for the video linking
		$vid = sha1(uniqid(mt_rand(1000000,9999999).iste.time(), true));
		
		//Figuring out some of the other options
		$org_name = $_FILES['org_file']['name'];
		$size = $_FILES['org_file']['size'];
		$type = $_FILES['org_file']['type'];
		$error_code = $_FILES["org_file"]["error"]; //put this one first to make sure it transfers should be "0" if everything is ok
		$extension = end(explode('.', $org_name));
		
		//build a new filename for the video file so we can use it
		$vid_name = substr(md5($org_name.time()),0,15);
		
		//this is the place where we are going to want to push the files.
		$uploaddir = 'videos/original/';
		
		//Make the query
		$query = "INSERT INTO videos SET
			customer_id = '".$_SESSION['user_id']."',
			owner_id = '2',
			vid = '".$vid."',
			size = '".round(($size / 1024),2)."',
			filename = '".$vid_name.".".$extension."',
			processed_file = '".$vid_name."',
			title = '".encode($_POST['title'])."',
			extension = '".$extension."',
			created_at = '".date('Y-m-d H:i:s')."',
			description = '".encode($_POST['description'])."',
			meta_tags = '".encode($_POST['meta_tags'])."'";
		
		$result = @mysql_query ($query); //Run the query.
		
		$myid =  @mysql_insert_id(); //this is the record from the insert
		
		//Now insert the extra information for search criteria and tracking
		//Make the query
		$query = "INSERT INTO video_criteria SET
			video_id = '".$myid."',
			vid = '".$vid."',
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
			relates5 = '".(isset($_POST['relates']) && in_array('5',$_POST['relates'])?'1':'0')."'";
		
		$result = @mysql_query ($query); //Run the query.
		
		//Insert the channel(s) ----------------------------
		$sql_query = "select id
		FROM channels
		WHERE uploadable = 1
		ORDER BY display_order";
		
		$channel_result = @mysql_query ($sql_query); //Run the query.
		
		$insert_query = "INSERT INTO video_channels (video_id, channel_id) VALUES (";
		
		$error_checker = 0;

		while ($channels = mysql_fetch_array ($channel_result, MYSQL_ASSOC)) {
			$channel_id = $channels['id'];

			if ($_POST[$channels['id']] > 0) {
				$insert_query .= $myid.",".$channels['id']."),(";
				
				$error_checker = 1;
			}
		}
		
		$insert_query = substr($insert_query, 0, -2);  // hack off the last 2 items
		
		if ($error_checker == 1) { //Dont run the insert command unless they checked something.
			$result = @mysql_query ($insert_query); //Run the query.
		}
		
		//######################
		//Start to upload the file to the directory.
		//$attName = strtolower(str_replace(" ","_",basename($_FILES['org_file']['name'])));  //dtn: Replace any spaces with underscores.
		
		//$uploadfile = $uploaddir . $myid .'-'. $attName;
		$uploadfile = $uploaddir . $vid_name.'.'.$extension;
				
		move_uploaded_file($_FILES['org_file']['tmp_name'], $uploadfile);  //dtn: move the file to where it needs to go.
		//$attachments[] = $uploadfile;
		
		//#########################
	
		if ($result) {
			//Send an email to the administrator for testing.
			$to  = "Donella Evoniuk <devoniuk@iste.org>, Anita McAnear <amcanear@iste.org>, Eric Quetschke <equetschke@iste.org>, Jeniffer Raganfore <jraganfore@iste.org>, Linda Wallace <lwallace@iste.org>, David Washburn <dwashburn@techitsolutions.com>, Arthur Gressick <agressick@techitsolutions.com>"; // note the comma
			$subject = 'New Story Uploaded';
			$message = '
<html>
<head>
  <title>ISTE storytelling corps</title>
</head>
<body>
<p>THIS IS AN AUTOMATED MESSAGE - PLEASE DO NOT REPLY DIRECTLY TO THIS MESSAGE</p>
<p></p>
  <table>
    <tr>
      <td><a href="http://www.istevision.org/admin">Review the Video</a>
      <p></p>
      <p>Thank you</p>
      </td>
    </tr>
  </table>
</body>
</html>
';
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: istevision <webmaster@istevision.org>' . "\r\n";
			$headers .= 'Reply-To: noreply <noreply@istevision.org>' . "\r\n";
			$headers .= 'Return-Path: noreply <noreply@istevision.org>' . "\r\n";
			
			mail($to, $subject, $message, $headers, '-fwebmaster@istevision.org');
			
			//redirect the user to their videos now.
			header ('Location: mystories.php');
			exit();
			
		} else { //No match was made
			header ("Location: errorupload.php"); //throw an error
			exit();
		}

		mysql_close(); //close the connection
	} else {
		header ("Location: errorupload.php"); //throw an error
		exit();
	}
} //end the statement and redirect if we went this far.
?>