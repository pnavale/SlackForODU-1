<?php
    include 'includes/db_connection.php';
    include 'includes/functions.php';
    session_start();
    ?>
    <?php

if($_SESSION['sess_user']){ 
    echo isset($_GET["msg_id"]);
    if(isset($_GET["msg_id"])  ){
        $replyMsg=verify_input($_GET["reply"]);
        $msgid=$_GET["msg_id"];
        $msg_type="reply";
        $replied_by=$_SESSION['sess_user'];
        echo $replyMsg;
        $sql="insert into Reply(msg_id,reply_msg,replied_by,replied_at,reaction,reply_type) values('$msgid','$replyMsg','$replied_by',NOW(),'','$msg_type')";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . mysqli_error($connection);
                   }} 
}
?>
