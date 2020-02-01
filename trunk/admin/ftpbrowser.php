<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	$BF = "";
	$ftp_upload_directory = "ftp/"; // Set this to the relative path to BF where files will be uploaded
	$move_to_folder = "../videos/original/"; // Set this to where the files should be moved to

	if(isset($_POST['file']) && $_POST['file'] != '') {
		//code for moving the vides and what not
		
		//make a sha1 string for the video linking
		$vid = sha1(uniqid(mt_rand(1000000,9999999).iste.time(), true));
		
		//build a new filename for the video file so we can use it
		$split_file = explode('.',$_POST['file']);
		$split_count = count($split_file);
		$extension = $split_file[$split_count-1];
		
		$vid_name = substr(md5($org_name.time()),0,15);
		
		//$size = sprintf("%u", filesize($BF.$ftp_upload_directory.$_POST['file'])) //<-- this is the file size
		
		//Make the query
		$query = "INSERT INTO videos SET
			customer_id = '0',
			owner_id = '1',
			vid = '".$vid."',
			size = '".round(($size / 1024),2)."',
			filename = '".$vid_name.".".$extension."',
			processed_file = '".$vid_name."',
			title = 'ISTE Content EDIT ME',
			extension = '".$extension."',
			ftp_status = '5',
			flv_status = '5',
			m4v_status = '5',
			jpg_status = '5',
			video_status_id = '5',
			created_at = '".date('Y-m-d H:i:s')."'";
			
		$result = @mysql_query ($query); //Run the query.
		
		//Move the video into the NFS share
		@rename($BF.$ftp_upload_directory.$_POST['file'], $BF.$move_to_folder.$vid_name.'.'.$extension);
	}
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
	
	function byteConvert($bytes)
    {
        $s = array('B', 'Kb', 'MB', 'GB', 'TB', 'PB');
        $e = floor(log($bytes)/log(1024));
       
        return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
    }
?>
		<tr>
			<td colspan="2">
				<div style="font-size: 12px; font-weight: bold; text-align: left; padding-bottom: 3px;">ISTE Story FTP Browser</div>
				<div style="font-size: 10px; background: #efefef; padding: 5px; text-align: left;">In order to make files appear on this page you need to upload large files to the FTP folder. After the upload it finished refresh the page. In order to have a video processed and then appear on the site click on process video.</div>
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
				<form id="form" name="form" method="post">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sorting">
					<tr>
						<td class="sort_on">Filename</td>
						<td class="sort_off">Size</td>
						<td class="sort_off">Created Date</td>
						<td class="sort_off">Updated</td>
						<td class="sort_off">Options</td>
					</tr>
<?
	$Records = TRUE; //Prime the Record Switch
	if ($handle = opendir($BF.$ftp_upload_directory)) { //put here your own folder e.g. opendir('c:\\temp')
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && $file != '.svn' && $file != '.profile' && $file != '.bashrc' && $file != '.bash_logout' && $file != '.bash_history') {
				$Records = FALSE; //set the records flag to ok
				//Line color changer
				if ($color == "odd") {
					$color = "even";
				} else {
					$color = "odd";
				}
?>
					<tr>
						<td class="<?= $color ?>"><?=$file?></td>
						<td class="<?= $color ?>"><?=byteConvert(sprintf("%u", filesize($BF.$ftp_upload_directory.$file)))?></td>
						<td class="<?= $color ?>"><?=date("F d Y H:i:s.", filectime($BF.$ftp_upload_directory.$file))?></td>
						<td class="<?= $color ?>"><?=date("F d Y H:i:s.", filemtime($BF.$ftp_upload_directory.$file))?></td>
						<td class="<?= $color ?>"><input type="button" value="Process this video" onclick="document.getElementById('file').value='<?=$file?>'; document.getElementById('form').submit();" /></td>
					</tr>
<?
				$filename = explode('.',$file);
				$flags[$filename[0]] = $file;
			}
		}
	}
?>
					<input type="hidden" name="file" id="file" value="" />
<?
	
	//If there were no records then print the no records
	if ($Records) {
?>
					<tr>
						<td colspan="5" class="even" style="text-align: center;">There are files in the upload directory.</td>
					</tr>
<?
	}
?>
				</table>
				</form>
			</td>
		</tr>
<?
	include('includes/footer.php');
?>