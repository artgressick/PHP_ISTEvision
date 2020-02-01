<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" class="settings" width="920" height="102" background="images/header.jpg">
			<div style="padding: 0 15px 5px 0; font-weight: bold;">
<?
		if(isset($_SESSION['id'])) {
?>
					Welcome <?=$_SESSION['first_name'].' '.$_SESSION['last_name']?> (<a href="/logout.php">Logout</a>)
<?			
		} else {
?>
					Welcome Guest (<a href="/login.php">Log-in</a>)
<?			
		}
?>					
			</div>
		</td>
	</tr>