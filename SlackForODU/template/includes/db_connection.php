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
$connection=mysql_connect('localhost','root','');
mysql_select_db('slack',$connection)or die(mysql_error());
//mysql_select_db('slack',mysql_connect('localhost','admin','M0n@rch$'))or die(mysql_error());


  // Test if connection succeeded
  if(mysql_error()) {
    die("Database connection failed" );
  }
?>
