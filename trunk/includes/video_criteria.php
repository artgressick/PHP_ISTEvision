<?
	//get the video criteria
	$sql_query = "SELECT *
	FROM video_criteria
	WHERE video_criteria.video_id = '". $videos['id'] . "'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$video_criteria = mysql_fetch_array ($result, MYSQL_ASSOC);
?>
								<tr>
									<td nowrap valign="top"><strong>Education Level:</strong></td>
<? //build an include file for this 
	$education_level = ""; //start with a clean state.
	
	if ($video_criteria['elevel1'] == "1") {
		$education_level .= "PK-8, ";
	}
	if ($video_criteria['elevel2'] == "1") {
		$education_level .= "9-12, ";
	}
	if ($video_criteria['elevel3'] == "1") {
		$education_level .= "Community College, ";
	}
	if ($video_criteria['elevel4'] == "1") {
		$education_level .= "University, ";
	}
	if ($video_criteria['elevel5'] == "1") {
		$education_level .= "Continuing Education, ";
	}
	if ($video_criteria['elevel6'] == "1") {
		$education_level .= "Other, ";
	}

?>
									<td><?= substr($education_level, 0, -2) ?></td>
								</tr>
								<tr>
									<td nowrap valign="top"><strong>Content Themes:</strong></td>
<? //build an include file for this
	$content_themes = ""; //start with a clean state.
	
	if ($video_criteria['content1'] == "1") {
		$content_themes .= "School Improvement, ";
	}
	if ($video_criteria['content2'] == "1") {
		$content_themes .= "Ethics &amp; Equity, ";
	}
	if ($video_criteria['content3'] == "1") {
		$content_themes .= "Technology Infrastructure, ";
	}
	if ($video_criteria['content4'] == "1") {
		$content_themes .= "Professional Learning, ";
	}
	if ($video_criteria['content5'] == "1") {
		$content_themes .= "21st Century Teaching & Learning, ";
	}
	if ($video_criteria['content6'] == "1") {
		$content_themes .= "Virtual Schooling/E-learning, ";
	}
?>
									<td><?= substr($content_themes, 0, -2) ?></td>
								</tr>
								<tr>
									<td nowrap valign="top"><strong>Curricular Areas:</strong></td>
<? //build an include file for this
	$curricular_areas = ""; //start with a clean state.
	
	if ($video_criteria['cirricular1'] == "1") {
		$curricular_areas .= "Language Arts, ";
	}
	if ($video_criteria['cirricular2'] == "1") {
		$curricular_areas .= "Art, ";
	}
	if ($video_criteria['cirricular3'] == "1") {
		$curricular_areas .= "Math, ";
	}
	if ($video_criteria['cirricular4'] == "1") {
		$curricular_areas .= "Science, ";
	}
	if ($video_criteria['cirricular5'] == "1") {
		$curricular_areas .= "Social Studies, ";
	}
	if ($video_criteria['cirricular6'] == "1") {
		$curricular_areas .= "Music/Drama, ";
	}
	if ($video_criteria['cirricular7'] == "1") {
		$curricular_areas .= "ICT, ";
	}
	if ($video_criteria['cirricular8'] == "1") {
		$curricular_areas .= "Physical Education, ";
	}
	if ($video_criteria['cirricular9'] == "1") {
		$curricular_areas .= "Interdisciplinary, ";
	}
	if ($video_criteria['cirricular10'] == "1") {
		$curricular_areas .= "Other, ";
	}
?>
									<td><?= substr($curricular_areas, 0, -2) ?></td>
								</tr>
								<tr>
									<td nowrap valign="top"><strong>Story decade:</strong></td>
<? //build an include file for this
	$decade = ""; //start with a clean state.
	
	if ($video_criteria['decade1'] == "1") {
		$decade .= "1959-1968, ";
	}
	if ($video_criteria['decade2'] == "1") {
		$decade .= "1969-1978, ";
	}
	if ($video_criteria['decade3'] == "1") {
		$decade .= "1979-1988, ";
	}
	if ($video_criteria['decade4'] == "1") {
		$decade .= "1989-1998, ";
	}
	if ($video_criteria['decade5'] == "1") {
		$decade .= "1999-2009, ";
	}
	if ($video_criteria['decade6'] == "1") {
		$decade .= "Future, ";
	}
?>
									<td><?= substr($decade, 0, -2) ?></td>
								</tr>
								<tr>
									<td nowrap valign="top"><strong>Story relates to:</strong></td>
<? //build an include file for this
	$relates = ""; //start with a clean state.
	
	if ($video_criteria['relates1'] == "1") {
		$relates .= "Educational transformation, ";
	}
	if ($video_criteria['relates2'] == "1") {
		$relates .= "ISTE, ";
	}
	if ($video_criteria['relates3'] == "1") {
		$relates .= "NECC, ";
	}
	if ($video_criteria['relates4'] == "1") {
		$relates .= "General Ed Tech, ";
	}
	if ($video_criteria['relates5'] == "1") {
		$relates .= "Other, ";
	}
?>
									<td><?= substr($relates, 0, -2) ?></td>
								</tr>