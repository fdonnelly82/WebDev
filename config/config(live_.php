<?php
    //set off all error report
	error_reporting(E_ALL);
	//define database username and pass
    define( "DB_DSN", "mysql:host=us-cdbr-azure-west-c.cloudapp.net;dbname=db_webapplicationdev" );
    define( "DB_USERNAME", "b0d377dde65ed2" );
    define( "DB_PASSWORD", "fe8a6525" );
	define( "CLS_PATH", "class" );
	//classes path
	include_once( CLS_PATH . "/user.php" );
	
?>