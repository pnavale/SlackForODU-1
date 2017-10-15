<?php
include 'includes/htmlheader.php';
include 'includes/db_connection.php';
include 'includes/functions.php';
?>
<?php
//if($cname!=''){
//    $cname=$_SESSION['sess_user'];
//}
$chats = array();
$channelObject = array();
if($_SESSION['sess_user']){
    if($channelSelected != ''){
        
    $query=mysql_query("SELECT * FROM channel WHERE channel_name='".$channelSelected."'");
    $numrows=mysql_num_rows($query);
    //echo $numrows;
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
	$channel_idSelected=$row['channel_id'];
//	$msg=$row['msg_body'];
////    $cdate=new DateTime($row['create_date']);
////    $displayDate=date_format($cdate, 'h:i');
//    array_push($chats, $row);
	}

	} else {
	echo "No message yet.";
   // header("Location:wklogin.php");
	}    
        
    $query=mysql_query("SELECT * FROM message WHERE channel_id='".$channel_idSelected."'");
    $numrows=mysql_num_rows($query);
    $chats = array();   
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
//	$currentThread=$row['thread_id'];
//	$msg=$row['msg_body'];
//    $cdate=new DateTime($row['create_date']);
//    $displayDate=date_format($cdate, 'h:i');
    array_push($chats, $row);
	}   
    
	} else {
	echo "No message yet.";
   // header("Location:wklogin.php");
	}
    }
    else{

    $query=mysql_query("SELECT * FROM message WHERE creator_id='".$cname."' and channel_id='' and recipient_id='".$_SESSION['sess_user']."'");
    $numrows=mysql_num_rows($query);
    //echo $numrows;
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
//	$currentThread=$row['thread_id'];
//	$msg=$row['msg_body'];
//    $cdate=new DateTime($row['create_date']);
//    $displayDate=date_format($cdate, 'h:i');
    array_push($chats, $row);
	}

	} else {
	echo "No message yet.";
   // header("Location:wklogin.php");
	}
            
    }
    
  }
?>

<!doctype html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<title>Live Chat</title>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700">

</head>
<body>

	<div id="live-chat">
		
		<header class="clearfix">
			
			<a href="#" class="chat-close">x</a>

			<h4><?php 
                if($channelSelected){
                    echo "#".$channelSelected;
                }else{
                    echo ucwords($cname);
                }
                 ?></h4>

			<span class="chat-message-counter">3</span>

		</header>

		<div class="chat">
			
			<div class="chat-history">
				 <?php
                foreach ($chats as $value) {
                    $crdate=date_format(new DateTime($value['create_date']),'h:i');
                    ?>
				<div class="chat-message clearfix">
					
					<img src="../images/<?php echo $value['profile_pic'] ?>" alt="profile pic" width="32" height="32">

					<div class="chat-message-content clearfix">
						
						<span class="chat-time"><?php echo $crdate ?></span>

						<h5><?php echo ucwords($value['creator_id']) ?></h5>

						<p><?php echo $value['msg_body'] ?></p>

					</div> <!-- end chat-message-content -->

				</div> <!-- end chat-message -->

				<hr>
 <?php
                }
             ?>
			</div> <!-- end chat-history -->
            
			<p class="chat-feedback">Your partner is typing…</p>

			<form action="#" method="post">

				<fieldset>
					
					<input type="text" placeholder="Type your message…" name="message" autofocus>
<!--					<input type="submit" value="Send" class="btn" name="submit" />-->

				</fieldset>

			</form>

		</div> <!-- end chat -->

	</div> <!-- end live-chat -->
	
</body>
</html>

  <?php 
    if($_SESSION['sess_user']){
    if (isset($_POST['message'])){ 
    if($_POST['message']!=''){
	$message=verify_input($_POST['message']);
    $subject=$channelSelected;
	$creator_id=$_SESSION['sess_user'];
	//$thread_id='p'+$cname;
    if($cname){
     $channel_id='';
     $recipient_id=$cname;
    }else
    {
       $channel_id=$channel_idSelected;
       $recipient_id='';
    }
	$group_id='';
    $profile_pic=$_SESSION['sess_user_profile_pic'];

    mysql_query("insert into message (subject,creator_id,msg_body,create_date,channel_id,group_id,recipient_id,profile_pic)
	values('$subject','$creator_id','$message',NOW(),'$channel_id','$group_id','$recipient_id','$profile_pic')
	")or die(mysql_error());
 $_POST['message']='';
unset($_POST['message']);
} 
}
}else {
	echo "Something went wrong!";
}
mysql_close($connection);
?>
