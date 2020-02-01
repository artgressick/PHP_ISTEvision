<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?=(isset($title) && $title != '' ? $title.' - ' : '')?>NECC Lounge Sessions</title>
<?	if($br->Name == 'MSIE') { ?>		
		<link href="<?=$BF?>includes/globalie.css" rel="stylesheet" type="text/css" />
		<link href="<?=$BF?>includes/menuie.css" rel="stylesheet" type="text/css" media="all" />
<?	} else {?>
		<link href="<?=$BF?>includes/global.css" rel="stylesheet" type="text/css" />
		<link href="<?=$BF?>includes/menu.css" rel="stylesheet" type="text/css" media="all" />
<?	}?>
		<link href="<?=$BF?>components/cool_calendar/cool_calendar.css" rel="stylesheet" type="text/css" media="all" />
		<script type='text/javascript'>
			var BF = '<?=$BF?>';
		</script>
<?		# If the "Stuff in the Header" function exists, then call it
		if(function_exists('sith')) { sith(); } 
?>
	</head>
	<noscript>You must install Javascript to use this site. Get it <a href="http://www.java.com/getjava/">here</a>!</noscript> 
	<body <?=(isset($bodyParams) ? 'onload="'. $bodyParams .'"' : '')?> class="mainbody">
<?// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // This is to display the SESSION variables, unrem to use?>
<!-- Begin code -->
	<div class="lounge_main">
<?
# This is where we will put in the code for the page.
(!isset($sitm) || $sitm == '' ? sitm() : $sitm());
?>
	</div>
<!-- End code -->
<?
	# Any aditional things can go down here including javascript or hidden variables
	# "Stuff on the Bottom"
	if(function_exists('sotb')) { sotb(); } 
?>
	</body>
</html>