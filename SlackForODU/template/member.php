<?php
session_start();
//require "init.php";
//fetchData();

//Go to Login page if not already logged in.
if (!isset($_SESSION["sess_user"])) {
    header("location:login.php");
}
//if (!isset($_SESSION["user"])) {
//    header("location:index.php");
//}
include 'includes/htmlheader.php';
?>
    <center>
        <h1>Welcome to Slack for ODU</h1>
    </center>
    <!-- Display username. -->
    <h3>Welcome, <?=$_SESSION['sess_user_fullname'];?>! 
    <a href="logout.php" class="pull-right"> Logout </a>
    <a href="../help/help.html" class="pull-right">Help&nbsp;&nbsp;&nbsp;</a>

        
    </h3>
    <div class="row">
        <!-- Display sidebar. -->
        <div class="col-sm-0 col-md-3 col-lg-3 col-xs-0" style="background-color:#2c2d30;">
            <?php include 'sidebar.php';?>
        </div>
        <!-- Display chat pane. -->
        <div class="col-sm-12 col-md-9 col-lg-9 col-xs-12">
            <?php include 'chat.php';?>
        </div>
    </div>
