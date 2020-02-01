<?php
	$BF = "";
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//Original Channels
	$sql_query = "select id, name
	FROM channels
	WHERE uploadable = 1
	ORDER BY display_order";
	
	$channel_result = @mysql_query ($sql_query); //Run the query.	

	# Stuff In The Header
	function sith() { 
	global $BF;
?>
	<script type='text/javascript' src='<?=$BF?>includes/forms.js'></script>
	<script type='text/javascript'>
		var page = 'add';
		var totalErrors = 0;
		function error_check() {
			if(totalErrors != 0) { reset_errors(); }  
			
			totalErrors = 0;
		
			if(errEmpty('title', "You must enter a Video Title.")) { totalErrors++; }
			if(errEmpty('description', "You must enter a Video Description.")) { totalErrors++; }
			
			if(errEmpty('elevel[]', "You must select at least One (1) Education Level.","array")) { totalErrors++; }
			
			if(errEmpty('content[]', "You must select at least One (1) Content Themes.","array")) { totalErrors++; }

			if(errEmpty('relates[]', "You must select at least One (1) Story relates to.","array")) { totalErrors++; }


			if(errEmpty('org_file', "You must select a Video File.")) { totalErrors++; }
			else if(errEmpty('org_file', "Invalid File Extension, Only AVI, WMV, MOV, or M4V files are allowed.","extension")) { totalErrors++; }
			if(document.getElementById('terms').checked == false) {
				errCustom('terms','You must agree to the Terms.');
				totalErrors++;
			}
			if(totalErrors == 0) {
				submit_upload();
				return true;
			} else {
				return false;
			}
			
//			return (totalErrors == 0 ? true : false);
		}
		
		function submit_upload() {
			document.getElementById('form1').style.display = 'none';
			document.getElementById('uploading').style.display = '';
		}
	</script>
<?php
	}
	
	//Page title.
	$page_title = "Add Video";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<div style="padding: 10px; background: #ffffff;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
<!-- contents -->
					<form action="uploadfile2.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return error_check()">
					<div id='errors'></div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="70%" style="padding-right: 20px;" valign="top">
									<div style="font-size:14px; font-weight:bold; ">
										Upload a new video.
									</div>
									
									<div style="font-size:12px;  padding-top: 5px; padding-bottom: 20px;">
										To upload a file please fill out the information below. All fields in <span class="form_required">BLUE</span> are required to submit your video.
									</div>
									
<?php
	$channel_counter = mysql_num_rows($channel_result);
	$divider = round($channel_counter/2); //We need to see how many will fit in a row.
	$counter = 0;
?>
            						<div class="form_div">
										<span class="form_required">Channels</span> <span style="font-size:10px; color:#000;">(You can choose more then one.)</span>
										<table width="100%" cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td width="50%" valign="top">
<?php
	while ($channels = mysql_fetch_array ($channel_result, MYSQL_ASSOC)) {
		$counter = $counter + 1;
		if ($counter > $divider) {
?>
												</td>
												<td width="50%" valign="top">
<?php
			$counter = 0;
		}
?>
												<div>
													<input type="checkbox" id="<?= $channels['id'] ?>" name="<?= $channels['id'] ?>" value="<?= $channels['id'] ?>" /><?= $channels['name'] ?>
												</div>
<?php
	}
