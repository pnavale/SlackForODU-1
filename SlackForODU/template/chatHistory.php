<?php
if (!isset($_SESSION)) {
    session_start();
}
$cname = 'slackbot';

$channelSelected = '';
if (isset($_GET["ch"])) {
    $cname = '';
    $channelSelected = $_GET['ch'];
}
if (isset($_GET["pc"])) {
    $channelSelected = '';
    $cname = $_GET['pc'];
}
$chats = [];
$channelObject = [];
$data=[];
if ($_SESSION['sess_user']) {
    $profile = $_SESSION['sess_user_profile_pic'];
    if (isset($_GET["emoji"]) || isset($_GET["person"]) || isset($_GET["msgid"])) {
        $emoji = $_GET["emoji"];
        $person = $_SESSION['sess_user'];
        $msgid = $_GET["msgid"];
        $msg_type = "reaction";
        $query = "SELECT * FROM Reply WHERE msg_id='" . $msgid . "' and reaction='" . $emoji . "' and replied_by='" . $person . "'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            echo "You can't like/dislike multiple times.";
        } else {
            // $sql = "DELETE FROM Reply WHERE msg_id='" . $msgid . "' and msg_type='" . $msg_type . "'";
            // if ($conn->query($sql)) {
            $sql = "insert into Reply(msg_id,reply_msg,replied_by,replied_at,reaction,reply_type) values('$msgid','','$person',NOW(),'$emoji','$msg_type')";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }
    }


       if ('' != $channelSelected) {
        $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $channel_idSelected = $row['channel_id'];
            }
        } else {
            // header("Location:wklogin.php");
        }

        $query = "SELECT * FROM message WHERE channel_id='" . $channel_idSelected . "'";
        $result = $connection->query($query);
        $chats = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($chats, $row);
            }
        } else {
            // header("Location:wklogin.php");
        }
    } else {
        $query = "SELECT * FROM message WHERE creator_id='" . $cname . "' and channel_id='' and recipient_id='" . $_SESSION['sess_user'] . "'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($chats, $row);
            }

            $query = "SELECT * FROM message WHERE creator_id='" . $_SESSION['sess_user'] . "' and channel_id='' and recipient_id='" . $cname . "'";
            $result = $connection->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($chats, $row);
                }
            }
        }
    }

        if (isset($_POST['message'])) {
        if (!empty($_POST['message'])) {
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
            $sql = "insert into message (subject,creator_id,msg_body,create_date,channel_id,group_id,recipient_id,profile_pic)
        values('$subject','$creator_id','$message',NOW(),'$channel_id','$group_id','$recipient_id','$profile_pic')";
            if (mysqli_query($connection, $sql)) {
            } else if (mysqli_error($connection)) {
                echo "Error in posting a message.";
            }
            $_POST['message'] = '';
        }

    }

    $profile = $_SESSION['sess_user_profile_pic'];
    if (isset($_POST["reply"]) && isset($_POST["reply_message"]) && isset($_GET["msg_id"])) {
        $replyMsg = $_POST["reply_message"];
        $msgid = $_GET["msg_id"];
        $msg_type = "reply";
        $replied_by = $_SESSION['sess_user'];
        $sql = "insert into Reply(profile_pic,msg_id,reply_msg,replied_by,replied_at,reaction,reply_type) values('$profile','$msgid','$replyMsg','$replied_by',NOW(),'','$msg_type')";
        if (mysqli_query($connection, $sql)) {
            echo "Record updated successfully";
            echo $profile;
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }}
    
    if ('' != $channelSelected) {
        $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $channel_idSelected = $row['channel_id'];
            }
        } else {
            // header("Location:wklogin.php");
        }

        $query = "SELECT * FROM message WHERE channel_id='" . $channel_idSelected . "'";
        $result = $connection->query($query);
        $chats = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($chats, $row);
            }
        } else {
            // header("Location:wklogin.php");
        }
    } else {
        $query = "SELECT * FROM message WHERE creator_id='" . $cname . "' and channel_id='' and recipient_id='" . $_SESSION['sess_user'] . "'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($chats, $row);
            }

            $query = "SELECT * FROM message WHERE creator_id='" . $_SESSION['sess_user'] . "' and channel_id='' and recipient_id='" . $cname . "'";
            $result = $connection->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($chats, $row);
                }
            }
        }
    }
}
