<?php
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	session_start();
	include('includes/security.php');
	
	//Get Lounges
	$q = "select id, lid, name
	FROM lounge_locations
	ORDER BY name";
	$temp_lounges = @mysql_query ($q); //Run the query.

	//Get Dates
	$q = "select date
	FROM lounge_dates
	ORDER BY date";
	$dates = @mysql_query ($q); //Run the query.
	if(!isset($_REQUEST['date'])) {
		$date = mysql_fetch_assoc($dates);
		$_REQUEST['date'] = $date['date'];
		mysql_data_seek($dates,0);
	}

function encode($val,$extra="") {
	$val = str_replace("'",'&#39;',stripslashes($val));
	$val = str_replace('"',"&quot;",$val);

	if($extra == "tags") { 
		$val = str_replace("<",'&lt;',stripslashes($val));
		$val = str_replace('>',"&gt;",$val);
	}
	if($extra == "amp") { 
		$val = str_replace("&",'&amp;',stripslashes($val));
	}
	return $val;
}


	$q = "select date, begin_time, end_time
	FROM lounge_dates
	WHERE date = '".$_REQUEST['date']."'
	ORDER BY date";
	$info = mysql_fetch_assoc(@mysql_query ($q)); //Run the query.
	
	$lounges = array();
	while($row = mysql_fetch_assoc($temp_lounges)) {
		$lounges[$row['id']] = $row['name'];
	}
	
	//Get Sessions
	$q = "select lounge_sessions.kind_id, lounge_sessions.date, lounge_sessions.begin_time, lounge_sessions.end_time, lounge_sessions.location_id, lounge_sessions.presenter_id, lounge_sessions.sid, lounge_sessions.title, lounge_sessions.description, CONCAT(first_name,' ',last_name) as presenter, lounge_sessions.id AS event_id
			FROM lounge_sessions
			JOIN lounge_presenters ON lounge_sessions.presenter_id=lounge_presenters.id
			WHERE lounge_sessions.date='".$_REQUEST['date']."'";
	$tmp_sessions = @mysql_query ($q); //Run the query.
	$sessions = array();
	while($row = mysql_fetch_assoc($tmp_sessions)) {
		$time = strtotime($row['date'].' '.$row['begin_time']);
		$end = strtotime($row['date'].' '.$row['end_time']);
		$titledisplay = false;
		while($time < $end) {
			if(!$titledisplay) {
				$title = $row['title'];
				$titledisplay = true;
			} else {
				$title = '&nbsp;';
			}
			$sessions[$row['location_id'].'-'.$time] = array('kind'=>$row['kind_id'],'pid'=>$row['presenter_id'],'sid'=>$row['sid'],'title'=>$title,'hovertitle'=>$row['title'],'presenter'=>encode($row['presenter'],'amp'),'description'=>encode($row['description'],'amp'),'event_id'=>$row['event_id']);
			$time += 900;
		}
	}

	function sith() {
?>


		<script type='text/javascript'>

 			function getAbsX(obj)
            {
                  var leftOffset = 0;
                  if (obj.offsetParent)
                  {
                        while (obj.offsetParent)
                        {
                              leftOffset += obj.offsetLeft;
                              obj = obj.offsetParent;
                        }
                  }
                  else if (obj.x) //for NN4
                  {
                        leftOffset = obj.x;
                  }
                  return leftOffset;
            }
            
            function getAbsY(obj)
            {
                  var topOffset = 0;
                  if (obj.offsetParent)
                  {
                        while (obj.offsetParent)
                        {
                              topOffset += obj.offsetTop;
                              obj = obj.offsetParent;
                        }
                  }
                  else if (obj.y) // for NN4
                  {
                        topOffset = obj.y;
                  }
                  return topOffset;
            }

			function infopopup (id) {
//				alert(id);

				var title = document.getElementById('t_'+id).value;
				var description = document.getElementById('d_'+id).value;
				var presenter = document.getElementById('p_'+id).value;
				document.getElementById('eventtitle').innerHTML = title;
				document.getElementById('eventdescription').innerHTML = description;
				document.getElementById('eventpresenter').innerHTML = presenter;
				document.getElementById('infobox').style.display='';
				var posx = getAbsX(document.getElementById('event_'+id));
				var posy = getAbsY(document.getElementById('event_'+id));
//				alert(posx);
//				alert(posy);
				var infoheight = parseInt(document.getElementById('infobox').offsetHeight);
				document.getElementById("infobox").style.top = (posy - infoheight)+"px";
				document.getElementById("infobox").style.left = (posx - 75)+"px";
//				document.getElementById('infobox').style.top = posx;
//				document.getElementById('infobox').style.left = posy;
				
			}
			function hideinfopopup() {
				document.getElementById('infobox').style.display='none';
			}
		</script>
<?
	
	}
	include('includes/header.php');
	include('includes/top.php');
