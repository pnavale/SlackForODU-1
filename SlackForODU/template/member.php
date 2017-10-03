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
        span{
            font-size: 20px;
        }
        a{
            font-size: 18px;
        }
    </style>
</head>
<body>
    <center><h1>Welcome to Slack for ODU</h1></center>
    
<h2>Welcome, <?=$_SESSION['sess_user'];?>! <a href="logout.php" class="pull-right">Logout</a></h2>
<?php
}
?>

<div class="wrap">
    <div class="fleft">
        <div class = "Users" style="color:#DCDCDC;">
            <a href="#"><span>
         <?php
            echo $_SESSION['wkurl'];
              ?></span></a>
            <span style="color:#DCDCDC;margin-left:50%;" class="material-icons" style="font-size:36px">add_alert</span>
        </div>
        
        <br><br>
        <div class = "Channel" style="color:#DCDCDC;">
            <span>Channels </span>
             <a href="#">
          <span style="color:#F5F5F5;margin-left:44%;" class="glyphicon glyphicon-plus-sign"></span>
        </a><br>
            
         <?php
            $channels = array();
if($_SESSION['sess_user']){
	//$con=mysql_connect('localhost','admin','M0n@rch$') or die(mysql_error());
    $con=mysql_connect('localhost','root','') or die(mysql_error());
	mysql_select_db('slack') or die("cannot select DB");
    $query=mysql_query("SELECT * FROM channel");
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
    foreach ($channels as $value) {
        
        echo "<a style='color:#FFFFFF;' href='#'>"."#".$value['channel_name']."<br>";
    }    
        
	} else {
//	echo "We couldn’t find your workspace";
   // header("Location:wklogin.php");
	}

} else {
	echo "Something went wrong!";
}
?>
            </p>
        
        
        
        
        
        
        </div>
        <div class = "Direct Messages"  style="color:#DCDCDC;">  
        
    <br><br>
            <span>Direct Messages </span>
             <a href="#">
          <span style="color:#F5F5F5;margin-left:18%;" class="glyphicon glyphicon-plus-sign"></span>
                 <a style='color:#FFFFFF;' href='#'><span style='color:#f27670;'>&hearts;</span>slackbot<br></a>
            
         <?php
            $members = array();
            if($_SESSION['sess_user']){
	//$con=mysql_connect('localhost','admin','M0n@rch$') or die(mysql_error());
    $con=mysql_connect('localhost','root','') or die(mysql_error());
	mysql_select_db('slack') or die("cannot select DB");
    $wk_id = $_SESSION['wkid'];
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
        if($value['username'] == $_SESSION['sess_user']){
            echo "<a style='color:#FFFFFF;' href='#'><span style='color:palevioletred;'>&hearts;</span>".$value['username']."&nbsp;&nbsp;(you)<br>";
        }
        else{
              echo "<a style='color:#FFFFFF;' href='#'><span style='color:palevioletred;'>&hearts;</span>".$value['username']."<br>";
        }
      
    }    
        
	} else {
//	echo "We couldn’t find your workspace";
   // header("Location:wklogin.php");
	}

} else {
	echo "Something went wrong!";
}
?>    </a><br>
    </div>
        
    </div>
    
    <div class="fright">
 
        <?php
include 'chat.php';
?>
</body>
</html>


