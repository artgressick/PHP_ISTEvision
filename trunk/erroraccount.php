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
			<div style="font-size:14px; font-weight:bold; color:#666; background: #ffffff; height: 150px; padding-top: 80px; text-align: center;">
				<p>Sorry, there was a problem with the creation of the account.</p>
				
				<p>Please go back and try again.</p>
			</div>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>