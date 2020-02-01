<body>
	<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td width="50%" align="left"><a href="index.php">NECC Lounge Administration</a></td>
			<td width="50%" class="settings">
<?
	if (isset($_SESSION['admin_id'])) {
?>
			<a href="logout.php">Log Out</a>
<?
	} else {
?>
			<a href="login.php">Log In</a>
<?
	}
?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="navigation">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: solid 1px; color:#999;">
					<tr>
						<td align="center" class="nav_bar"><a href="index.php">Sessions</a></td>
						<td align="center" class="nav_bar"><a href="locations.php">Locations</a></td>
						<td align="center" class="nav_bar"><a href="presenters.php">Presenters</a></td>
						<td align="center" class="nav_bar"><a href="dates.php">Lounge Dates</a></td>
					</tr>
				</table>
			</td>
		</tr>