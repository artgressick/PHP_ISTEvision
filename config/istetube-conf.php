<?php

// # Script 1.0 - mysql_connect.php
// Written by Arthur Gressick for use on Macintosh OS X.5 this should work on any PHP/MySQL enabled server but you may have to tweak the settings. 

// MySQL information

define ('DB_User', 'istevision'); //This is the Username that has been created.
define ('DB_Password', 'PASSWORD'); //This is the password for the User.
//define ('DB_Host', 'localhost'); //production setting
define ('DB_Host', '10.10.1.243'); //development setting
define ('DB_Name', 'istevision'); //This is the Database name in MySQL.

//Make the connection and then select the database.

$dbc = mysql_connect (DB_Host, DB_User, DB_Password) OR die ('Could not connect to MySQL Server: ' .
mysql_error() );
mysql_select_db (DB_Name) or die ('Could not select the database: ' . mysql_error() );

//Base folder information for the flash linking make sure and include it where it is needed and please change for the production server.
$BF = "http://localhost/~agressick/svn/php_istevision/trunk/"; //this should be the path on your computer
$BF_Progressive = "http://techit.flv7.com/movies/";
$BF_Streaming = "rtmp://72.35.95.24/techit/";
//$BF = "http://localhost/~dswashburn/php/php_istevision/trunk/"; //this should be the path on your computer
//$BF = "http://www.istevision.org/"; //this should be the path on your computer

?>