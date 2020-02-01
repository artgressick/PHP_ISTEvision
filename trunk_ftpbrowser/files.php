<?php
	$BF = "";
	$ftp_upload_directory = "ftp_upload/"; // Set this to the relative path to BF where files will be uploaded
	$move_to_folder = "ftp_upload/"; // Set this to where the files should be moved to

	if(isset($_POST['file']) && $_POST['file'] != '') {
		rename($BF.$ftp_upload_directory.$_POST['file'], $BF.$move_to_folder.$_POST['file']);	
	}
	
	//include the header information
	include($BF.'includes/head.php');
	include($BF.'includes/top.php');

    function byteConvert($bytes)
    {
        $s = array('B', 'Kb', 'MB', 'GB', 'TB', 'PB');
        $e = floor(log($bytes)/log(1024));
       
        return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
    }

?>
		<tr>
			<td colspan="3">
				<form method="post" name="form1" id="form1" style="padding:0; margin:0;">
				<table cellpadding="3" cellspacing="0" style="width:100%;" border="1">
					<tr>
						<th>Filename</th>
						<th>Size</th>
						<th>Created Date</th>
						<th>Updated Date</th>
						<th style="width:10px;">Options</th>
					</tr>
					
			
<?
	if ($handle = opendir($BF.$ftp_upload_directory)) { //put here your own folder e.g. opendir('c:\\temp')
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && $file != '.svn' ) {


?>
					<tr>
						<td><?=$file?></td>
						<td><?=byteConvert(sprintf("%u", filesize($BF.$ftp_upload_directory.$file)))?></td>
						<td><?=date("F d Y H:i:s.", filectime($BF.$ftp_upload_directory.$file))?></td>
						<td><?=date("F d Y H:i:s.", filemtime($BF.$ftp_upload_directory.$file))?></td>
						<td><input type="button" value="Move" onclick="document.getElementById('file').value='<?=$file?>'; document.getElementById('form1').submit();" /></td>
					</tr>
<?		
				$filename = explode('.',$file);
				$flags[$filename[0]] = $file;
			}
		}
	}

?>
					<input type="hidden" name="file" id="file" value="" />
				</table>
				</form>
			</td>
		</tr>
<?
	include($BF.'includes/footer.php');
?>