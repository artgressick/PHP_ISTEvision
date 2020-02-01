<?php
	require_once ('istetube-conf.php'); //Map the Connection.
	session_start();
	include('includes/security.php');

	if(isset($_REQUEST['sid'])) {
		$q = "SELECT * FROM lounge_sessions WHERE sid='".$_REQUEST['sid']."'";
		$info = mysql_fetch_assoc(@mysql_query ($q));
		if($info['id'] != '' && ($info['presenter_id']==$_SESSION['id'] || $_SESSION['access']==4 || in_array($info['location_id'],$_SESSION['lounges']))) {
			$tb = explode(':', $info['begin_time']);
			$info['start_hour'] = $tb[0]; 
			$info['start_min'] = $tb[1]; 
					
			$te = explode(':', $info['end_time']);
			$info['end_hour'] = $te[0]; 
			$info['end_min'] = $te[1]; 
		} else {
			header ('Location: error.php');
			die();		
		}
		
	} else {
		header ('Location: error.php');
		die();		
	}
	if(isset($_POST['title'])) {
		include_once ('_lib.php');
		if(isset($_POST['deletebox']) && $_POST['deletebox']=='cancel' && $_POST['deletepassword'] != '') {
			$test = mysql_fetch_assoc(@mysql_query ("SELECT password FROM lounge_presenters WHERE id='".$_SESSION['id']."'"));
			if($test['password'] == md5($_POST['deletepassword'])) {
				if(@mysql_query ("DELETE FROM lounge_sessions WHERE id='".$info['id']."'".($_SESSION['access']==4 || in_array($_POST['location_id'],$_SESSION['lounges'])?'':" AND presenter_id='".$_SESSION['id']."'"))) {
					header ('Location: index.php?date='.$_POST['date']);
					die();
				} else {
					header ('Location: error.php');
					die();		
				}
			} else {
				header ('Location: error.php');
				die();		
			}
		}
		
		$q = "SELECT id 
		FROM lounge_sessions
		WHERE id != '".$info['id']."' AND location_id='".$_POST['location_id']."' AND date = '".$_POST['date']."' AND 
		(('".(strlen($_POST['start_hour']) < 2?'0':'').$_POST['start_hour'].':'.(strlen($_POST['start_min']) < 2?'0':'').$_POST['start_min'].":00' BETWEEN begin_time AND end_time AND '".(strlen($_POST['start_hour']) < 2?'0':'').$_POST['start_hour'].':'.(strlen($_POST['start_min']) < 2?'0':'').$_POST['start_min'].":00' != end_time) 
		OR ('".(strlen($_POST['end_hour']) < 2?'0':'').$_POST['end_hour'].':'.(strlen($_POST['end_min']) < 2?'0':'').$_POST['end_min'].":00' BETWEEN begin_time AND end_time AND '".(strlen($_POST['end_hour']) < 2?'0':'').$_POST['end_hour'].':'.(strlen($_POST['end_min']) < 2?'0':'').$_POST['end_min'].":00' != begin_time)
		OR (begin_time BETWEEN '".(strlen($_POST['start_hour']) < 2?'0':'').$_POST['start_hour'].':'.(strlen($_POST['start_min']) < 2?'0':'').$_POST['start_min'].":00' AND '".$_POST['te'].":00' AND begin_time != '".(strlen($_POST['end_hour']) < 2?'0':'').$_POST['end_hour'].':'.(strlen($_POST['end_min']) < 2?'0':'').$_POST['end_min'].":00') 
		OR (end_time BETWEEN '".(strlen($_POST['start_hour']) < 2?'0':'').$_POST['start_hour'].':'.(strlen($_POST['start_min']) < 2?'0':'').$_POST['start_min'].":00' AND '".(strlen($_POST['end_hour']) < 2?'0':'').$_POST['end_hour'].':'.(strlen($_POST['end_min']) < 2?'0':'').$_POST['end_min'].":00' AND end_time != '".(strlen($_POST['start_hour']) < 2?'0':'').$_POST['start_hour'].':'.(strlen($_POST['start_min']) < 2?'0':'').$_POST['start_min'].":00')
		OR (begin_time = '".(strlen($_POST['start_hour']) < 2?'0':'').$_POST['start_hour'].':'.(strlen($_POST['start_min']) < 2?'0':'').$_POST['start_min'].":00') 
		OR (end_time = '".(strlen($_POST['end_hour']) < 2?'0':'').$_POST['end_hour'].':'.(strlen($_POST['end_min']) < 2?'0':'').$_POST['end_min'].":00'))
		";
		
//		echo $q."<br /><br />";
		
		$results = @mysql_query ($q);
	
		if(mysql_num_rows($results)==0) {
		
			
			$q = "Update lounge_sessions SET 
				location_id = '".encode($_POST['location_id'])."',
				title = '".encode($_POST['title'])."',
				description = '".encode($_POST['description'])."',
				date = '".$_POST['date']."',
				begin_time = '".(strlen($_POST['start_hour']) < 2?'0':'').$_POST['start_hour'].':'.(strlen($_POST['start_min']) < 2?'0':'').$_POST['start_min'].":00',
				end_time = '".(strlen($_POST['end_hour']) < 2?'0':'').$_POST['end_hour'].':'.(strlen($_POST['end_min']) < 2?'0':'').$_POST['end_min'].":00'";
				
				if($_SESSION['access']==4 || in_array($info['location_id'],$_SESSION['lounges'])) {
					$q .= ", presenter_id = '".$_POST['presenter_id']."',
							kind_id = '".(isset($_POST['blackout']) && $_POST['blackout'] == 'blackout'?'1':'')."'";
				
				}
				
				$q .= " WHERE id='".$info['id']."'
			";
			if(@mysql_query ($q)) {
				header ('Location: index.php?date='.$_POST['date']);
				die();
			} else {
				header ('Location: error.php');
				die();		
			}
		} else { $info = $_POST;
				$error = "Your Chosen Times conflict with other events.";
		}
	}
	

	
	
	//Get Locations
	$sql_query = "select id, lid, name
	FROM lounge_locations
	ORDER BY name";
	$locations = @mysql_query ($sql_query); //Run the query.

	//Get Dates
	$sql_query = "select date
	FROM lounge_dates
	ORDER BY date";
	$dates = @mysql_query ($sql_query); //Run the query.

	function sith() {
		global $info;
	
		$sql_query = "select date, begin_time, end_time
		FROM lounge_dates
		ORDER BY date";
		$dates = @mysql_query ($sql_query); //Run the query.
?>
		<script type="text/javascript" src="includes/forms.js"></script>
		
		<script type='text/javascript'>
			var dates = new Array();
<?
		while($row = mysql_fetch_assoc($dates)) {
?>
			dates['<?=$row['date']?>'] = new Array();
			dates['<?=$row['date']?>']['start'] = '<?=date('H:i',strtotime($row['begin_time']))?>';
			dates['<?=$row['date']?>']['end'] = '<?=date('H:i',strtotime($row['end_time']))?>';
			dates['<?=$row['date']?>']['starthr'] = <?=date('H',strtotime($row['begin_time']))?>;
			dates['<?=$row['date']?>']['endhr'] = <?=date('H',strtotime($row['end_time']))?>;
			dates['<?=$row['date']?>']['error'] = '<?=date('g:i a',strtotime($row['end_time']))?>';
<?			
		}
?>			
			
			var totalErrors = 0;
			var totalErrors2 = 0;
			var totalErrors3 = 0;
			function error_check() {
				reset_errors();
				
				totalErrors = 0;
				totalErrors2 = 0;
				totalErrors3 = 0;
			
				if(errEmpty('location_id', "You must select a Location.")) { totalErrors++; }
				if(errEmpty('title', "You must enter a title.")) { totalErrors++; }
				if(errEmpty('description', "You must enter a Description.")) { totalErrors++; }
				if(errEmpty('date', "You must select a Date.")) { totalErrors++; }
				if(errEmpty('start_hour', "You must select a Start Hour.")) { totalErrors++; totalErrors2++; totalErrors3++; }
				if(errEmpty('start_min', "You must select a Start Minute.")) { totalErrors++; totalErrors2++; totalErrors3++; }
				if(errEmpty('end_hour', "You must select a End Hour.")) { totalErrors++; totalErrors2++; totalErrors3++; }
				if(errEmpty('end_min',"You must select a End Minute.")) { totalErrors++; totalErrors2++; totalErrors3++; }

		        var start = document.getElementById('start_hour').value + ':' + document.getElementById('start_min').value;
		        var end = document.getElementById('end_hour').value + ':' + document.getElementById('end_min').value;
		        var starttime = new Date(0, 0, 0, start.substring(0, 2), start.substring(3, 6));
	      		var endtime = new Date(0, 0, 0, end.substring(0, 2), end.substring(3, 6));
				var date = document.getElementById('date').value;
        		var endtmp = dates[date]['end'];
				var endday = new Date(0, 0, 0, endtmp.substring(0, 2), endtmp.substring(3, 6));
				//args.IsValid = (endtime >= starttime);


				var start_hour = document.getElementById('start_hour').value;
				var start_min = document.getElementById('start_min').value;
				var end_hour = document.getElementById('end_hour').value;
				var end_min = document.getElementById('end_min').value;
				
				if(totalErrors2 == 0) {
					if(endtime <= starttime) {
						errCustom('end_time','End Time must be later then Start Time.');
						totalErrors++;
						totalErrors3++;
					}
				}
				
				
				if(starttime >= endday) {
					errCustom('start_hour','Start Time can not be at '+dates[date]['error']+' or Later.');
				}
				if(endtime > endday) {
					errCustom('end_hour','End Time can not be past '+dates[date]['error']+'.');
				}
				
				
				if(totalErrors3 == 0) {
					var date = document.getElementById('date').value;
					var tb = document.getElementById('start_hour').value + ':' + document.getElementById('start_min').value;
					var te = document.getElementById('end_hour').value + ':' + document.getElementById('end_min').value;
					var location_id = document.getElementById('location_id').value

					//if(checktimes(date,tb,te,'0',location_id,'Your Chosen Times conflict with other events.')) { totalErrors++; }
				}
				return (totalErrors == 0 ? true : false);
				return false;
			}
		
		function set_times() {
			var date = document.getElementById('date').value;
			var myselect = document.getElementById('start_hour');
			var myselect2 = document.getElementById('end_hour');
			var tmp_hr = '';
			var tmp_hr2 = '';
			myselect.length = 0;
			myselect2.length = 0;
			for(i=dates[date]['starthr']; i<=dates[date]['endhr']; i++) {
				if(i<12) { 
					if(i < 10) {
						tmp_hr2 = '0' + i;
					} else {
						tmp_hr2 = i;	
					}
					tmp_hr = i + ' am';
				} else if(i == 12) {
					tmp_hr2 = i;
					tmp_hr = i + ' pm';
				} else if(i > 12) {
					tmp_hr2 = i;
					tmp_hr = (i - 12) + ' pm';
				}
				addOption(myselect,tmp_hr, tmp_hr2); 
				addOption(myselect2,tmp_hr, tmp_hr2); 
			}
		}
		function admin_check() {
			var access = <?=$_SESSION['access']?>;
			var location = document.getElementById('location_id').value;
						
			if(in_array(location, [<?=implode(',',$_SESSION['lounges'])?>]) || access == 4) {
				document.getElementById('admin').style.display = '';
			} else {
				document.getElementById('admin').style.display = 'none';
			}
		} 
		function in_array(needle, haystack, argStrict) {
		    var found = false, key, strict = !!argStrict;
		    for (key in haystack) {
		        if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
		            found = true;
		            break;
		        }
		    }
		    return found;
		}
		
		function select_hours() {
			for(i=0;i<document.getElementById('start_hour').length;i++) {
				if(document.getElementById('start_hour').options[i].value=='<?=date('H',strtotime($info['begin_time']))?>') {
					document.getElementById('start_hour').selectedIndex=i
				}
			}
			for(i=0;i<document.getElementById('end_hour').length;i++) {
				if(document.getElementById('end_hour').options[i].value=='<?=date('H',strtotime($info['end_time']))?>') {
					document.getElementById('end_hour').selectedIndex=i
				}
			}
		}
		function showpw() {
			if(document.getElementById('deletebox').checked == true) {
				document.getElementById('pw').style.display='';
			} else {
				document.getElementById('pw').style.display='none';
				document.getElementById('deletepassword').value = '';
			}
		}
		function addOption(selectbox,text,value ) {
			var optn = document.createElement("OPTION");
			optn.text = text;
			optn.value = value;
			selectbox.options.add(optn);
		}
		
		</script>
