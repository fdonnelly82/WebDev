<?php
    //set off all error report
	error_reporting(E_ALL);
	//define database username and pass
    define( "DB_DSN", "mysql:host=localhost;dbname=db_webappdev" );
    define( "DB_USERNAME", "root" );
    define( "DB_PASSWORD", "" );
	define( "CLS_PATH", "class" );
	//classes path
	include_once( CLS_PATH . "/user.php" );
	
?>