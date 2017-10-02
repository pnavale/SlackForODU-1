<?php
include 'includes/htmlheader.php';
?>
<?php 
session_start();
if(!isset($_SESSION["sess_user"])){
	header("location:login.php");
} else {
?>
<!doctype html>
<html>
<head>
<title>Welcome</title>
    <style>           
        
    </style>
</head>
<body>
    <center><h1>Welcome to Slack for ODU</h1></center>
    
<h2>Welcome, <?=$_SESSION['sess_user'];?>! <a href="logout.php">Logout</a></h2>
<p>

</p>
</body>
</html>
<?php
}
?>


