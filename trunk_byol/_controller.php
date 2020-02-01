<?
	# This is the BASE FOLDER pointing back to the root directory
	$BF = '';
	
	preg_match('/(\w)+\.php$/',$_SERVER['SCRIPT_NAME'],$file_name);
    $post_file = '_'.$file_name[0];
//    $breadcrumbs = array();
    
	switch($file_name[0]) {
		#################################################
		##	Index Page
		#################################################
		case 'index.php':
			# Adding in the lib file
			include($BF .'_lib.php');
//			$breadcrumbs[] = array('TEXT' => "Home");
//			auth_check('litm');
			include_once($BF.'components/formfields.php');
			if(!isset($_SESSION['intcount_updated']) || $_SESSION['intcount_updated'] != true) {
				db_query("UPDATE byol_stats SET hits=hits+1;","Update Hitcount");
				$_SESSION['intcount_updated'] = true;
			}
			# Stuff In The Header
			function sith() { 
				global $BF;
//				include($BF .'components/list/sortlistjs.php');
?>
				<script type="text/javascript">
					function show_date(date) {
						var dates = document.getElementById('dates').value;
						var alldates=dates.split(",");
//						document.getElementById('default').style.display = 'none';
						for ( var i in alldates ) {
						    document.getElementById('date_'+alldates[i]).style.display = 'none';
						    document.getElementById('date_'+alldates[i]).style.cursor = 'pointer';
						} 
						
						document.getElementById('date_'+date).style.display = '';
					}
				
					function exp_cont(id) {
						var icon = document.getElementById('icon_'+id);
						var software = document.getElementById('software_'+id);
						if(software.style.display == 'none') {
							icon.src = '<?=$BF?>images/contract.gif';
							software.style.display = '';
						} else {
							icon.src = '<?=$BF?>images/expand.gif';
							software.style.display = 'none';
						}
					}
				</script>
<?
			}

			# The template to use (should be the last thing before the break)
			include($BF ."models/template.php");		
			
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