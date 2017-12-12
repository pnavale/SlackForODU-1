<?php 
session_start();
unset($_SESSION['sess_user']);
unset($_SESSION['git_user']);
unset($_SESSION['twitter_user']);
session_destroy();
header("location:wklogin.php");
?>
