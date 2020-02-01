<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?=(isset($title) && $title != '' ? $title.' - ' : '')?>NECC BYOL Software Requirements</title>
		<link href="<?=$BF?>includes/global.css" rel="stylesheet" type="text/css" />
		<script type='text/javascript'>
			var BF = '<?=$BF?>';
		</script>
		<!--[if lt IE 7.]>
			<script defer type="text/javascript" src="<?=$BF?>includes/pngfix.js"></script>
		<![endif]-->

<?		# If the "Stuff in the Header" function exists, then call it
		if(function_exists('sith')) { sith(); } 
?>
	</head>
	<noscript>You must install Javascript to use this site. Get it <a href="http://www.java.com/getjava/">here</a>!</noscript> 
	<body <?=(isset($bodyParams) ? 'onload="'. $bodyParams .'"' : '')?> class="mainbody">
<?// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // This is to display the SESSION variables, unrem to use?>
	<table cellpadding="0" cellspacing="0" align="center" class="byol_main">
		<tr>
			<td class="byol_header"><!-- BLANK --></td>
		</tr>
		<tr>
			<td class="byol_body">
<!-- Begin code -->
<?
# This is where we will put in the code for the page.
(!isset($sitm) || $sitm == '' ? sitm() : $sitm());
?>
<!-- End code -->
			</td>
		</tr>
	</table>
	<table width="901" border="0" align="center" cellpadding="0" cellspacing="0" background="<?=$BF?>images/footer.jpg" height="36">
		<tr>
			<td valign="top" width="70%">
				<div style="padding-top: 13px; padding-left: 5px; color: #ffffff;">
					ISTE&reg; is a registered trademark of the International Society for Technology in Education
				</div>
			</td>
			<td valign="top" width="30%">
				<div style="padding-top: 13px; padding-right: 5px; text-align: right;">
					<a href="http://www.iste.org" style="color: #ffffff;" target="_blank">www.iste.org</a>
				</div>	
			</td>
		</tr>
	</table>	
<?
	# Any aditional things can go down here including javascript or hidden variables
	# "Stuff on the Bottom"
	if(function_exists('sotb')) { sotb(); } 
?>
	</body>
</html>