
    <?php
    include 'includes/db_connection.php';
    include 'includes/functions.php';
 include 'chatHistory.php';
    ?>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700">

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
                    $prevDate='';
                    usort($chats, function($a, $b) {
                        return strtotime($a['create_date']) - strtotime($b['create_date']);
                    });
                    foreach ($chats as $value) {
                        $crfdate=date_format(new DateTime($value['create_date']),'l, F j, Y');
                        $crdate=date_format(new DateTime($value['create_date']),'g:i a');
                        ?>
                    <center><?php 
                        if(strcmp($crfdate, $prevDate)>0){
                        echo $crfdate;
                        $prevDate=$crfdate;
                        }
                        ?></center>
                    <div class="chat-message clearfix">

                        <img src="../images/<?php echo $value['profile_pic'] ?>" alt="profile pic" width="32" height="32">

                        <div class="chat-message-content clearfix">

                            <span class="chat-time"><?php echo $crdate ?></span>

                            <b><?php echo ucwords($value['creator_id']); ?></b>

                            <p><?php echo $value['msg_body'];?>
                                
                            </p>
                            <?php 
                            $plusReaction = array();
                            $query="SELECT * FROM Reply WHERE msg_id='".$value['msg_id']."' and reaction='+1'";
                            $result= $connection->query($query);
                            //echo $numrows;
                            if ($result-> num_rows>0) 
                            {
                            while($row=$result->fetch_assoc())
                            {
                                array_push($plusReaction, $row);
                            }} 
                            $minusReaction = array();
                            $query="SELECT * FROM Reply WHERE msg_id='".$value['msg_id']."' and reaction='-1'";
                            $result= $connection->query($query);
                            //echo $numrows;
                            if ($result-> num_rows>0) 
                            {
                            while($row=$result->fetch_assoc())
                            {
                                array_push($minusReaction, $row);
                            }} 

                            ?>
                            <a href="javascript:void(0);" data-href="member.php?emoji=+1&person=<?php echo $value['creator_id']?>&msgid=<?php echo $value['msg_id']?>" class="emoji" >&#128077;</a><span><?php echo count($plusReaction)?></span>
                             <a href="javascript:void(0);"  data-href="member.php?emoji=-1&person=<?php echo $value['creator_id']?>&msgid=<?php echo$value['msg_id']?>" class="emoji" >&#x1F44E;</a><span><?php echo count($minusReaction)?></span>




                              <?php
                    $prevDate1='';
                     $replies = array();
                    if($_SESSION['sess_user']){
                        if($channelSelected != ''){
                        $query="SELECT * FROM Reply WHERE msg_id='".$value['msg_id']."' and reply_type='reply'";
                        $result= $connection->query($query);
                        if($result-> num_rows>0)
                        {
                        while($row=$result->fetch_assoc())
                        {
                            array_push($replies, $row);
                        }

                        } 
                    usort($replies, function($a, $b) {
                        return strtotime($a['replied_at']) - strtotime($b['replied_at']);
                    });
                    foreach ($replies as $value) {
                        $crfdate=date_format(new DateTime($value['replied_at']),'l, F j, Y');
                        $crdate=date_format(new DateTime($value['replied_at']),'g:i a');
                        ?>
                          <center><?php 
                        if(strcmp($crfdate, $prevDate1)>0){
                        echo $crfdate;
                        $prevDate1=$crfdate;
                        }
                        ?></center>
                    <div class="chat-message clearfix">
                        <img src="../images/<?php echo $value['profile_pic'] ?>" alt="profile pic" width="24" height="24">


                        <div class="chat-message-content clearfix">

                            <span class="chat-time"><?php echo $crdate ?></span>

                            <b><?php echo ucwords($value['replied_by']) ?></b>

                            <p><?php echo $value['reply_msg'];?>
                                
                            </p>
                            <?php 
                            $plusReaction = array();
                            $query="SELECT * FROM Reply WHERE reply_id='".$value['reply_id']."' and reaction='+1'";
                            $result= $connection->query($query);
                            //echo $numrows;
                            if ($result-> num_rows>0) 
                            {
                            while($row=$result->fetch_assoc())
                            {
                                array_push($plusReaction, $row);
                            }} 
                            $minusReaction = array();
                            $query="SELECT * FROM Reply WHERE reply_id='".$value['reply_id']."' and reaction='-1'";
                            $result= $connection->query($query);
                            //echo $numrows;
                            if ($result-> num_rows>0) 
                            {
                            while($row=$result->fetch_assoc())
                            {
                                array_push($minusReaction, $row);
                            }} 

                            ?>
                            </div>
                            </div>
                              <?php
                          }
                      }
                    }
                 ?>








                    <form action="" method="post">
                    <fieldset>
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10 col-xs-10">
                        <input  type="text" placeholder="Reply here…" id="<?php echo "reply".$value['msg_id'] ?>"  name="reply_message" autofocus>
                                  </div>
                                   <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2">
                                   <input  type="submit" value="Reply" class="btn reply" name="reply" id="<?php echo "msg".$value['msg_id'] ?>"/>
        
<!--                               style="position: absolute; left: -9999px"-->
                            </div>
                            </div>
                    </fieldset>
                </form>
                        </div> <!-- end chat-message-content -->

                    </div> <!-- end chat-message -->

                    <hr>
     <?php
                    }
                 ?>
                </div> <!-- end chat-history -->

    <!--			<p class="chat-feedback">Your partner is typing…</p>-->





                <form action="#" method="post">

                    <fieldset>
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10 col-xs-10">
                        <input  type="text" placeholder="Type your message…" name="message" autofocus>
                                  </div>
                                   <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2">
    					<input  type="submit" value="Send" class="btn" name="submit" />