<?
	}
	$bodyParams = 'set_times();select_hours();admin_check();';
	//include the header information
	include('includes/header.php');
	include('includes/top.php');
?>
	<tr>
		<td class="contents">
			<form id="form1" name="form1" method="post" action="" onsubmit="return error_check()">
			<div class="section_header" style="margin-bottom:10px;">Edit Event</div>
			<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2"><div id="errors"></div></td>
<?
					if(isset($error)) {
?>
<script>document.getElementById('errors').innerHTML += "<div class='ErrorMessage'><?=$error?></div>";</script>
<?					
					}
?>					
		</tr>		
		<tr>
			<td style="width:50%; vertical-align:top;">
				<div style="font-weight:bolder;">Select Location</div>
				<select name="location_id" id="location_id" onchange="admin_check()">
<?
				while($row = mysql_fetch_assoc($locations)) {
?>
					<option value="<?=$row['id']?>"<?=($info['location_id']==$row['id']?' selected="selected"':'')?>><?=$row['name']?></option>
<?			
				}
?>			
				</select>
				
				<div style="font-weight:bolder;margin-top:5px;">Title</div>
				<input type="text" name="title" id="title" size="40" maxlength="150" value="<?=$info['title']?>" />
				
				<div style="font-weight:bolder;margin-top:5px;">Description</div>
				<textarea name="description" id="description" rows="5" cols="40"><?=$info['description']?></textarea>
				

			</td>
			<td style="width:50%; vertical-align:top;">
				<div style="font-weight:bolder;">Select Date</div>
				<select name="date" id="date">
