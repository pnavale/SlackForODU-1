<?php
include 'includes/db_connection.php';
include 'includes/functions.php';
session_start();
$channelArchived=false;
if ($_SESSION['sess_user']) {
    if (isset($_GET["msg_id"])) {
        if(!empty($_GET["msg_id"]) && $_GET["msg_id"]!=''){
        $replyMsg = verify_input($_GET["reply"]);
        $msgid = $_GET["msg_id"];
        $msg_type = "reply";
        $replied_by = $_SESSION['sess_user'];
        if(!empty($replyMsg)){
        if (isset($_GET["ch"])) {
            $channelSelected = $_GET['ch'];
            }
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
        $query = "SELECT * FROM Reply WHERE reply_msg='" . $replyMsg . "' and replied_by='".$replied_by."' and msg_id='".$msgid."'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
        }else{
            $sql = "insert into Reply(msg_id,reply_msg,replied_by,replied_at,reply_type) values('$msgid','$replyMsg','$replied_by',NOW(),'$msg_type')";
        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        }
    }else{
          echo   "This channel is archived so you can't post or react to any post until admin unarchive this channel.";
        }

    }
}
    }
}
?>