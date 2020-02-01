<?
	$BF = "";
	$NON_HTML_PAGE = true;
	require('_lib.php');
	
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
  	} else if(@$_REQUEST['postType'] == "getevents") {

// Start Test
  		$current_tmp = db_query("SELECT ls.*, CONCAT(lp.first_name,' ', lp.last_name) AS presenter, DATE_FORMAT(ls.begin_time,'%H:%i') AS tBegin, DATE_FORMAT(ls.end_time,'%H:%i') AS tEnd
  			FROM lounge_sessions AS ls 
  			JOIN lounge_presenters as lp ON ls.presenter_id=lp.id
  			WHERE ls.location_id='".$_REQUEST['location_id']."' AND ls.date='".date('Y-m-d')."' AND ls.begin_time <= '".date('H:i:00')."' AND ls.end_time > '".date('H:i:00')."'","Get current event",1);
  			
  			//".date('Y-m-d')."
  			
  		$nextevents_tmp = db_query("SELECT ls.*, CONCAT(lp.first_name,' ', lp.last_name) AS presenter, DATE_FORMAT(ls.begin_time,'%H:%i') AS tBegin, DATE_FORMAT(ls.end_time,'%H:%i') AS tEnd
  			FROM lounge_sessions AS ls 
  			JOIN lounge_presenters as lp ON ls.presenter_id=lp.id
			WHERE ls.location_id='".$_REQUEST['location_id']."' AND ls.date='".date('Y-m-d')."' AND ls.begin_time > '".date('H:i:00')."'
  			ORDER BY ls.begin_time, ls.end_time","Get future events");

  			//".date('Y-m-d')."
// End Test
/*
// Start Production
  		$current_tmp = db_query("SELECT ls.*, CONCAT(lp.first_name,' ', lp.last_name) AS presenter, CONCAT(DATE_FORMAT(ls.begin_time,'%l:%i %p'),' to ',DATE_FORMAT(ls.end_time,'%l:%i %p')) AS times
  			FROM lounge_sessions AS ls 
  			JOIN lounge_presenters as lp ON ls.presenter_id=lp.id
  			WHERE ls.location_id='".$_REQUEST['location_id']."' AND ls.date='".date('Y-m-d')."' AND ls.begin_time <= '".date('H:i:00')."' AND ls.end_time > '".date('H:i:00')."'","Get current event",1);
  			
  		$nextevents_tmp = db_query("SELECT ls.*, CONCAT(lp.first_name,' ', lp.last_name) AS presenter, CONCAT(DATE_FORMAT(ls.begin_time,'%l:%i %p'),' to ',DATE_FORMAT(ls.end_time,'%l:%i %p')) AS times
  			FROM lounge_sessions AS ls 
  			JOIN lounge_presenters as lp ON ls.presenter_id=lp.id
  			WHERE ls.location_id='".$_REQUEST['location_id']."' AND ls.date='".date('Y-m-d')."' AND ls.begin_time > '".date('H:i:00',strtotime('-3 hours'))."'
  			ORDER BY ls.begin_time, ls.end_time","Get future events");

// End Production
*/			
  		$events = array();	
  		if($current_tmp['id'] != '') {
	  		$tBegin = explode(':',$current_tmp['tBegin']);
	  		$tEnd = explode(':',$current_tmp['tEnd']);
	  		if(($tBegin[0] < 12 && $tEnd[0] < 12) || ($tBegin[0] >= 12 && $tEnd[0] >= 12)) { // Begin and End in AM or PM
	  			$ltp = 'am';
	  			if($tBegin[0] >= 12) {
	  				$ltp = 'pm';
	  				if($tBegin[0] > 12) {
		  				$tBegin[0] = $tBegin[0] - 12;
		  			}
	  			}
	  			if($tEnd[0] > 12) {
	  				$tEnd[0] = $tEnd[0] - 12;
	  			}
	
	  			$times = (substr($tBegin[0],0,1)==0?substr($tBegin[0],1,2):$tBegin[0]).($tBegin[1]=='00'?' ':':'.$tBegin[1].' ').'to '.(substr($tEnd[0],0,1)==0?substr($tEnd[0],1,2):$tEnd[0]).($tEnd[1]=='00'?' ':':'.$tEnd[1].' ').$ltp;
	  			
	  		} else { // Begin in AM and End in PM
	  			
	  			$times = ($tBegin[0]>12?($tBegin[0]-12):(substr($tBegin[0],0,1)==0?substr($tBegin[0],1,2):$tBegin[0])).':'.($tBegin[1]=='00'?' ':$tBegin[1].' ').($tBegin[0]>=12?'pm ':'am ').'to '.($tEnd[0]>12?($tEnd[0]-12):(substr($tEnd[0],0,1)==0?substr($tEnd[0],1,2):$tEnd[0])).':'.($tEnd[1]=='00'?' ':$tEnd[1].' ').($tEnd[0]>=12?'pm ':'am ');
	  			
	  		}
	  	}
  		$events['current'] = $current_tmp;
  		if($times != '') { $events['current']['times'] = $times; }
  		$events['nextevents'] = array();
  		while($row = mysqli_fetch_assoc($nextevents_tmp)) {

	  		$tBegin = explode(':',$row['tBegin']);
	  		$tEnd = explode(':',$row['tEnd']);
	  		if(($tBegin[0] < 12 && $tEnd[0] < 12) || ($tBegin[0] >= 12 && $tEnd[0] >= 12)) { // Begin and End in AM or PM
	  			$ltp = 'am';
	  			if($tBegin[0] >= 12) {
	  				$ltp = 'pm';
	  				if($tBegin[0] > 12) {
		  				$tBegin[0] = $tBegin[0] - 12;
		  			}
	  			}
	  			if($tEnd[0] > 12) {
	  				$tEnd[0] = $tEnd[0] - 12;
	  			}
	
	  			$times = (substr($tBegin[0],0,1)==0?substr($tBegin[0],1,2):$tBegin[0]).($tBegin[1]=='00'?' ':':'.$tBegin[1].' ').'to '.(substr($tEnd[0],0,1)==0?substr($tEnd[0],1,2):$tEnd[0]).($tEnd[1]=='00'?' ':':'.$tEnd[1].' ').$ltp;
	  			
	  		} else { // Begin in AM and End in PM
	  			
	  			$times = ($tBegin[0]>12?($tBegin[0]-12):(substr($tBegin[0],0,1)==0?substr($tBegin[0],1,2):$tBegin[0])).($tBegin[1]=='00'?' ':':'.$tBegin[1].' ').($tBegin[0]>=12?'pm ':'am ').'to '.($tEnd[0]>12?($tEnd[0]-12):(substr($tEnd[0],0,1)==0?substr($tEnd[0],1,2):$tEnd[0])).($tEnd[1]=='00'?' ':':'.$tEnd[1].' ').($tEnd[0]>=12?'pm ':'am ');
	  			
	  		}

			$row['times'] = $times;
			if(strlen($row['title']) > 63) {
				$row['title'] = substr($row['title'],0,63).'...';
			}	
  			$events['nextevents'][] = $row;	
  		}
  		echo 'JSONevents='.json_encode($events);
  	}
?>