<?
				while($row = mysql_fetch_assoc($dates)) {
?>
					<option value="<?=$row['date']?>"<?=($info['date']==$row['date']?' selected="selected"':'')?>><?=date('n/j/Y',strtotime($row['date']))?></option>
<?			
				}
?>			
				</select>

				<div style="font-weight:bolder;margin-top:5px;">Start Time</div>
				<select name="start_hour" id="start_hour">
<?
				$time = 6;
				while($time <= 21) {
?>
					<option value="<?=($time < 10?'0':'').$time?>"<?=($info['start_hour']==($time < 10?'0':'').$time?' selected="selected"':'')?>><?=date('g a',strtotime(($time < 10?'0':'').$time.'00'))?></option>
<?			
					$time++;
				}
?>			
				</select>
				<select name="start_min" id="start_min">
<?
				$min = 0;
				while($min <= 45) {
?>
					<option value="<?=($min < 10?'0':'').$min?>"<?=($info['start_min']==($min < 10?'0':'').$min?' selected="selected"':'')?>><?=($min < 10?'0':'').$min?></option>
<?			
					$min=$min+15;
				}
?>			
				</select>

				<div style="font-weight:bolder;margin-top:5px;">End Time</div>
				<select name="end_hour" id="end_hour">
<?
				$time = 6;
				while($time <= 21) {
?>
					<option value="<?=($time < 10?'0':'').$time?>"<?=($info['end_hour']==($time < 10?'0':'').$time?' selected="selected"':'')?>><?=date('g a',strtotime(($time < 10?'0':'').$time.'00'))?></option>
<?			
					$time++;
				}
