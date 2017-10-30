<?php
 include "file_constants.php";
 // just so we know it is broken
 error_reporting(E_ALL);
 // some basic sanity checks
 if(isset($_GET['id']) && is_numeric($_GET['id'])) {
     //connect to the db
     //$link = mysql_connect("$host", "$user", "$pass")
     //or die("Could not connect: " . mysql_error());
     $conn = mysqli_connect("localhost", "root", "", "profile") OR DIE (mysql_error());

     // select our database
     //mysql_select_db("$db") or die(mysql_error());
     mysqli_select_db($conn,'profile')or die(mysqli_error($conn));

     // get the image from the db
     //$sql = "SELECT image FROM test_image WHERE id=" .$_GET['id'] . ";";
     $sql = mysqli_query($conn, "SELECT image FROM test_image WHERE id=" .$_GET['id'] . ";";);

     // the result of the query
     $result = mysqli_query("$sql") or die("Invalid query: " . mysqli_error());

     // set the header for the image
     header("Content-type: image/jpeg");
     echo mysqli_result($result, 0);

     // close the db link
     mysqli_close($conn);
 }
 else {
     echo 'Please use a real id number';
 }
?>