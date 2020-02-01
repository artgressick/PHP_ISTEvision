<?php
	include('_controller.php');

	function sitm() {
		global $BF;
?>
		<div id='inner_current' class='innerbody' style="height:465px;">
			<div class='celltitle'>NETs Unplugged Live!</div>
			<table cellpadding="0" cellspacing="5" style="width:100%; display:none;" class="current_event" id="current_event">
				<tr>
					<td style="vertical-align:top; text-align:right; white-space:nowrap; width:50px; font-weight:bold;">Title:</td>
					<td style="vertical-align:top; text-align:left; padding-left:10px;" id="cevent_title"></td>
				</tr>
				<tr>
					<td style="vertical-align:top; text-align:right; white-space:nowrap; width:50px; font-weight:bold;">Presenter:</td>
					<td style="vertical-align:top; text-align:left; padding-left:10px;" id="cevent_presenter"></td>
				</tr>
				<tr>
					<td style="vertical-align:top; text-align:right; white-space:nowrap; width:50px; font-weight:bold;">Start / End Time:</td>
					<td style="vertical-align:top; text-align:left; padding-left:10px;" id="cevent_times"></td>
				</tr>
				<tr>
					<td style="vertical-align:top; text-align:right; white-space:nowrap; width:50px; font-weight:bold;">Description:</td>
					<td style="vertical-align:top; text-align:left; padding-left:10px;" id="cevent_description"></td>
				</tr>
			</table>
			<div id="no_event" style="display:none; text-align:center;"><img src='<?=$BF?>images/noevent.png' /></div>
		</div>
		<div id='inner_next' class='innerbody' style="margin-top:20px;height:465px;">
			<div class='celltitle'>Today's Schedule</div>
			<div id="next_events" style="display:none;"></div>
			<div id="no_next_event" style="display:none; text-align:center;"><img src='<?=$BF?>images/noupcomingevents.png' /></div>
		</div>
<?
	}
?>