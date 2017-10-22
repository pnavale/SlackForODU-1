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

    <style>           
        span{
            font-size: 20px;
        }
        .names, a{
            font-size: 18px;
        }
    </style>
<body>
    <center><h1>Welcome to Slack for ODU</h1></center>
    
<h3>Welcome, <?=$_SESSION['sess_user_fullname'];?>! <a href="logout.php" class="pull-right">Logout</a></h3>
<?php
}
?>
<div class="row">
<div class="col-sm-0 col-md-2 col-lg-2 col-xs-0" style="background-color:#2c2d30;">
    <div class="row">
        <div class ="col-sm-0 col-md-10 col-lg-10 col-xs-0" style="color:#DCDCDC;font-size: 24px;">
           
         <?php
            echo $_SESSION['wkurl'];
              ?>
        </div>
         <div class ="col-sm-0 col-md-2 col-lg-2 col-xs-0" style="color:#DCDCDC;">
              <a href="#">
            <span style="color:#DCDCDC;" class="material-icons" style="font-size:36px">add_alert</span></a>
    </div>
    </div>
        <br><br>
     <div class="row">
        <div class = "Channel col-sm-0 col-md-10 col-lg-10 col-xs-0" style="color:#DCDCDC;">   
            <span>Channels </span>
         </div>
         <div class ="col-sm-0 col-md-2 col-lg-2 col-xs-0">
             <a href="channel.php">
          <span style="color:#F5F5F5;" class="glyphicon glyphicon-plus-sign"></span>
        </a><br>
         </div>
         </div>
          <form method="GET">  
         <?php
            $channels = array();
                $cname='slackbot';
if($_SESSION['sess_user']){
    $query="SELECT * FROM channel where channel_creator='default'";
    $result= $connection->query($query);
    //creator='".$_SESSION['sess_user']."' or
    //creator='default'
    //echo $numrows;
	if($result-> num_rows>0)
	{
	while($row=$result->fetch_assoc())
	{
	 array_push($channels, $row);
        
	}
    }
    $query="SELECT * FROM channel where wk_id='".$_SESSION['wkid']."'";
    //creator='".$_SESSION['sess_user']."' or
    //creator='default'
   $result= $connection->query($query);
    //echo $numrows;
	if($result-> num_rows>0)
	{
	while($row=$result->fetch_assoc())
	{
	 array_push($channels, $row);
        
	} }
        
    foreach ($channels as $value) {
        
        echo "<a href='member.php?ch=".$value['channel_name']."' name='ch' value='".$value['channel_name']."'><span style='color:#FFFFFF;'>"."#".$value['channel_name']."</span><br></a>";
    }       
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
            <div class ="col-sm-0 col-md-10 col-lg-10 col-xs-0">
            <span>Direct Messages </span>
            </div>
            <div class ="col-sm-0 col-md-2 col-lg-2 col-xs-0">
             <a href="#">
                 <span style="color:#F5F5F5;" class="glyphicon glyphicon-plus-sign"></span></a>
                </div>
                </div>
            <form name="usersForm" method="GET" style="font-size: 20px;">
                <a href='#' name='pc' style='color:#FFFFFF;' value="slackbot"><span style='color:#f27670;'>&hearts;</span>slackbot<br></a>
            
         <?php
            $members = array();
            if($_SESSION['sess_user']){
	mysqli_select_db($connection,'slack') or die("cannot select DB");
    $query="SELECT * FROM users where workspace_id='".$_SESSION['wkid']."'";
    //creator='".$_SESSION['sess_user']."' or
    //creator='default'
    $result= $connection->query($query);
    //echo $numrows;
	if($result-> num_rows>0)
	{
	while($row=$result->fetch_assoc())
	{
	 array_push($members, $row);
        
	}

    foreach ($members as $value) {
         $uname = $value['username'];
        
        if($value['username'] == $_SESSION['sess_user']){
            echo "<a name='pc' href='member.php?pc=".$value['username']."' class='names' style='color:#FFFFFF;' value='".$value['username']."' ><span style='color:palevioletred;'>&hearts;</span>".$value['username']."&nbsp;&nbsp;(you)<br></a>";
        }
        else{
              echo "<a name='pc' href='member.php?pc=".$value['username']."' class='names' style='color:#FFFFFF;' value='".$value['username']."'><span style='color:palevioletred;'>&hearts;</span>".$value['username']."<br> </a>";
        }

    }    
	} else {
//	echo "We couldn’t find your workspace";
   // header("Location:wklogin.php");
	}

} 
//                 else {
//	echo "Something went wrong!";
//}
?>    <br>
       </form>
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
mysqli_close($connection);
include 'chat.php';
?>
    </div>
    </div>
    </body>


