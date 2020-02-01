<?php
	include('_controller.php');

	function sitm() {
		global $BF;
?>
		<table align="center" class="lounge_main" cellpadding="0" cellspacing="0">
			<tr>
				<td style="height:60%; vertical-align:top;">
					<table cellpadding="0" cellspacing="0" style="width:100%;">
						<tr>
							<td></td>
							<td style="text-align:right; padding-right:5px;"><?=date('F jS Y')?></td>
						</tr>
					</table>
					<table cellpadding="0" cellspacing="0" style="width:100%;">
						<tr>
							<td style="vertical-align:top; width:321px;"><img src="<?=$BF?>images/events_icon.jpg" /></td>
							<td style="vertical-align:top;" id="current_event">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="border-top:1px solid #999; border-bottom:1px solid #999; background:#EEE; font-weight:bold; padding:2px; text-align:center; height:5%;">Upcoming Events</td>
			</tr>
			<tr>
				<td style="height:35%; vertical-align:top;>
				</td>
			</tr>
		</table>
<?
	}
?>