?>			
				</select>
				<select name="end_min" id="end_min">
<?
				$min = 0;
				while($min <= 45) {
?>
					<option value="<?=($min < 10?'0':'').$min?>"<?=($info['end_min']==($min < 10?'0':'').$min?' selected="selected"':'')?>><?=($min < 10?'0':'').$min?></option>
<?			
					$min=$min+15;
				}
?>			
				</select>

				<div style="margin-top:10px;"><input type="checkbox" name="deletebox" id="deletebox" value="cancel" onclick="showpw();" /> Cancel Event</div><div id="pw" style="display:none;font-weight:bolder;margin-top:5px;">Enter Your Password to cancel this event: <br />(NOTE! This can not be undone)<br /><input type="password" name="deletepassword" id="deletepassword" value="" size="20" maxlength="50" /></div>

<?
			if($_SESSION['access']==4 || $_SESSION['access']==2 || $_SESSION['access']==3) {
?>
				<div id="admin" style="display:none;">
<?			
				$q = "SELECT id, CONCAT(last_name, ', ',first_name) as chrName FROM lounge_presenters ORDER BY chrName";
				$presenters = @mysql_query ($q); //Run the query.
?>
				<div style="margin:10px 0; padding:5px; width:200px; background:#BBB;">Admin Options</div>
				<div style="font-weight:bolder;">Select Presenter</div>
				<select name="presenter_id" id="presenter_id">
<?
				while($row = mysql_fetch_assoc($presenters)) {
?>
					<option value="<?=$row['id']?>"<?=($info['presenter_id']==$row['id']?' selected="selected"':'')?>><?=$row['chrName']?></option>
<?			
				}
?>			
				</select>
				<div style="margin-top:10px;"><input type="checkbox" name="blackout" id="blackout" value="blackout" <?=($info['kind_id']==1?' checked="checked"':'')?> /> Black-out Time</div>
				</div>

<?
			}
?>				
		
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" name="Save" id="Save" value="Update Event" />
			</td>
		</tr>
	</table>
</form>
		</td>
	</tr>
<?
	include('includes/bottom.php');
?>