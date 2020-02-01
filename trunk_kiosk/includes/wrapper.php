<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="refresh" content="1200;url=logout.php">
<title>ISTEvision Kiosk</title>

<!-- Styles -->
<link href="includes/global.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="includes/overlay-istevision.css" />
<link rel="stylesheet" type="text/css" href="includes/scrollable-navig.css" />
<link rel="stylesheet" type="text/css" href="includes/scrollable-istevision.css" />

<!-- Flowplayer items -->
<script src="http://www.google-analytics.com/ga.js"></script>
<script src="includes/flowplayer-3.0.6.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script src="includes/jquery.overlay-1.0.1.min.js"></script>
<script src="includes/jquery.expose-1.0.0.min.js"></script>
<script src="includes/jquery.scrollable-1.0.2.min.js"></script>
<script src="includes/flowplayer.embed-3.0.2.min.js"></script>
<?
	#this will allow for stuff to go into the head portion of the site.
	if(function_exists('sith')) { sith(); } 
?>
<?= $flowincludes ?>
</head>
<noscript><meta http-equiv="refresh" content="0;URL=errornojs.php" /></noscript>
<body style="background: url(images/background.jpg); width:100%; height:100%;">
<table width="100%" height="1013" cellpadding="0" cellspacing="0" style="" />
	<tr>
		<td style="height:1013px; vertical-align:top;" align="center">
<!-- Body Content -->
<?
sitm(); // Echo Body
?>
<!-- End Body Content -->
		</td>
	</tr>
</table>
<table width="100%" height="36" cellpadding="0" cellspacing="0" style="" />
	<tr>
		<td style="height:36px;" align='center'>
			<table cellpadding="0" cellspacing="0" style="width:100%; color:white;">
				<tr>
					<td style="height:36px; text-align:left; padding-left:20px;">ISTE&reg; is a registered trademark of the International Society for Technology in Education</td>
					<td style="height:36px; text-align:right; padding-right:20px;">www.iste.org</td>
				</tr>
			</table>
		</td>
	</tr>
</body>
</html>
