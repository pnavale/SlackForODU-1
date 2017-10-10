<?php
include 'includes/functions.php';

 $chats = array();
if($_SESSION['sess_user']){
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
					
					<img src="../images/<?php echo $_SESSION['sess_user_profile_pic'] ?>" alt="profile pic" width="32" height="32">

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
					<input type="submit" value="Send" class="btn btn-success" name="submit" />

				</fieldset>

			</form>

		</div> <!-- end chat -->

	</div> <!-- end live-chat -->
	
</body>
</html>

  <?php 
    if($_SESSION['sess_user']){
    if (isset($_POST['submit'])){ 
	$message=verify_input($_POST['message']);
    $subject='private';
	$creator_id=$_SESSION['sess_user'];
	$thread_id='th1';
	$channel_id='ch1';
	$group_id='g1';
	$recipient_id='mcqueen';

    mysql_query("insert into message (subject,creator_id,msg_body,create_date,thread_id,channel_id,group_id,recipient_id)
	values('$subject','$creator_id','$message',NOW(),'$thread_id','$channel_id','$group_id','$recipient_id')
	")or die(mysql_error());
 

} 
}else {
	echo "Something went wrong!";
}
?>
