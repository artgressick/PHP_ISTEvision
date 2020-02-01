<body>
	<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td width="50%" align="left"><a href="index.php"><img src="../images/logo.jpg" width="505" height="150" border="0" /></a></td>
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
				<form id="search" name="search" method="post" action="searchvideos.php">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: solid 1px; color:#999;">
					<tr>
						<td align="center" class="nav_bar"><a href="index.php">Dashboard</a></td>
						<td align="center" class="nav_bar"><a href="videos.php">Manage Videos</a></td>
<?php
	if ($_SESSION['super'] == 1) {
?>
						<td align="center" class="nav_bar"><a href="members.php">Manage Members</a></td>
						<td align="center" class="nav_bar"><a href="users.php">Manage Admins</a></td>
						<td align="center" class="nav_bar"><a href="channels.php">Channels</a></td>
<?php
	}
?>
					</tr>
				</table>
				</form>
			</td>
		</tr>