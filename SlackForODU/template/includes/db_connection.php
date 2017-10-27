<?php
//	define("DB_SERVER", "localhost");
//	define("DB_USER", "root");
//	define("DB_PASS", "");
//	define("DB_NAME", "slack");
//
//  // 1. Create a database connection
//  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
//  $db = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

// Create connection
//$connection=mysqli_connect('localhost','root','');
$connection=mysqli_connect('localhost','admin','M0n@rch$');
//mysql_select_db('slack',$connection)or die(mysql_error());
mysqli_select_db($connection,'slack')or die(mysqli_error($connection));


  // Test if connection succeeded
  if(mysqli_error($connection)) {
    die("Database connection failed" );
  }
?>
