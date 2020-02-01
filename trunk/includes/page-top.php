<body<?=(isset($bodyParams) ? ' onload="'. $bodyParams .'"' : '')?>>
<table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/header.jpg" width="920" height="126" /></td>
	</tr>
	<tr>
		<td><table width="920" border="0" cellspacing="0" cellpadding="0" style="padding:0; margin:0;">
			<tr>
				<td class="<?= ($tab == "channels" ? 'navigation-on' : 'navigation') ?>" style="border-left: solid 1px #CCC;"><a href="index.php">Channels</a></td>
				<td style="width:1px;"><img src="images/nav-divider.gif" width="1" height="36" /></td>
				<td class="<?= ($tab == "featured" ? 'navigation-on' : 'navigation') ?>"><a href="featured.php">Featured Videos</a></td>
				<td style="width:1px;"><img src="images/nav-divider.gif" width="1" height="36" /></td>
				<td class="<?= ($tab == "popular" ? 'navigation-on' : 'navigation') ?>"><a href="popular.php">Most Popular</a></td>
				<td style="width:1px;"><img src="images/nav-divider.gif" width="1" height="36" /></td>
				<td class="<?= ($tab == "top" ? 'navigation-on' : 'navigation') ?>"><a href="top.php">Top Rates</a></td>
				<td style="width:1px;"><img src="images/nav-divider.gif" width="1" height="36" /></td>
				<td class="navigation-search" align="right">
					<div style="padding-right: 10px;">
						<form id="form1" name="form1" method="post" action="search.php" class="search" style="margin:0; padding:0;">
							<input type="search" name="criteria" id="search" />
						</form>
					</div>
				</td>
<?php
	if (isset($_SESSION['id'])) {
?>
				<td class="navigation-account" align="right">
					<table width="65" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><img src="images/account-left.gif" width="2" height="18" /></td>
							<td width="100%" class="account"><a href="profile.php">Account</a></td>
							<td><img src="images/account-right.gif" width="2" height="18" /></td>
						</tr>
					</table>
				</td>
<?php
	}
?>				
<?php
	if (isset($_SESSION['id'])) {
?>
				<td class="navigation-account" align="right">
					<table width="65" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><img src="images/account-left.gif" width="2" height="18" /></td>
							<td width="100%" class="account"><a href="logoff.php">Log Out</a></td>
							<td><img src="images/account-right.gif" width="2" height="18" /></td>
						</tr>
					</table>
				</td>
<?php
	}
?>
				<td class="navigation-account" style="border-right: solid 1px #CCC;" align="right">
					<table width="90" border="0" cellspacing="0" cellpadding="0" style="padding-right: 10px;">
						<tr>
							<td><img src="images/account-left.gif" width="2" height="18" /></td>
<?php
	if (isset($_SESSION['id'])) {
?>
							<td class="account"><a href="myvideos.php">My Videos</a></td>
<?php
	} else {						
?>
							<td width="100%" class="account"><a href="login.php">Log In</a></td>
<?php
	}
?>
							<td><img src="images/account-right.gif" width="2" height="18" /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table></td>
	</tr>
</table>