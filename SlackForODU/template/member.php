<?php
include 'includes/htmlheader.php';
include 'includes/db_connection.php';
?>
<?php 
session_start();
if(!isset($_SESSION["sess_user"])){
	header("location:login.php");
} else {
?>
<html>
<head>
<title>Welcome</title>
    <style>           
        span{
            font-size: 20px;
        }
        .names, a{
            font-size: 18px;
        }
    </style>
</head>
<body>
    <center><h1>Welcome to Slack for ODU</h1></center>
    
<h2>Welcome, <?=$_SESSION['sess_user_fullname'];?>! <a href="logout.php" class="pull-right">Logout</a></h2>
<?php
}
?>
<div class="row">
<div class="col-sm-0 col-md-2 col-lg-2 col-xs-0" style="background-color:#2c2d30;">
    <div class="row">
        <div class ="col-sm-0 col-md-8 col-lg-8 col-xs-0" style="color:#DCDCDC;">
           
         <?php
            echo $_SESSION['wkurl'];
              ?>
        </div>
         <div class ="col-sm-0 col-md-4 col-lg-4 col-xs-0" style="color:#DCDCDC;">
              <a href="#">
            <span style="color:#DCDCDC;" class="material-icons" style="font-size:36px">add_alert</span></a>
    </div>
    </div>
        <br><br>
     <div class="row">
        <div class = "Channel col-sm-0 col-md-8 col-lg-8 col-xs-0" style="color:#DCDCDC;">   
            <span>Channels </span>
         </div>
         <div class ="col-sm-0 col-md-4 col-lg-4 col-xs-0">
             <a href="#">
          <span style="color:#F5F5F5;" class="glyphicon glyphicon-plus-sign"></span>
        </a><br>
         </div>
         </div>
          <form method="GET">  
         <?php
            $channels = array();
                $cname='slackbot';
if($_SESSION['sess_user']){
//    $con=mysql_connect('localhost','admin','M0n@rch$') or die(mysql_error());
//    //$con=mysql_connect('localhost','root','') or die(mysql_error());
//	mysql_select_db('slack') or die("cannot select DB");
    $query=mysql_query("SELECT * FROM channel where channel_creator='default'");
    //creator='".$_SESSION['sess_user']."' or
    //creator='default'
    $numrows=mysql_num_rows($query);
    //echo $numrows;
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
	 array_push($channels, $row);
        
	}
    }
    $wk_id=$_SESSION['wkid'];
    $query=mysql_query("SELECT * FROM channel where wk_id='".$_SESSION['wkid']."'");
    //creator='".$_SESSION['sess_user']."' or
    //creator='default'
    $numrows=mysql_num_rows($query);
    //echo $numrows;
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
	 array_push($channels, $row);
        
	} }
        
    foreach ($channels as $value) {
        
        echo "<input type='radio' name='ch' value='".$value['channel_name']."'><span style='color:#FFFFFF;'>"."#".$value['channel_name']."</span><br>";
    }    
     echo "<input type = 'submit' value='Channel' />";     
	} 
//            else {
//	echo "Something went wrong!";
//}
?>
           
            </form>   
        <div class = "Direct Messages"  style="color:#DCDCDC;">  
        
    <br><br>
<?php
function clickPrivateChat($selectedName) {
    $cname=$selectedName; 
    return $cname;
    }
?>        
            <div class="row">
            <div class ="col-sm-0 col-md-8 col-lg-8 col-xs-0">
            <span>Direct Messages </span>
            </div>
            <div class ="col-sm-0 col-md-4 col-lg-4 col-xs-0">
             <a href="#">
                 <span style="color:#F5F5F5;" class="glyphicon glyphicon-plus-sign"></span></a>
                </div>
                </div>
            <form method="GET">
                 <input type='radio' name='pc' style='color:#FFFFFF;' href='#' value="slackbot"><span style='color:#f27670;'>&hearts;</span>slackbot<br>
            
         <?php
            $members = array();
            if($_SESSION['sess_user']){
	//$con=mysql_connect('localhost','admin','M0n@rch$') or die(mysql_error());
    $con=mysql_connect('localhost','root','') or die(mysql_error());
	mysql_select_db('slack') or die("cannot select DB");
    $query=mysql_query("SELECT * FROM users where workspace_id='$wk_id'");
    //creator='".$_SESSION['sess_user']."' or
    //creator='default'
    $numrows=mysql_num_rows($query);
    //echo $numrows;
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
	 array_push($members, $row);
        
	}

    foreach ($members as $value) {
         $uname = $value['username'];
        
        if($value['username'] == $_SESSION['sess_user']){
            echo "<input type='radio' name='pc' class='names' style='color:#FFFFFF;' value='".$value['username']."' ><span style='color:palevioletred;'>&hearts;</span>".$value['username']."&nbsp;&nbsp;(you)<br> ";
        }
        else{
              echo "<input type='radio' name='pc' class='names' style='color:#FFFFFF;' value='".$value['username']."'><span style='color:palevioletred;'>&hearts;</span>".$value['username']."<br> ";
        }

    }    
     echo "<input type = 'submit' value='Go' />";   
	} else {
//	echo "We couldn’t find your workspace";
   // header("Location:wklogin.php");
	}

} 
//                 else {
//	echo "Something went wrong!";
//}
?>    <br>
       </form>     </a>
    </div>
    </div>
    
        <div class="col-sm-12 col-md-10 col-lg-10 col-xs-12">
 
        <?php
$channelSelected='';
if(isset($_GET["ch"])){
$cname='';
$channelSelected=$_GET['ch'];
}
if(isset($_GET["pc"])){
$channelSelected='';
$cname=$_GET['pc'];
}
include 'chat.php';
?>
    </div>
</html>


