<?
	$BF = "";
	$NON_HTML_PAGE = true;
	require('_lib.php');
	
	$events = array();
	$cnt = 0;
	while ($cnt < 24) {
		$events[strtotime(date('Y-m-d').' '.$cnt.':00:00.0').'-'.strtotime(date('Y-m-d').' '.($cnt+1==24?0:$cnt+1).':00:00.0')] = array(
			'event'=>'Test Event '.$cnt,
			'description'=>'This is the '.$cnt.' event today. This is simply a test of this system',
			'presenter'=>'Jason '.$cnt);
		$cnt++;
	}
	
	
	if($_REQUEST['postType'] == "delete") {
		$total = 0;
		echo $q = "UPDATE ". $_REQUEST['tbl'] ." SET deleted=1, updated_at=NOW() WHERE id=".$_REQUEST['id'];
		if(db_query($q,"update deleted")) { 
			$total++;
			$q = "INSERT INTO audit SET user_id=".$_REQUEST['user_id'].", record_id=".$_REQUEST['id'].", table_name='". $_REQUEST['tbl'] ."', column_name='deleted', created_at=now(), 
					old_value='0', new_value='1', audittype_id=3"; 
			if(db_query($q,"insert into audit")) { $total += 2; }
		}
  		echo $total;
	} else if(@$_REQUEST['postType'] == "permDelete") {
		$total = 0;
		$q = "DELETE FROM ". $_REQUEST['tbl'] ." WHERE id=".$_REQUEST['id'];
		if(db_query($q,"perm delete")) { 
			$total++;
			$q = "INSERT INTO audit SET user_id=".$_REQUEST['user_id'].", record_id=".$_REQUEST['id'].", table_name='". $_REQUEST['tbl'] ."', column_name='', created_at=now(), 
					old_value='', new_value='', audittype_id=4"; 
			if(db_query($q,"insert into audit table")) { $total += 2; }
		}
  		echo $total;
	} else if(@$_REQUEST['postType'] == "gettime") {
		echo strtotime('now');
  	} else if(@$_REQUEST['postType'] == "getcurrentevent") {
//echo "<pre>";
//print_r($events);
//echo "</pre>";
  	
		foreach($events AS $d => $data) {
			$dates = explode('-',$d);
			$now = strtotime('Now');
			if($dates[0] <= $now && $dates[1] > $now) {
?>  	
<table cellpadding="0" cellspacing="0" class="event">
	<tr>
		<td class="event_name"><?=$data['event']?></td>
	</tr>
	<tr>
		<td class="event_description"><?=$data['description']?></td>
	</tr>
	<tr>
		<td class="event_times"><?=date('g:i a',$dates[0])?> to <?=date('g:i a',$dates[1])?> <input type="hidden" id="end_time" value="<?=$dates[1]?>" /></td>
	</tr>
	<tr>
		<td>Presented By: <span class="event_speaker"><?=$data['presenter']?></span></td>
	</tr>
</table>
<?
				break;
			}
		}
  	} else if(@$_REQUEST['postType'] == "getupcomingevents") {

		foreach($events AS $d => $data) {
			$dates = explode('-',$d);
			$now = strtotime('Now');
			if($dates[0] >= $_REQUEST['endtime']) {
?><li>
	<span class="NewsTitle">
		<?=date('g:i a',$dates[0])?> to <?=date('g:i a',$dates[1])?>
	</span>
	<?=$data['event']?>
<li>
<?
			}
		}
  	}
?>