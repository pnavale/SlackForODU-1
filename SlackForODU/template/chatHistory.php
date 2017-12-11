<?php

include 'includes/db_connection.php';
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['sess_user']) {
$cname = 'slackbot';
$oldChannelSelected =$channelSelected = '';
$totalpages=0;
$channels = [];
$channelArchived=false;
if (isset($_GET["ch"])) {
    $cname = '';
    $channelSelected = $_GET['ch'];
}
if (isset($_GET["pc"])) {
    $channelSelected = '';
    $cname = $_GET['pc'];
}
$chats = $channelObject = $data=[];
$query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
        $result1 = $connection->query($query);
        if ($result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
                     if($row['archived']==1){
                    $channelArchived=true;
                }
            }
        } 
if (isset($_GET["deleteMsg"])) {
    $deleteMsgId = $_GET['deleteMsg'];
    $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
        $result1 = $connection->query($query);
        if ($result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
                     if($row['archived']==1){
                    $channelArchived=true;
                }
            }
        } 
    if (!$channelArchived) {
    $sql = "DELETE FROM message WHERE msg_id='".$deleteMsgId."'";
    if ($connection->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}else{
        echo "This channel is archived so you can't post or react to any post until admin unarchive this channel.";
        }
}
$query = "SELECT * FROM channel where channel_creator='default' or  joined like '%" . $_SESSION['sess_user'] . "%' or channel_creator='".$_SESSION['sess_user']."'";
$result = $connection->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($channels, $row);
    }
}


