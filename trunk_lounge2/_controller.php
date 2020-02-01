<?
	# This is the BASE FOLDER pointing back to the root directory
	$BF = '';
	
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
			$breadcrumbs[] = array('TEXT' => "Home");
			if((!isset($_COOKIE['location_id']) || !is_numeric($_COOKIE['location_id'])) && (!isset($_SESSION['location_id']) || !is_numeric($_SESSION['location_id']))) {
				header("Location: location.php");
				die();
			}
			include_once($BF.'components/formfields.php');

			# Stuff In The Header
			function sith() { 
				global $BF;
?>
				<script type='text/javascript' src='<?=$BF?>includes/overlays.js'></script>
				<script type='text/javascript'>
					function getevents() {
						var jsonEvents = {};
						getjsonevents('<?=$BF?>',<?=(!isset($_COOKIE['location_id'])?$_SESSION['location_id']:$_COOKIE['location_id'])?>);
					}
				</script>
<?
			}

			$bodyParams = "getevents();setInterval('getevents()', 1000 );";
			# The template to use (should be the last thing before the break)
			include($BF ."models/lounge.php");		
			
			break;
		#################################################
		##	Select Location Page
		#################################################
		case 'location.php':
			# Adding in the lib file
			include($BF .'_lib.php');
			$breadcrumbs[] = array('TEXT' => "Select Location");
//			auth_check('litm');
			include_once($BF.'components/formfields.php');
			if(isset($_POST['location_id']) && is_numeric($_POST['location_id'])) {
				setcookie("location_id", $_POST['location_id'], time()+60*60*24*180, '/');  /* expire in 180 days */
				$_COOKIE['location_id'] = $_POST['location_id'];
				$_SESSION['location_id'] = $_POST['location_id'];
				header("Location: index.php");
				die();
			}

			# Stuff In The Header
			function sith() { 
				global $BF;
			}

			# The template to use (should be the last thing before the break)
			include($BF ."models/lounge.php");		
			
			break;

		#################################################
		##	Error Page
		#################################################
		case 'error.php':
			$title = "Error Page";	# Page Title
			# Adding in the lib file
			include($BF .'_lib.php');
			include_once($BF.'components/formfields.php');

			# Stuff In The Header
			function sith() { 
				global $BF;
			}

			# The template to use (should be the last thing before the break)
			include($BF ."models/nonav.php");		
			
			break;
		#################################################
		##	Else show Error Page
		#################################################
		default:
			include($BF .'_lib.php');
			errorPage('Page Incomplete.  Please notify an Administrator that you have received this error.');
	}

?>