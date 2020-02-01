<?php
	include('_controller.php');

	function sitm() {
		global $BF;
?>
	<div class='innerbody'>
		<form action="" method="post" id="idForm" onsubmit="return error_check()">
			<table class="twoCol" id="twoCol" cellpadding="0" cellspacing="0" style='width:100%;'>
				<tr>
					<td class="tcleft">
<? 
						$locations = db_query("SELECT id, name FROM lounge_locations","Getting Locations");
?>
					
					<?=form_select($locations,array('nocaption'=>'true','caption'=>'- Select This Location -','required'=>'true','name'=>'location_id','style'=>'','extra'=>'onchange="form.submit();"'))?>
				
	
					</td>
				</tr>
			</table>
			<div class='FormButtons'>
				<?=form_button(array('type'=>'submit','value'=>'Save'))?>
			</div>
		</form>
	</div>
<?
	}
?>