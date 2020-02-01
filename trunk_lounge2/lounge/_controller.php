<?
	# This is the BASE FOLDER pointing back to the root directory
	$BF = '../';
	
	preg_match('/(\w)+\.php$/',$_SERVER['SCRIPT_NAME'],$file_name);
    $post_file = '_'.$file_name[0];
    $breadcrumbs = array();
    
	switch($file_name[0]) {
		#################################################
		##	Index Page
		#################################################
		case 'index.php':
			# Adding in the lib file
			include($BF .'_lib.php');
//			auth_check('litm');
//			include_once($BF.'components/formfields.php');

			# Stuff In The Header
			function sith() { 
				global $BF;
?>
				<script type='text/javascript' src='<?=$BF?>includes/overlays.js'></script>
				<script type='text/javascript'>
					function update_display() {
						getcurrentevent('<?=$BF?>');
					}
				</script>
				
<?				
			}

			# The template to use (should be the last thing before the break)
			$bodyParams = "update_display(); setInterval('update_display()', 2000 );";
			include($BF ."models/lounge.php");		
			
			break;
		#################################################
		##	Else show Error Page
		#################################################
		default:
			include($BF .'mobile/_lib.php');
			errorPage('Page Incomplete.  Please notify an Administrator that you have received this error.');
	}

?>