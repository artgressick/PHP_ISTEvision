<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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