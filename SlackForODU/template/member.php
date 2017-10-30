<?php
session_start();
if (!isset($_SESSION["sess_user"])) {
    header("location:login.php");
}
include 'includes/htmlheader.php';
?>
    <center>
        <h1>Welcome to Slack for ODU</h1>
    </center>
    <h3>Welcome, <?=$_SESSION['sess_user_fullname'];?>! <a href="logout.php" class="pull-right">Logout</a></h3>
    <div class="row">
        <div class="col-sm-0 col-md-3 col-lg-3 col-xs-0" style="background-color:#2c2d30;">
            <?php include 'sidebar.php';?>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9 col-xs-12">
            <?php include 'chat.php';?>
        </div>
    </div>