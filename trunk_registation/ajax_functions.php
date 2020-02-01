<?
	require_once ('istetube-conf.php'); //Map the Connection.
	session_start();
	
	if($_REQUEST['postType'] == "checktimes") {
		
		$q = "SELECT id 
		FROM lounge_sessions
		WHERE id != '".$_REQUEST['id']."' AND location_id='".$_REQUEST['location_id']."' AND date = '".$_REQUEST['date']."' AND 
		(('".$_REQUEST['tb'].":00' BETWEEN begin_time AND end_time AND '".$_REQUEST['tb'].":00' != end_time) 
		OR ('".$_REQUEST['te'].":00' BETWEEN begin_time AND end_time AND '".$_REQUEST['te'].":00' != begin_time)
		OR (begin_time BETWEEN '".$_REQUEST['tb'].":00' AND '".$_REQUEST['te'].":00' AND begin_time != '".$_REQUEST['te'].":00') 
		OR (end_time BETWEEN '".$_REQUEST['tb'].":00' AND '".$_REQUEST['te'].":00' AND end_time != '".$_REQUEST['tb'].":00')
		OR (begin_time = '".$_REQUEST['tb'].":00') 
		OR (end_time = '".$_REQUEST['te'].":00'))
		";
		
//		echo $q."<br /><br />";
		
		$results = @mysql_query ($q);
		
		echo mysql_num_rows($results);
	
	} else if($_REQUEST['postType'] == 'checkemail') {
		$q = "SELECT id
		FROM lounge_presenters
		WHERE email_address = '".$_REQUEST['email']."'
		";
		
//		echo $q."<br /><br />";
		
		$results = @mysql_query ($q);
		
		echo mysql_num_rows($results);
	}
?>