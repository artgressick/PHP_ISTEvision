<?php
	//include('includes/security.php');
	session_start(); //Do not use this code if you include the security above.
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection
	require_once ('includes/_lib.php'); //Map the Connection
	
	if(@$_REQUEST['function'] == 'add_comment') {
		
		$sql_query = "INSERT INTO comments SET
			video_id = '".$_REQUEST['video_id']."',
			customer_id = '".$_SESSION['id']."',
			comment = '".encode($_REQUEST['comment'])."',
			created_at = '".date('Y-m-d H:i:s')."'";
	
		if(@mysql_query ($sql_query)) {
			echo 'true';
		}
	} else if(@$_REQUEST['function'] == 'get_comments') {
			$sql_query = "SELECT c.id, c.video_id, c.comment, c.created_at, c.bshow, c.customer_id, u.first_name, u.last_name
			FROM comments AS c
			JOIN customers AS u ON c.customer_id=u.id
			WHERE c.video_id='".$_REQUEST['video_id']."'
			ORDER BY created_at DESC
			";
		
		$result = @mysql_query ($sql_query);
		if(mysql_num_rows($result) > 0) {
?>
		<table cellpadding="3" cellspacing="0" style="width:100%;">
<?		
			$cnt = 0;
			while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
				if($row['bshow'] || $row['customer_id'] == @$_SESSION['id']) {
			
			$options = '';
			if($row['customer_id'] == $_SESSION['id']) {
				if($row['bshow']) {
					$options = '<input type="button" value="Hide" onclick="hide_comment(\'\',\''.$row['id'].'\',\''.$row['video_id'].'\');" />';
				} else {
					$options = '<input type="button" value="Show" onclick="show_comment(\'\',\''.$row['id'].'\',\''.$row['video_id'].'\');" />';
				}
			}
?>
			<tr>
				<td style='border-left:1px solid #999; border-top:1px solid #999; font-size:10px;'>On <?=date('D, M. j Y g:i a',strtotime($row['created_at']))?>, <?=$row['first_name'].' '.$row['last_name']?> wrote: <?=(!$row['bshow']?' [HIDDEN]':'')?></td>
				<td style="border-right:1px solid #999; border-top:1px solid #999; width:10px; white-space:nowrap;"><?=$options?></td>
			</tr>
			<tr>
				<td colspan='2' style="border-left:1px solid #999; border-bottom:1px solid #999; border-right:1px solid #999;<?=(!$row['bshow']?' color:#666;':'')?>">
					<?=$row['comment']?>
				</td>
			</tr>
			
<?			
				$cnt++;
				}
			}
		if($cnt == 0) {
?>
			<tr>
				<td style="font-style: italic; text-align:center;">No comments have been added to this video.</td>
			</tr>
<?		
		}
?>
		</table>
<?
		} else {
?>
		<div style="font-style: italic; text-align:center;">No comments have been added to this video.</div>
<?			
		}
	} else if(@$_REQUEST['function'] == 'hide_comment') {
		$sql_query = "UPDATE comments SET
			bshow = 0
			WHERE id = '".$_REQUEST['id']."'";
	
		if(@mysql_query ($sql_query)) {
			echo 'true';
		}
		
	
	} else if(@$_REQUEST['function'] == 'show_comment') {
		$sql_query = "UPDATE comments SET
			bshow = 1
			WHERE id = '".$_REQUEST['id']."'";
	
		if(@mysql_query ($sql_query)) {
			echo 'true';
		}
		
	
	}
?>