?>
	<tr>
		<td class="contents">
			<form id="form1" name="form1" method="post" action="">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding:5px; color:#0179b6; font-weight:bolder; font-size:11px;">
						<div>Sign up to host an impromptu presentation or discussion in one of ISTE's NECC EnvisionIT! Lounges.</div>
						<table cellpadding="0" cellspacing="0" style="width:100%;">
							<tr>
								<td style="color:#0179b6; font-weight:bolder; font-size:11px;">
									<div>&bull; Select tab for correct day.</div>
									<div>&bull; Click any open area on the schedule to add a new event.</div>
								</td>
								<td style="color:#0179b6; font-weight:bolder; font-size:11px;">
									<div>&bull; Click on your own event to edit or remove.</div>
									<div>&bull; Schedules will be displayed electronically within each lounge at the conference.</div>
								</td>
							</tr>
						</table>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">
<? // Start Body of Page ?>
						<table cellpadding="0" cellspacing="0" style="width:100%;">
							<tr>
								<td style="width:5px;">&nbsp;</td>
<?
	while($row = mysql_fetch_assoc($dates)) {
?>
								<td style="white-space:nowrap; width:75px; border:1px solid #666; border-bottom:none; padding:5px; text-align:center;<?=($_REQUEST['date']==$row['date']?'':'cursor:pointer; background:lightgrey;')?>" onclick="location.href='index.php?date=<?=$row['date']?>'"><?=date('l',strtotime($row['date']))?><br /><?=date('F jS',strtotime($row['date']))?></td><td style="width:5px;">&nbsp;</td>
<?					
	}
?>
								<td>
									<table cellpadding="0" cellspacing="2" align="right">
										<tr>
											<th colspan="3">Legend</th>
										</tr>
										<tr>
											<td>Your Events</td>
											<td style="padding:0 5px;">Other Events</td>
											<td>Not Available</td>
										</tr>
										<tr>
											<td style="background:#1d429b;">&nbsp;</td>
											<td style="background:#b7d65f;">&nbsp;</td>
											<td style="background:#1f1f1f;">&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<table cellpadding="0" cellspacing="0" style="width:100%; border:1px solid #666;">
							<tr>
								<td style="padding:5px;">
<?
		$col_width = floor(100 / count($lounges))
?>
									<table cellpadding="0" cellspacing="0" style="width:100%;">
										<tr>
											<th style="width:50px; border-right:1px solid #666;">&nbsp;</th>
<?
			foreach($lounges as $id => $name) {
?>
											<th style="padding:5px; text-align:left; border:1px solid #666; border-left:none; width:<?=$col_width?>%"><?=$name?></th>
<?
			}
?>								
										</tr>
