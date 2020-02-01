<?php
	include('includes/security.php');
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
		<tr>
			<td class="listing_topic" style="border-bottom: 1px solid #c0c0c0;">
				Add NECC Lounge Date
			</td>
			<td class="listing_add" style="border-bottom: 1px solid #c0c0c0;">
			
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
				<form id="form1" name="form1" method="post" action="insertdate.php">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
					<tr>
						<td>Lounge Session Date<br />
						<input name="date" type="text" id="name" size="25" maxlength="50" /> (Please use format: 12/30/2009)</td>
					</tr>
					<tr>
						<td>Lounge Session Begin Time<br />
						<input name="begin_time" type="text" id="name" size="25" maxlength="50" value="7:00am" /> (Please use format: 7:00am)</td>
					</tr>
					<tr>
						<td>Lounge Session End Time<br />
						<input name="end_time" type="text" id="name" size="25" maxlength="50" value="7:00pm" /> (Please use format: 7:00pm)</td>
					</tr>

					<tr>
						<td style="padding-top: 15px;"><input type="submit" name="button" id="button" value="Add Date" /></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
<?
	#include('../includes/footer.php');
?>