<!--                               style="position: absolute; left: -9999px"-->
                            </div>
                            </div>
                    </fieldset>

                </form>

            </div> <!-- end chat -->

        </div> <!-- end live-chat -->
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

        $connection->query("insert into message (subject,creator_id,msg_body,create_date,channel_id,group_id,recipient_id,profile_pic)
        values('$subject','$creator_id','$message',NOW(),'$channel_id','$group_id','$recipient_id','$profile_pic')
        ")or die( mysqli_close($connection));
     $_POST['message']='';
    unset($_POST['message']);
    exit;
    } 
    }
    }else {
        echo "Something went wrong!";
    }

    ?>

<script type="text/javascript">
    $('.emoji').on('click', function(e){
        console.log($(this).data('href'));
        var data = $(this).data('href');
        // member.php?emoji=+1&person=mater&msgid=8
        var url=data.substring(0,10);
        var emoji= data.substring(17,19);
        var msgid = data.substring(data.search('msgid=')+6,data.length);
        var person=data.substring(27,data.search('&msgid='));

$.ajax({type:'GET',
          url: 'chat.php',
          data : {emoji:emoji,person:person,msgid:msgid},
          success: function(response){
            console.log({emoji:emoji,person:person,msgid:msgid});
            return {emoji:emoji,person:person,msgid:msgid};
          }
        });
    // $('.emoji').css('color','#9c7248');
    })
     $('.reply').click(function(){
        console.log($(this).attr('id'));
        var msgId = this.id.substring(3,this.id.length);
        var replyInput = 'reply'+msgId;
        var replyInput=$('#'+replyInput).val();
        console.log(replyInput);
        console.log(msgId);
        $.ajax({type:'GET',
          url: 'reply.php',
          data : {msg_id:msgId,reply:replyInput},
          success: function(response){
            return {msg_id:msgId,reply:replyInput};
          }
        });
         });
</script>
<?php
$profile=$_SESSION['sess_user_profile_pic'];
echo $profile;
if($_SESSION['sess_user']){
if(isset($_GET["emoji"]) ||isset($_GET["person"])|| isset($_GET["msgid"])){
        echo "nnjnjnj".$_GET["emoji"].$_GET["person"].$_GET["msgid"];
        $emoji=$_GET["emoji"];
        $person=$_SESSION['sess_user'];
        $msgid=$_GET["msgid"];
        $msg_type="reaction";
        $query="SELECT * FROM Reply WHERE msg_id='".$msgid."' and reaction='".$emoji."' and replied_by='".$person."'";
        $result= $connection->query($query);
        if ($result-> num_rows>0) 
            { echo "You can't like/dislike multiple times.";
               }else{
        $sql="insert into Reply(msg_id,reply_msg,replied_by,replied_at,reaction,reply_type) values('$msgid','','$person',NOW(),'$emoji','$msg_type')";
        if (mysqli_query($connection, $sql)) {
      echo "Record updated successfully";
   } else {
      echo "Error updating record: " . mysqli_error($connection);
   }} 
    }
    
    if(isset($_POST["reply"]) && isset($_POST["reply_message"]) && isset($_GET["msg_id"])  ){
        $replyMsg=$_POST["reply_message"];
        $msgid=$_GET["msg_id"];
        $msg_type="reply";
        $replied_by=$_SESSION['sess_user'];
        if($_SESSION['sess_user_profile_pic']){
        $profile=$_SESSION['sess_user_profile_pic'];
        }
        else{
            $profile="person.png";
        }
        $sql="insert into Reply(profile_pic,msg_id,reply_msg,replied_by,replied_at,reaction,reply_type) values('$profile','$msgid','$replyMsg','$replied_by',NOW(),'','$msg_type')";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . mysqli_error($connection);
                   }} 
            // }}
    
}
     mysqli_close($connection);
?>

