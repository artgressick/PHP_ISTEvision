<?
	//We need to figure out which elevels this video has
	$queryY = "SELECT content1, content2, content3, content4, content5, content6
	FROM video_criteria
	WHERE vid = '".$_REQUEST['vid'] ."'";
	
	$resultY = @mysql_query ($queryY); //Run the query.
	$criteria = mysql_fetch_array ($resultY, MYSQL_ASSOC);
	
	//build the first part of the query for the videos.
	$queryX = "SELECT processed_file, title, first_name, last_name, videos.vid, description, (select count(video_id) from views where videos.id = views.video_id) as watched
	FROM videos
	JOIN customers ON videos.customer_id = customers.id
	JOIN video_criteria ON videos.id = video_criteria.video_id
	WHERE ftp_status > 0 and video_status_id = 2 ";
	
	//now that we have the information about the elevel we want to compare them
	if ($criteria['content1'] == '1') {
		$queryX .= "and content1 = 1 ";
	}
	if ($criteria['content2'] == '1') {
		$queryX .= "and content2 = 1 ";
	}
	if ($criteria['content3'] == '1') {
		$queryX .= "and content3 = 1 ";
	}
	if ($criteria['content4'] == '1') {
		$queryX .= "and content4 = 1 ";
	}
	if ($criteria['content5'] == '1') {
		$queryX .= "and content5 = 1 ";
	}
	if ($criteria['content6'] == '1') {
		$queryX .= "and content6 = 1 ";
	}
	
	//write the select statement to get the 6 videos
	$queryX .= " ORDER BY RAND()
	LIMIT 5";
	
	$resultX = @mysql_query ($queryX); //Run the query.
?>
							<div style="padding-top: 15px;">
								<table cellpadding="0" cellspacing="0" border="0" width="100%" onclick="exp_cont('rct')" style="cursor:pointer;">
									<tr>
										<td><img src="images/arrow-compress.gif" alt="arrow-compress" width="11" height="11" id="arrow_rct" /></td>
										<td style="font-size: 12px; font-weight: bold; padding-left: 5px;" width="100%"> Related Content Themes</td>
									</tr>
								</table>
							</div>
							<div id="related_rct" style="display:none;">
								<div id="playlist">
<?
	//Spit out 5 videos to display
	
	while ($collapse = mysql_fetch_array ($resultX, MYSQL_ASSOC)) {
?>
									<a href="watch.php?vid=<?= $collapse['vid'] ?>">
										<img src="http://bitcast-g.bitgravity.com/techit/<?= $collapse['processed_file']; ?>.jpg" width="124" height="76" border="0" title="<?= (strlen($collapse['title'] . " - " .$collapse['description']) > 150 ? substr($collapse['title'] . " - " . $collapse['description'],0,150).'...' : $collapse['title'] . " - " . $collapse['description'] ) ?>" />
										<strong><?= (strlen($collapse['title']) > 40 ? substr($collapse['title'],0,40).'...' : $collapse['title'] ) ?></strong>
										<p>Author: <?= $collapse['first_name'] ?> <?= $collapse['last_name'] ?></p>
										<em><?= $collapse['watched'] ?> Views</em>
									</a>
<?
	}
?>
								</div>
							</div>