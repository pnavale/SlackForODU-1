<?php
include 'includes/functions.php';
if($cname!=''){
    $cname=$_SESSION['sess_user'];
}
$chats = array();
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
	$msg=$row['msg_body'];
//    $cdate=new DateTime($row['create_date']);
//    $displayDate=date_format($cdate, 'h:i');
    array_push($chats, $row);
	}

	} else {
	echo "No message yet.";
   // header("Location:wklogin.php");
	}    
        
    $query=mysql_query("SELECT * FROM message WHERE channel_id='".$channelSelected."'");
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
    else{

    $query=mysql_query("SELECT * FROM message WHERE creator_id='".$cname."'");
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
    //Profile Pic
    if($_SESSION['sess_user']!= $cname){
        $query=mysql_query("SELECT * FROM users WHERE username='".$cname."'");
    $numrows=mysql_num_rows($query);
    //echo $numrows;
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
	$profile_pic=$row['profile_pic'];
	}

	} else {
	//echo "No message yet.";
   // header("Location:wklogin.php");
	}   
    }
    else
    {
      $profile_pic = $_SESSION['sess_user_profile_pic'];   
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

			<h4><?php echo ucwords($cname) ?></h4>

			<span class="chat-message-counter">3</span>

		</header>

		<div class="chat">
			
			<div class="chat-history">
				 <?php
                foreach ($chats as $value) {
                    $crdate=date_format(new DateTime($value['create_date']),'h:i');
                    ?>
				<div class="chat-message clearfix">
					
					<img src="../images/<?php echo $profile_pic ?>" alt="profile pic" width="32" height="32">

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
	$message=verify_input($_POST['message']);
    $subject='private';
	$creator_id=$cname;
	$thread_id='p'+$cname;
    if($cname){
     $channel_id='';   
    }else
    {
       $channel_id='';    
    }
	$group_id='';
	$recipient_id=$_SESSION['sess_user'];

    mysql_query("insert into message (subject,creator_id,msg_body,create_date,thread_id,channel_id,group_id,recipient_id)
	values('$subject','$creator_id','$message',NOW(),'$thread_id','$channel_id','$group_id','$recipient_id')
	")or die(mysql_error());
 

} 
}else {
	echo "Something went wrong!";
}
?>
