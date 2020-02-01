<?php
	include('includes/security.php');
	
	//Get the location information
	require_once ('istetube-conf.php'); //Map the Connection.
	
	if(isset($_POST['account_level'])) {
		
		if($_POST['account_level'] == 2) {
			$lounges = $_POST['lounge_id'];
		} else if($_POST['account_level'] == 3) {
			$lounges = implode(',',$_POST['lounge_ids']);
		} else {
			$lounges = '';
		}
		
		$q = "UPDATE lounge_presenters SET 
				access_level = '".$_POST['account_level']."',
				lounges = '".$lounges."'
				WHERE id='".$_POST['id']."'
		";
		if(@mysql_query ($q)) {
			header ('Location: presenters.php');
			exit();			
		} else {
			header ('Location: error.php');
			exit();
		}
	}
	
	
	//Query 1
	$sql_query = "select id, first_name, last_name, email_address, access_level, lounges
	FROM lounge_presenters
	WHERE pid = '".$_REQUEST['pid']."'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	
	$presenter = mysql_fetch_array ($result, MYSQL_ASSOC);
	function sith() {
?>
	<script type='text/javascript'>
		function update_access() {
			var access = document.getElementById('account_level');
			if(access.value == 2) {
				document.getElementById('lounge_admin').style.display='';
				document.getElementById('multi_lounge_admin').style.display='none';
			} else if(access.value == 3) {
				document.getElementById('multi_lounge_admin').style.display='';
				document.getElementById('lounge_admin').style.display='none';
			} else {
				document.getElementById('multi_lounge_admin').style.display='none';
				document.getElementById('lounge_admin').style.display='none';
			}
		}
	</script>
<?	
	}
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td class="listing_topic" style="border-bottom: 1px solid #c0c0c0;">
				View NECC Lounge Presenter
			</td>
			<td class="listing_add" style="border-bottom: 1px solid #c0c0c0;">
			
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
				<form id="form1" name="form1" method="post" action="">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
					<tr>
						<td width="50%">
							<span class="view_field">Presenter</span><span class="view_output">: <?= $presenter['first_name'] ?> <?= $presenter['last_name'] ?></span>
						</td>
						<td width="50%">
							<span class="view_field">Email Address</span><span class="view_output">: <?= $presenter['email_address'] ?></span>
						</td>
					</tr>
					<tr>
						<td width="50%" style="padding-top:10px; vertical-align:top;">
							<span class="view_field">Account Level</span>
							<select name='account_level' id='account_level' onchange="update_access();">
								<option value='1'<?=($presenter['access_level']==1?' selected="selected"':'')?>>User</option>
								<option value='2'<?=($presenter['access_level']==2?' selected="selected"':'')?>>Lounge Admin</option>
								<option value='3'<?=($presenter['access_level']==3?' selected="selected"':'')?>>Multiple Lounge Admin</option>
								<option value='4'<?=($presenter['access_level']==4?' selected="selected"':'')?>>Global Admin</option>
							</select>
						</td>
						<td width="50%" style="padding-top:10px;">
<?
	//Get Lounges
	$q = "select id, lid, name
	FROM lounge_locations
	ORDER BY name";
	$temp_lounges = @mysql_query ($q); //Run the query.
?>
							<div id="lounge_admin" style="<?=($presenter['access_level']==2?'':'display:none;')?>">
								Select a Lounge this user can Administrate
								<table cellpadding="3" cellspacing="0">
<?
								while($row = mysql_fetch_assoc($temp_lounges)) {
?>
									<tr>
										<td><input type="radio" name="lounge_id" value="<?=$row['id']?>" <?=(is_numeric($presenter['lounges']) && $presenter['lounges']==$row['id'] && $presenter['access_level']==2?' checked="checked"':'')?> /></td>
										<td><?=$row['name']?></td>
									</tr>
<?								
								}
?>								
								</table>
							</div>
							<div id="multi_lounge_admin" style="<?=($presenter['access_level']==3?'':'display:none;')?>">
								Select the Lounge(s) this user can Administrate
								<table cellpadding="3" cellspacing="0">
<?
	mysql_data_seek($temp_lounges,0);
			$tmp_lounges = explode(',', $presenter['lounges']);
								while($row = mysql_fetch_assoc($temp_lounges)) {
?>
									<tr>
										<td><input type="checkbox" name="lounge_ids[]" value="<?=$row['id']?>"<?=(in_array($row['id'], $tmp_lounges)  && $presenter['access_level']==3?' checked="checked"':'')?> /></td>
										<td><?=$row['name']?></td>
									</tr>
<?								
								}
								
?>								
								</table>

							</div>
						<td>
					</tr>
				</table>
				<div style="padding-top:20px;">
					<input type="hidden" name="id" value="<?=$presenter['id']?>" />
					<input type="submit" name="save" value="Save Information" />
				</div>
				</form>
			</td>
		</tr>
<?
	#include('../includes/footer.php');
?>