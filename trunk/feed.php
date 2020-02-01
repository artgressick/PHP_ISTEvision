<?
	if(phpversion() > '5.0.1') { date_default_timezone_set('America/New_York'); }
/*================================================================================================
//	Image Rotator for Cisco devices version 2.0
//	Written by Jason Summers
//	Copyright 2009 techIT Solutions LLC
//	
//	NOTE: Images may be 1 to 2 seconds off of actual server time depending on page start and load time.
//
//	Instructions: Set variables below based off of your configuration.
*/
	$image_path = 'cisco-images/';
	$default_image = 'welcome.png';
	$default_image_delay = 10; // Display each image for this amount (in seconds)
	$json_data_file = './feed.json';
//	
//Do not modify anything below this line
//=============================================================================================
?>
<html>
	<head>
		<script type="text/javascript">
			//Functions Used
			function padlength(value) {
				var output=(value.toString().length==1) ? "0"+value : value;	
			}
/*
			function setOpacity(obj, opacity) {
				opacity = (opacity == 100)?99.999:opacity;
				// IE/Win
				obj.style.filter = "alpha(opacity:"+opacity+")";
				// Safari<1.2, Konqueror
				obj.style.KHTMLOpacity = opacity/100;
				// Older Mozilla and Firefox
				obj.style.MozOpacity = opacity/100;
				// Safari 1.2, newer Firefox and Mozilla, CSS3
				obj.style.opacity = opacity/100;
			}

			function fadeIn(objId,opacity) {
				if (document.getElementById) {
					obj = document.getElementById(objId);
					obj.style.display = '';
					if (opacity <= 100) {
						setOpacity(obj, opacity);
						opacity += 5;
						window.setTimeout("fadeIn('"+objId+"',"+opacity+")", 10);
					}
				}
			}
*/
			window.onload=function(){
				setInterval("image_rotator()", 1000); //Run javascript every second
			}

			//Suppress Javascript Errors
			function stopError() {
				return true;
			}
			window.onerror = stopError;

			//Set Default Variables				
			var default_image = '<?=$image_path.$default_image?>';
			var server_time = new Date('<?=date("m/d/Y H:i:s")?>');
			//Prime variables
			var cycle_time = 0;
			var current_image_id = 0;
			var image_path = '<?=$image_path?>';
			var images = new Array();
			var image = '';
			var fadein=0;
			var current_image = default_image;
			var prev_image = default_image;
			var total_images = 0;
			var image_delay = <?=$default_image_delay?>;
			var start_time = '';
			var end_time = '';
			var reloadloaddata = 0;
			var initial_load = 0;
			var current_time = new Date(server_time);
			//Load JSON data
			var req = new XMLHttpRequest();
			req.open("GET", "<?=$json_data_file?>", false); 
			req.send(null);
			var myjsondata = eval('(' + req.responseText + ')');
			
			//Main function
			function image_rotator() {
				if(initial_load == 0) {
					document.getElementById('rotating_image2').src = default_image;
					document.getElementById('rotating_image1').src = default_image;
					initial_load = 1;
				}

				if(current_image == default_image && current_image != prev_image) {
					document.getElementById('rotating_image2').src = prev_image;
					document.getElementById('rotating_image1').src = current_image;
					fadeIn('rotating_image1',0);
					prev_image = current_image;
				}
				
				if(current_image != default_image && current_image != prev_image) {
					document.getElementById('rotating_image1').style.display = 'none';
					document.getElementById('rotating_image2').src = document.getElementById('rotating_image1').src
					document.getElementById('rotating_image1').src = current_image;
					fadeIn('rotating_image1',0);
					prev_image = current_image;
				}
				
				current_image = default_image; //Reset the current image cause JSON likes to generates errors with Javascript
				image_delay = <?=$default_image_delay?>;
				if(reloadloaddata == 1) {
					//Load JSON data
					req = new XMLHttpRequest();
					req.open("GET", "<?=$json_data_file?>", false); 
					req.send(null);
					myjsondata = eval('(' + req.responseText + ')');
					reloadloaddata = 0;
				}
				server_time.setSeconds(server_time.getSeconds()+1); //Increase Server time by 1 second
				current_time = new Date(server_time);
				var i=0;
				for (i=0; i<=myjsondata.data.length; i++) { //Start loop through JSON data
					start_time = new Date(myjsondata.data[i].date +" "+ myjsondata.data[i].ts);
					end_time = new Date(myjsondata.data[i].date+" "+myjsondata.data[i].te);
					if(current_time >= start_time && current_time < end_time) {
						images = myjsondata.data[i]['img'].split(',');
						image = images[current_image_id].split(':');
						total_images = images.length;
						current_image = image_path+image[0];
						image_delay = (image[1] && image[1] != 0 ? image[1] : image_delay);
						cycle_time++;
						if(cycle_time >= image_delay) {
							cycle_time = 0;
							reloadloaddata = 1;
							current_image_id++;
							if(current_image_id >= total_images) {
								current_image_id = 0;
							}
						}
					}
				}
			}
		</script>
	</head>
	<body style="padding:0;margin:0;">
		<img src="" id="rotating_image2" alt="rotating_image" style='position:absolute; top:0px; left:0px;' />
		<img src="" id="rotating_image1" alt="rotating_image" style='position:absolute; top:0px; left:0px;' />
		<script type="text/javascript">image_rotator();</script>
	</body>
</html>