?>
												</td>
											</tr>
										</table>
									</div>
									
									<div class="form_div">
										<span class="form_required">Story Title</span><br />
										<input name="title" type="text" id="title" size="75" maxlength="200" />
									</div>
									
									<div class="form_div">
										<span class="form_required">Story Description</span><br />
										<textarea name="description" id="description" cols="75" rows="10" wrap="virtual"></textarea>
									</div>
								</td>
								<td width="30%" valign="top" rowspan="7">
									<div style="text-align: center;  background:#e5e5e5; padding: 3px; border: solid 4px #0367A6;">
										<h3>ISTE User Agreement</h>
									</div>
									<div style=" text-align: left; background:#e5e5e5;  padding: 5px; border: solid 4px #0367A6;">
										<p>By uploading this video ("work") you:</p>
										
										<p>1. Represent and warrant that the work will be of wholly original material that you hold the copyright to (except for material in the public domain or used with the permission of the owner), will not infringe any copyright, and will not constitute a defamation; or invasion of the right of privacy or publicity; or infringement of any other kind, of any third party.</p>
										
										<p>2. You grant ISTE a non-exclusive worldwide perpetual license to use, modify, and make derivative works of this work.  You also grant ISTE the right to use your name, biography, and likeness in advertising and promotion and in any and all ancillary products regardless of the formats in which such use occurs, when used in conjunction with any portion of, or derivative work made from, the work you upload.</p>
										
										<p>3. You also agree to indemnify and hold ISTE harmless from any and all claims, judgments, costs, suits, debts or liabilities, including attorney's fees, arising from ISTE's or your use of this work.</p>
									</div>
								</td>
							</tr>
							<tr>
								<td style="padding-right: 20px; padding-top:10px;" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td colspan="4">
												<div class="form_div">
													<span class="form_required">Education Level</span> (Check at least one.)
												</div>
											</td>
										</tr>
										<tr>
											<td><input name="elevel[]" type="checkbox" id="elevel-0" value="1" /></td>
											<td width="50%">PK-8</td>
											<td><input type="checkbox" name="elevel[]" id="elevel-3" value="4" /></td>
											<td width="50%">University</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="elevel[]" id="elevel-1" value="2" /></td>
											<td width="50%">9-12</td>
											<td><input type="checkbox" name="elevel[]" id="elevel-4" value="5" /></td>
											<td width="50%">Continuing Education</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="elevel[]" id="elevel-2" value="3" /></td>
											<td width="50%">Community College</td>
											<td><input type="checkbox" name="elevel[]" id="elevel-5" value="6" /></td>
											<td width="50%">Other</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding-right: 20px; padding-top: 15px;" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td colspan="4">
												<div class="form_div">
													<span class="form_required">Content Themes</span> (Check at least one.)
												</div>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="content[]" id="content-0" value="1" /></td>
											<td width="50%">School Improvement</td>
											<td><input type="checkbox" name="content[]" id="content-3" value="4" /></td>
											<td width="50%">Professional Learning</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="content[]" id="content-1" value="2" /></td>
											<td width="50%">Ethics &amp; Equity</td>
											<td><input type="checkbox" name="content[]" id="content-4" value="5" /></td>
											<td width="50%">21st Century Teaching & Learning</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="content[]" id="content-2" value="3" /></td>
											<td width="50%">Technology Infrastructure</td>
											<td><input type="checkbox" name="content[]" id="content-5" value="6" /></td>
											<td width="50%">Virtual Schooling/E-learning</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding-right: 20px; padding-top: 15px;" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td colspan="4">
												<div class="form_div">
													<span class="form_required">Curricular Areas</span> (Check at least one.)
												</div>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="cirricular[]" id="cirricular-0" value="1" /></td>
											<td width="50%">Language Arts</td>
											<td><input type="checkbox" name="cirricular[]" id="cirricular-5" value="6" /></td>
											<td width="50%">Music/Drama</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="cirricular[]" id="cirricular-1" value="2" /></td>
											<td width="50%">Art</td>
											<td><input type="checkbox" name="cirricular[]" id="cirricular-6" value="7" /></td>
											<td width="50%">ICT</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="cirricular[]" id="cirricular-2" value="3" /></td>
											<td width="50%">Math</td>
											<td><input type="checkbox" name="cirricular[]" id="cirricular-7" value="8" /></td>
											<td width="50%">Physical Education</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="cirricular[]" id="cirricular-3" value="4" /></td>
											<td width="50%">Science</td>
											<td><input type="checkbox" name="cirricular[]" id="cirricular-8" value="9" /></td>
											<td width="50%">Interdisciplinary</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="cirricular[]" id="cirricular-4" value="5" /></td>
											<td width="50%">Social Studies</td>
											<td><input type="checkbox" name="cirricular[]" id="cirricular-9" value="10" /></td>
											<td width="50%">Other</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding-right: 20px; padding-top: 15px;" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td colspan="4">
												<div class="form_div">
													<span class="form_required">Story relates to decade</span> (Check at least one.)
												</div>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="decade[]" id="decade-0" value="1" /></td>
											<td width="50%">1959-1968</td>
											<td><input type="checkbox" name="decade[]" id="decade-3" value="4" /></td>
											<td width="50%">1989-1998</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="decade[]" id="decade-1" value="2" /></td>
											<td width="50%">1969-1978</td>
											<td><input type="checkbox" name="decade[]" id="decade-4" value="5" /></td>
											<td width="50%">1999-2009</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="decade[]" id="decade-2" value="3" /></td>
											<td width="50%">1979-1988</td>
											<td><input type="checkbox" name="decade[]" id="decade-5" value="6" /></td>
											<td width="50%">Future</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding-right: 20px; padding-top: 15px;" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td colspan="4">
												<div class="form_div">
													<span class="form_required">Story relates to:</span> (check at least one.)
												</div>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="relates[]" id="relates-0" value="1" /></td>
											<td width="50%">Educational transformation</td>
											<td><input type="checkbox" name="relates[]" id="relates-3" value="4" /></td>
											<td width="50%">General Ed Tech</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="relates[]" id="relates-1" value="2" /></td>
											<td width="50%">ISTE</td>
											<td><input type="checkbox" name="relates[]" id="relates-4" value="5" /></td>
											<td width="50%">Other</td>
										</tr>
										<tr>
											<td><input type="checkbox" name="relates[]" id="relates-2" value="3" /></td>
											<td width="50%">NECC</td>
											<td></td>
											<td width="50%"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding-right: 20px; padding-top: 15px;" valign="top">
									<div class="form_div">
										<span class="form_optional">Extra search tags</span> (seperate tags with commas please)<br />
										<textarea name="meta_tags" id="meta_tags" cols="75" rows="5" wrap="virtual"></textarea>
									</div>
								</td>
							</tr>
							<tr>
								<td style="padding-right: 20px; padding-top: 15px;" valign="top">
									
									<div class="form_div">
										<span class="form_required">Your Video File</span>: 
										<input type="hidden" name="MAX_FILE_SIZE" value="750000000">
										<input name="org_file" type="file" id="org_file" size="25"Ê/><br />


										<span style=" font-size:10px; color:#F00; font-style:italic;">NOTE: Files may be AVI, WMV, MOV, M4V and a Maximum of 750 MB. </span> <a href="help2.php"><big style="color: rgb(255, 0, 0);"><span style="font-weight: bold;">Need some help?</span></big></a>
									</div>
									
									<div style="height:25px;"></div>
									
									<div class="form_div">
										<input name="terms" type="checkbox" id="terms" value="Yes" /> <span class="form_required">Please check the box to confirm that you have read and understand the ISTE User Agreement.</span>
									</div>
									
									<div style="height:25px;"></div>
									
									<div class="form_div">
										<input name="upload" type="submit" id="button" value="Submit" /> <span style=" font-size:10px; color:#00F; font-style:italic;">NOTE: Do not click the button more then once or click back.</span>
									</div>
								</td>
							</tr>
						</table>
					</form>
					<div class="form_div" id="uploading" style="display:none;">
						<div style="text-align:center;"><img src="images/uploading.gif"></div>
						<div style="text-align:center; padding-top:10px;"><img src="images/loading.gif"></div>
						<div style="text-align:center; padding-top:10px; font-weight:bold; font-size: 22px; color: red;">NOTE: Uploading files takes time... please be patient.</div>
						<div style="text-align:center; padding-top:10px; font-weight:bold; font-size: 22px; color: red; padding-top: 10px;">If you click "back" or otherwise stop this page,</div>
						<div style="text-align:center; padding-top:10px; font-weight:bold; font-size: 22px; color: red;">your story file will not upload.</div>
					</div>
<!-- contents -->
				</tr>
			</table>
			</div>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>