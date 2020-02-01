<?php
	session_start(); //Do not use this code if you include the security above.
	
	#Load some variables in here.
	$tab = "live";
	$page_title = "Confirmation";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<div style="font-size:14px; font-weight:bold; color:#666; background: #ffffff; height: 175px; padding-top: 100px; text-align: center;">
				<div style="font-size:14px; font-weight:bold; color:#666;">
					Check back soon, we are building this section for later use.
				</div>
			</div>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>