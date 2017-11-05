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
if ($_SESSION['sess_user']) {
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