$profile = $_SESSION['sess_user_profile_pic'];
    if (isset($_GET["emoji"]) || isset($_GET["person"]) || isset($_GET["msgid"])) {
        $emoji = $_GET["emoji"];
        $person = $_SESSION['sess_user'];
        $msgid = $_GET["msgid"];
        $msg_type = "reaction";
        $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
        $result1 = $connection->query($query);
        if ($result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
                     if($row['archived']==1){
                    $channelArchived=true;
                }
            }
        } 
        $query = "SELECT * FROM Reply WHERE msg_id='" . $msgid . "' and reply_type='" . $msg_type . "' and replied_by='" . $person . "'";
        $result = $connection->query($query);
        if (!$channelArchived) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if($row['reaction']!=$emoji){
                    $sql = "DELETE FROM Reply WHERE msg_id='" . $msgid . "' and reply_type='" . $msg_type . "' and replied_by='" . $person . "'";
                    $connection->query($sql);
                    $sql = "insert into Reply(msg_id,reply_msg,replied_by,replied_at,reaction,reply_type) values('$msgid','','$person',NOW(),'$emoji','$msg_type')";
                    if (mysqli_query($connection, $sql)) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . mysqli_error($connection);
                    }
                }
                
            }
        } 
        else{
            $sql = "insert into Reply(msg_id,reply_msg,replied_by,replied_at,reaction,reply_type) values('$msgid','','$person',NOW(),'$emoji','$msg_type')";
                    if (mysqli_query($connection, $sql)) {
                        echo "Record updated successfully2";
                    } else {
                        echo "Error updating record: " . mysqli_error($connection);
                    }
        }
    }else{
        echo "This channel is archived so you can't post or react to any post until admin unarchive this channel.";
        }
}
       if ('' != $channelSelected) {
        $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $channel_idSelected = $row['channel_id'];
                     if($row['archived']==1){
                    $channelArchived=true;
                }
            }
        } 
    } else {
        $query = "SELECT * FROM message WHERE creator_id='" . $cname . "' and channel_id='' and recipient_id='" . $_SESSION['sess_user'] . "'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($chats, $row);
            }
        }
         $query = "SELECT * FROM message WHERE creator_id='" . $_SESSION['sess_user'] . "' and channel_id='' and recipient_id='" . $cname . "'";
            $result = $connection->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($chats, $row);
                }
            }  
    }

        if (isset($_POST['message']) && !empty($_POST['message'])) {
            $message = verify_input($_POST['message']);
            $subject = $channelSelected;
            $creator_id = $_SESSION['sess_user'];
            if ($cname) {
                $channel_id = '';
                $recipient_id = $cname;
            } else {
                $channel_id = $channel_idSelected;
                $recipient_id = '';
            }
            $group_id = '';
            $image = $_SESSION['sess_image'];
            $profile_pic = $_SESSION['sess_user_profile_pic'];
            $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $channel_idSelected = $row['channel_id'];
                     if($row['archived']==1){
                    $channelArchived=true;
                }
            }
        } 
            if(!$channelArchived){
                if($_SESSION['sess_user']!='admin'){
                $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "' and joined like '%" . $_SESSION['sess_user'] . "%'";
            }else{
                $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
            }
                $result = $connection->query($query);
                if ($result->num_rows > 0) {
                        $sql = "insert into message (subject,creator_id,msg_body,create_date,channel_id,group_id,recipient_id,profile_pic,msg_type)
            values('$subject','$creator_id','$message',NOW(),'$channel_id','$group_id','$recipient_id','$profile_pic','message')";
                        if (mysqli_query($connection, $sql)) {
                            } else if (mysqli_error($connection)) {
                                echo "Error in posting a message.";
                            }
                        $_POST['message'] = '';
                }   
                    
            }
            else{
              echo   "This channel is archived so you can't post or react to any post until admin unarchive this channel.";
            }
            if($cname!=''){
                $sql = "insert into message (subject,creator_id,msg_body,create_date,recipient_id,profile_pic,msg_type)
            values('$subject','$creator_id','$message',NOW(),'$recipient_id','$profile_pic','message')";
                        if (mysqli_query($connection, $sql)) {
                            } else if (mysqli_error($connection)) {
                                echo "Error in posting a message.";
                            } 
                $_POST['message'] = '';
            }
        }
    
    if (isset($_GET['imgMsg']) && isset($_GET['ch'])  ) {
            $channel_idSelected=$_GET["ch"];
            $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $channel_idSelected = $row['channel_id'];
                     if($row['archived']==1){
                    $channelArchived=true;
                }
            }
        } 
             if(!$channelArchived){
            if($_SESSION['sess_user']!='admin'){
                $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "' and joined like '%" . $_SESSION['sess_user'] . "%'";
            }else{
                $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
            }
            $result = $connection->query($query);
            if ($result->num_rows > 0) {
                $subject = $channelSelected;
                $creator_id = $_SESSION['sess_user'];
               
                $sql = "insert into message (subject,creator_id,create_date,channel_id,msg_type,image,image_name)
        values('$subject','$creator_id',NOW(),'$channel_idSelected','imageUrl','{$_GET['imgMsg']}','image.png')";
                if (mysqli_query($connection, $sql)) {
                } else if (mysqli_error($connection)) {
                    echo "Error in posting a message.";
                }
            }
        }

        else{
          echo   "This channel is archived so you can't post or react to any post until admin unarchive this channel.";
        }
    }

    $profile = $_SESSION['sess_user_profile_pic'];
    if (isset($_POST["reply"]) && isset($_POST["reply_message"]) && isset($_GET["msg_id"])) {
        $replyMsg = $_POST["reply_message"];
        $msgid = $_GET["msg_id"];
        $msg_type = "reply";
        $replied_by = $_SESSION['sess_user'];
        $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $channel_idSelected = $row['channel_id'];
                     if($row['archived']==1){
                    $channelArchived=true;
                }
            }
        }
        
        if(!$channelArchived){
        $sql = "insert into Reply(profile_pic,msg_id,reply_msg,replied_by,replied_at,reaction,reply_type) values('$profile','$msgid','$replyMsg','$replied_by',NOW(),'','$msg_type')";
        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
    }
        else{
          echo   "This channel is archived so you can't post or react to any post until admin unarchive this channel.";
        }
        
    }

}
