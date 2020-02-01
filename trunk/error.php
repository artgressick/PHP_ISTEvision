<?php
	session_start(); //Do not use this code if you include the security above.
	
	#Load some variables in here.
	$tab = "live";
	$page_title = "Error";
	
	#Page includes
	include('includes/page-meta.php');
	include('includes/page-top.php');
	
?>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="contents">
			<div style="font-size:14px; font-weight:bold; color:#666; background: #ffffff; height: 150px; padding-top: 150px; text-align: center;">
				Sorry, there was an error. Check the username and password and try again.
			</div>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>