<?php
	if(!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
		header ('Location: login.php');
		die();		
	}
?>