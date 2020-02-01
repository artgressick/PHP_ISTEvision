<?php
	include('_controller.php');

	function sitm() {
		global $BF;

		$software_tmp = db_query("SELECT * FROM byol_software WHERE !deleted ORDER BY software_name","Get Software");
		
		$software = array();
		while($row = mysqli_fetch_assoc($software_tmp)) {
			$software[$row['id']] = array('name'=>$row['software_name'],'url'=>$row['software_url']);
		}

?>
			<table cellpadding="0" cellspacing="0" style="width:100%;">
				<tr>
					<td style="width:162; padding-left:10px; vertical-align:top;">
						<table cellpadding="0" cellspacing="0" style="width:152px;" align="right">
							<tr>
								<td class="nav_top"><!-- BLANK --></td>
							</tr>
							<tr>
								<td class="nav_middle">
							<div class="nav_select">Select Date of Session</div>
<?
						$dates = db_query("SELECT start_date FROM byol_sessions WHERE !deleted GROUP BY start_date ORDER BY start_date","Get All Dates");
						$dates_tmp = '';
						while($row = mysqli_fetch_assoc($dates)) {
?>
							<div class="nav_link" onclick='show_date("<?=$row['start_date']?>");'><?=date('l, F jS',strtotime($row['start_date']))?></div>
<?				
							$dates_tmp .= $row['start_date'].',';
						}
?>				
							<input type='hidden' id='dates' value='<?=substr($dates_tmp,0,-1)?>' />
							
								</td>
							</tr>
							<tr>
								<td class="nav_bottom"><!-- BLANK --></td>
							</tr>
						</table>
					</td>
					<td style="padding-left:10px; padding-right:10px; width:739px; vertical-align:top;">
						<table cellpadding="0" cellspacing="0" class="main">
							<tr>
								<td class="tl"><img src="<?=$BF?>images/blank.gif" alt="Blank" /></td>
								<td class="tm"><img src="<?=$BF?>images/blank.gif" alt="Blank" /></td>
								<td class="tr"><img src="<?=$BF?>images/blank.gif" alt="Blank" /></td>
							</tr>
							<tr>
								<td class="ml"><img src="<?=$BF?>images/blank.gif" alt="Blank" /></td>
								<td class="mm">
									<div id="default" class="instructions">Welcome to the NECC 2009 BYOL Support Site. This site lists only those BYOL sessions and workshops that have prerequisites. Select the appropriate day to see if your particular session has any prerequisites, and follow the links to download any necessary software you may be missing.</div>


<?
				mysqli_data_seek($dates, 0);
				while($row = mysqli_fetch_assoc($dates)) {
?>
					<div id='date_<?=$row['start_date']?>' style='display:none;'>
						<table cellpadding="0" cellspacing="0" class="header">
							<td class="left"><img src="<?=$BF?>images/blank.gif" alt="Blank" /></td>
							<td class="middle"><?=date('l, F jS',strtotime($row['start_date']))?></td>
							<td class="right"><img src="<?=$BF?>images/blank.gif" alt="Blank" /></td>
						</table>
<?
					$sessions = db_query("SELECT s.id, s.session_name, s.notes, s.start_time, r.room_number, s.notes,
												(SELECT GROUP_CONCAT(soft.id ORDER BY soft.software_name SEPARATOR ',') FROM byol_software AS soft JOIN byol_session_software AS ss ON soft.id=ss.software_id WHERE ss.session_id=s.id) AS software
											FROM byol_sessions AS s 
											JOIN byol_rooms AS r ON r.id=s.room_id
											WHERE !s.deleted AND s.start_date='".$row['start_date']."'
											ORDER BY s.session_name, s.start_time
					 ","Get Sessions");
					 $cnt = 0;
					 while($row2 = mysqli_fetch_assoc($sessions)) {
						if($cnt == 0) {
							$bgcolor = '#638541';
							$cnt++;
						} else if($cnt == 1) {
							$bgcolor = '#3b6f9c';
							$cnt++;
						} else if($cnt == 2) {
							$bgcolor = '#8e7e42';
							$cnt++;
						} else if($cnt >= 3) {
							$bgcolor = '#7676ab';
							$cnt = 0;
						}
					 	
?>
						<div class='session_list' onclick='exp_cont(<?=$row2['id']?>);' style="background: <?=$bgcolor?>;">
							<table cellpadding="0" cellspacing="0" style="width:100%;">
								<tr>
									<td style='width:20px;'><img src='<?=$BF?>images/expand.gif' id='icon_<?=$row2['id']?>' /></td>
									<td class="session_title"><?=$row2['session_name']?> - Room: <?=$row2['room_number']?> - Time: <?=date('g:i a',strtotime($row2['start_time']))?></td>
								</tr>
							</table>
						</div>
						<div class='session_software' id="software_<?=$row2['id']?>" style='display:none;'>
<?
						if($row2['notes'] != '') {
?>
							<div class='notes'><strong>PRESENTER NOTES</strong>: <?=$row2['notes']?></div>
<?
						}
?>
							<div class="reqsofttitle">REQUIRED SOFTWARE/HARDWARE:</div>
							<div>
								<ul>
<?
								$soft_tmp = explode(',',$row2['software']);
								foreach($soft_tmp AS $id) {
?>
									<li style="line-height:20px;"><?=($software[$id]['url']!=''?'<a href="'.$software[$id]['url'].'" target="_blank">'.$software[$id]['name'].'</a>':$software[$id]['name'])?></li>
<?								 
								}
?>									
								</ul>
							</div>
						
						</div>
<?
					 }
?>					
					</div>
<?				
				}
?>				



									<div class="global_requirements">BYOL rooms feature wireless connectivity only. While not all BYOL sessions require Internet access, wireless compatible laptops are needed for those that do.</div>
								</td>
								<td class="mr"><img src="<?=$BF?>images/blank.gif" alt="Blank" /></td>
							</tr>
							<tr>
								<td class="bl"><img src="<?=$BF?>images/blank.gif" alt="Blank" /></td>
								<td class="bm"><img src="<?=$BF?>images/blank.gif" alt="Blank" /></td>
								<td class="br"><img src="<?=$BF?>images/blank.gif" alt="Blank" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
<?
	}
?>