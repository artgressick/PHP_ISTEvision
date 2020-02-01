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
			<div style="font-size:14px; font-weight:bold; color:#666; background: #ffffff; height: 200px; padding-top: 80px; text-align: center;">
				<p>Sorry, your browser lacks java script support.</p>
				
				<p>Do you have it disabled? Please download a more recent browser.</p>
				
				<p><a href="http://www.firefox.com">http://www.firefox.com</a></p>
			</div>
		</td>
	</tr>
</table>
<?php
	include('includes/page-bottom.php');
?>