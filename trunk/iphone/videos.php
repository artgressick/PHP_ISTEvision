<?
	//Get a list of the videos for the iphone listing
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//This is for the User Profile. We need to get the information and display it on the page below.
	$sql_query = "select title, description, DATE_FORMAT(created_at, '%M %D, %Y') as day, DATE_FORMAT(created_at, '%h:%i %p') as time,
	(SELECT count(video_id) FROM views WHERE videos.id = views.video_id) as total_views, processed_file	
	FROM videos
	WHERE m4v_status = 1 and video_status_id = 2
	ORDER BY RAND()	
	LIMIT 10";
	
	$result = @mysql_query ($sql_query); //Run the query.
	
	include('includes/top.php');
?>

<div id="topbar">
	<div id="leftnav">
		<a href="index.php"><img alt="home" src="images/home.png" /></a>
		<a href="videos.php">Today's Videos</a>
	</div>
</div>
<div id="content">
	<span class="graytitle">Real Videos</span>
	<ul class="pageitem">
		<li class="textbox">Today's Videos</li>
<? //we need to convert this to work
	$Records = TRUE; //Prime the Record Switch	
	//If there are not records then we need to print an error
	while ($videos = mysql_fetch_array ($result, MYSQL_ASSOC)) {
?>
		<li class="store">
			<a class="noeffect" href="http://www.istevision.org/videos/mp4/<?= $videos['processed_file'] ?>.mp4">
			<span class="image" style="background-image: url('http://www.istevision.org/videos/jpg/<?= $videos['processed_file'] ?>.jpg'); -webkit-background-size: 90px 90px;"></span>
			<span class="name"><?= $videos['title'] ?></span><span class="comment"><?= $videos['description'] ?></span>
			<img alt="rating" class="stars" src="images/4stars.png" /><span class="starcomment"><?= $videos['total_views'] ?> Reviews</span>
			<span class="arrow"></span></a>
		</li>
<?
		$Records = FALSE; //set the records flag to ok			
	} //End the while loop
	
	//If there were no records then print the no records
	if ($Records) {
?>
		<li class="store">
			<span class="image" style="background-image: url('images/videooverlay-sm.jpg');"></span>
			<span class="comment">nothing</span><span class="name">No Videos at this time</span>
			<img alt="rating" class="stars" src="images/4stars.png" /><span class="starcomment">13 Reviews</span>
			<span class="arrow"></span>
		</li>
<?
	}
?>
	</ul>
</div>
<?
	include('includes/bottom.php');
?>