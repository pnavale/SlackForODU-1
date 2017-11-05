<?php
session_start();
include 'includes/db_connection.php';
include 'includes/htmlheader.php';
$data = [];

$channelSelected = $_GET['ch'];
$cname = $_GET['pc'];
// if ('' == $cname) {
//     $cname = $_SESSION['sess_user'];
// }

if ($_SESSION['sess_user']) {
    $chats = [];
    $replies = [];
    if ('' != $channelSelected) {
        $query = "SELECT * FROM message m left join channel c on m.channel_id = c.channel_id AND c.channel_name='" . $channelSelected . "'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($chats, $row);
            }
        }
        foreach ($chats as  $chat) {
            $msgId = $chat['msg_id'];
            $replies = [];
            $query = "SELECT * FROM Reply WHERE msg_id='" . $msgId . "' and reply_type='reply'";
            $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        array_push($replies, $row);
                    }
                }
        }
        $chats['replies']=$replies;
    } else {
        $query = "SELECT * FROM message WHERE creator_id='" . $cname . "' and channel_id='' and recipient_id='" . $_SESSION['sess_user'] . "'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($chats, $row);
            }
            foreach ($chats as  $chat) {
            $msgId = $chat['msg_id'];
            $replies = [];
            $query = "SELECT * FROM Reply WHERE msg_id='" . $msgId . "' and reply_type='reply'";
            $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        array_push($replies, $row);
                    }
                }
        }
        $chats['replies']=$replies;

            $query = "SELECT * FROM message WHERE creator_id='" . $_SESSION['sess_user'] . "' and channel_id='' and recipient_id='" . $cname . "'";
            $result = $connection->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($chats, $row);
                }
                foreach ($chats as  $chat) {
            $msgId = $chat['msg_id'];
            $replies = [];
            $query = "SELECT * FROM Reply WHERE msg_id='" . $msgId . "' and reply_type='reply'";
            $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        array_push($replies, $row);
                    }
                }
        }
        $chats['replies']=$replies;
            }
        }
    }
}

$data['chats'] = $chats;
ob_end_clean();
mysqli_close($connection);
header('Content-Type: application/json');
echo json_encode($data);
