<?php

if (!isset($_SESSION)) {
    session_start();
}
include 'includes/db_connection.php';

$data = [];
$newchannels = [];
$channels = [];
$uninvited = [];
$members = [];
$uninvitedStr = $invitesStr = '';

if ($_SESSION['sess_user'] != 'admin') {
    $query = "SELECT * FROM channel where invites like '%" . $_SESSION['sess_user'] . "%'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($newchannels, $row);
        }
    }
    $query = "SELECT * FROM channel where channel_creator='default' or  joined like '%" . $_SESSION['sess_user'] . "%' or channel_creator='".$_SESSION['sess_user']."'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($channels, $row);
        }
    }

    $query = "SELECT * FROM users where workspace_id='" . $_SESSION['wkid'] . "'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['image'] = base64_encode($row['image']);
            array_push($members, $row);
        }
    }

    if (isset($_GET["invites"]) && isset($_GET["channelname"])) {
        foreach ($_POST['invites'] as $selectedOption) {
            $invites = $invites . "," . $selectedOption;
        }
        $uninvitedStr = str_replace($invites, '', $uninvitedStr);
        $invitesStr = $invitesStr . $invites;
        $channelname = $_GET["channelname"];
        $result1 = $connection->query("update channel invites='" . $invitesStr . "' and uninvited='" . $uninvitedStr . "' where channel_name='" . $channelname . "');
            ");
        if ($result1) {
            echo "Invites Sent.";
        } 
    }
 

    if (isset($_GET["whichChannelJoined"])) {
        $whichChannelJoined = $_GET["whichChannelJoined"];
        $currUser = $_SESSION['sess_user'];
        $inviteString = '';
        $joinedString = '';
        $query = "SELECT * FROM channel where channel_name='" . $whichChannelJoined . "' and invites like '%" . $currUser . "%'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $inviteString = $row['invites'];
                $inviteString = str_replace($currUser, "", $inviteString);
                $joinedString = $row['joined'];
                $joinedString = $joinedString . "," . $currUser;
                $sql = "update channel set joined='" . $joinedString . "' where channel_name='" . $whichChannelJoined . "'";
                if (mysqli_query($connection, $sql)) {
                    echo "Joined channel successfully";
                    $sql = "update channel set invites='" . $inviteString . "' where channel_name='" . $whichChannelJoined . "'";
                    if (mysqli_query($connection, $sql)) {
                        echo "Invite Accepted";
                    } else {
                        echo "Error deleting invite: " . mysqli_error($connection);
                    }
                }
            }
        }
    }
}else if ($_SESSION['sess_user']== 'admin') {
    // $query = "SELECT * FROM channel where invites like '%" . $_SESSION['sess_user'] . "%'";
    // $result = $connection->query($query);
    // if ($result->num_rows > 0) {
    //     while ($row = $result->fetch_assoc()) {
    //         array_push($newchannels, $row);
    //     }
    // }
    $query = "SELECT * FROM channel";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($channels, $row);
        }
    }

    $query = "SELECT * FROM users";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['image'] = base64_encode($row['image']);
            array_push($members, $row);
        }
    }

    if (isset($_GET["invites"]) && isset($_GET["channelname"])) {
        foreach ($_POST['invites'] as $selectedOption) {
            $invites = $invites . "," . $selectedOption;
        }
        $uninvitedStr = str_replace($invites, '', $uninvitedStr);
        $invitesStr = $invitesStr . $invites;
        $channelname = $_GET["channelname"];
        $result1 = $connection->query("update channel invites='" . $invitesStr . "' and uninvited='" . $uninvitedStr . "' where channel_name='" . $channelname . "');
            ");
        if ($result1) {
            echo "Invites Sent.";
        } 
    }
 

    if (isset($_GET["whichChannelJoined"])) {
        $whichChannelJoined = $_GET["whichChannelJoined"];
        $currUser = $_SESSION['sess_user'];
        $inviteString = '';
        $joinedString = '';
        $query = "SELECT * FROM channel where channel_name='" . $whichChannelJoined . "' and invites like '%" . $currUser . "%'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $inviteString = $row['invites'];
                $inviteString = str_replace($currUser, "", $inviteString);
                $joinedString = $row['joined'];
                $joinedString = $joinedString . "," . $currUser;
                $sql = "update channel set joined='" . $joinedString . "' where channel_name='" . $whichChannelJoined . "'";
                if (mysqli_query($connection, $sql)) {
                    echo "Joined channel successfully";
                    $sql = "update channel set invites='" . $inviteString . "' where channel_name='" . $whichChannelJoined . "'";
                    if (mysqli_query($connection, $sql)) {
                        echo "Invite Accepted";
                    } else {
                        echo "Error deleting invite: " . mysqli_error($connection);
                    }
                }
            }
        }
    }
}

$data['newchannels'] = $newchannels;
$data['members'] = $members;
$data['channels'] = $channels;
ob_end_clean();
mysqli_close($connection);
header('Content-Type: application/json');
echo json_encode($data);
