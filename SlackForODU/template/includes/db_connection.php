<?php
// Create connection
$connection = mysqli_connect('localhost', 'root', '');
// $connection=mysqli_connect('localhost','admin','M0n@rch$');
//mysql_select_db('slack',$connection)or die(mysql_error());
mysqli_select_db($connection, 'slack') or die(mysqli_error($connection));
// Test if connection succeeded
if (mysqli_error($connection)) {
    die("Database connection failed");
}
