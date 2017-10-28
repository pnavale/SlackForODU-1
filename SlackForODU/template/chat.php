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

                            <h5><?php echo ucwords($value['creator_id']) ?></h5>

                            <p><?php echo $value['msg_body'];?>
                                
                            </p>
                            <a href="javascript:void(0);" data-href="member.php?emoji=+1&person=<?php echo $value['creator_id']?>&msgid=<?php echo$value['msg_id']?>" values="emoji=+1;person=<?php echo $value['creator_id']?>" class="emoji" >&#128077;</a>
                             <a href="javascript:void(0);"  data-href="member.php?emoji=-1&person=<?php echo $value['creator_id']?>&msgid=<?php echo$value['msg_id']?>" values="emoji=-1;person=<?php echo $value['creator_id']?>"  class="emoji" >&#x1F44E;</a>
                                  <form action="#" method="post">

                    <fieldset>
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10 col-xs-10">
                        <input  type="text" placeholder="Type your message…" name="message" autofocus>
                                  </div>
                                   <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2">
                        <input  type="submit" value="Reply" class="btn" name="reply" />
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
console.log(url);
$.ajax({type:'GET',
          url: 'chat.php',
          data : {emoji:emoji,person:person,msgid:msgid},
          success: function(response){
            console.log(data,emoji);
            console.log({emoji:emoji,person:person,msgid:msgid});
            return {emoji:emoji,person:person,msgid:msgid};
          }
        });
    })
</script>
<?php

if(isset($_GET["emoji"]) ||isset($_GET["person"])|| isset($_GET["msgid"])){
        echo "nnjnjnj".$_GET["emoji"].$_GET["person"].$_GET["msgid"];
        $emoji=$_GET["emoji"];
        $person=$_GET["person"];
        $msgid=$_GET["msgid"];
        $msg_type="reaction";
        $sql="UPDATE message set reaction='".$emoji."', msg_type='".$msg_type."', channel_id='".$channel_idSelected."', reacted='".$person."' where msg_id='".$msgid."'";
        if (mysqli_query($connection, $sql)) {
      echo "Record updated successfully";
   } else {
      echo "Error updating record: " . mysqli_error($connection);
   }
    }

     mysqli_close($connection);
?>