<?
		$time = strtotime($_REQUEST['date'].' '.$info['begin_time']);
		$end_time = strtotime($_REQUEST['date'].' '.$info['end_time']);
		$fifteen = 900;
		$row_ct = 1;
						
		while($time < $end_time) {
			if($row_ct > 4) {
				$row_ct = 1;
			}
?>
										<tr>
											<td style="width:50px; border-right:1px solid #666; text-align:right; vertical-align:top;"><?=($row_ct==1?date('ga',$time):'&nbsp;')?></td>
<?
			foreach($lounges as $id => $name) {
							
				if(isset($sessions[$id.'-'.$time])) {
					if($sessions[$id.'-'.$time]['kind'] == 1) {
						$bg_color = '1f1f1f';
						$color = 'white';
						if($_SESSION['access']==4 || in_array($id,$_SESSION['lounges'])) {
							$link = ' onclick="location.href=\'editevent.php?sid='.$sessions[$id.'-'.$time]['sid'].'\'"';
							$cursor = 'pointer';
						} else {
							$link = "";
							$cursor = 'auto';
						}
						
					} else if(($sessions[$id.'-'.$time]['kind'] == 0 && $sessions[$id.'-'.$time]['pid']==@$_SESSION['id']) || ($_SESSION['access']==4) || (($_SESSION['access'] == 2 || $_SESSION['access'] == 3) && in_array($id,$_SESSION['lounges']))) {
						$bg_color = '1d429b';
						$color = 'white';
						$link = ' onclick="location.href=\'editevent.php?sid='.$sessions[$id.'-'.$time]['sid'].'\'"';
						$cursor = 'pointer';
					} else if($sessions[$id.'-'.$time]['kind'] == 0 && $sessions[$id.'-'.$time]['pid']!=@$_SESSION['id']) {
						$bg_color = 'b7d65f';
						$color = 'black';
						$link = "";
						$cursor = 'auto';
					}
				} else {
					$bg_color = ($row_ct%2?'FFF':'EEE');
					$link = ' onclick="location.href=\'register.php?d='.$_REQUEST['date'].'&l='.$id.'&ts='.date('H:i',$time).'&te='.date('H:i',$time+900).'\'"';
					$cursor = 'pointer';
				}
?>
											<td style="font-weight:bold; padding:5px; text-align:left; border-right:1px solid #666; border-bottom:1px solid <?=($bg_color == 'FFF' || $bg_color == 'EEE' ? ($row_ct==4?'#666':'#bbb') : $bg_color)?>; width:<?=$col_width?>%; color:<?=$color?>; background:#<?=$bg_color?>;cursor:<?=$cursor?>;"<?=$link?><?=(isset($sessions[$id.'-'.$time]['title']) && $sessions[$id.'-'.$time]['title'] != '&nbsp;' && $sessions[$id.'-'.$time]['kind'] != 1?' id="event_'.$sessions[$id.'-'.$time]['event_id'].'"':'')?><?=(isset($sessions[$id.'-'.$time]['title']) && $sessions[$id.'-'.$time]['kind'] != 1?" onmouseover='infopopup(".$sessions[$id."-".$time]['event_id'].")' onmouseout='hideinfopopup();'":"")?>><div style="overflow:hidden; width:135px; height:14px;"><?=(isset($sessions[$id.'-'.$time]['title']) && $sessions[$id.'-'.$time]['kind'] != 1?$sessions[$id.'-'.$time]['title']:'&nbsp;')?></div>
												<input type='hidden' id='t_<?=$sessions[$id."-".$time]['event_id']?>' value="<?=$sessions[$id."-".$time]['hovertitle']?>" />
												<input type='hidden' id='d_<?=$sessions[$id."-".$time]['event_id']?>' value="<?=$sessions[$id."-".$time]['description']?>" />
												<input type='hidden' id='p_<?=$sessions[$id."-".$time]['event_id']?>' value="<?=$sessions[$id."-".$time]['presenter']?>" />
											
											
											</td>
<?
			}
?>								
										</tr>
<?						
			$row_ct++;
			$time += $fifteen;
		}
?>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="padding:5px; text-align:center;">
						<table cellpadding="0" cellspacing="5" align="center">
							<tr>
								<th colspan="3">Legend</th>
							</tr>
							<tr>
								<td>Your Events</td>
								<td>Other Events</td>
								<td>Not Available</td>
							</tr>
							<tr>
								<td style="background:#1d429b;">&nbsp;</td>
								<td style="background:#b7d65f;">&nbsp;</td>
								<td style="background:#1f1f1f;">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
<?
	include('includes/bottom.php');
?>
		<div id="infobox" class="popup" style="display: none;">
			<div id="infodata">
				<table cellpadding="0" cellspacing="0" style="width:300px;">
					<tr>
						<td class="title"><div>Title:</div></td>
						<td class="data" id="eventtitle"></td>
					</tr>
					<tr>
						<td class="title"><div>Description:</div></td>
						<td class="data" id="eventdescription"></td>
					</tr>
					<tr>
						<td class="title"><div>Presenter:</div></td>
						<td class="data" id="eventpresenter"></td>
					</tr>
				</table>
			</div>
		</div>