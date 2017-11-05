<?php
include 'includes/db_connection.php';
session_start();
$_SESSION['wkid'] = 'wk1';
function getAllChannels($result_set)
{
    $channels = [];
    $query = "SELECT * FROM channel where wk_id='" . $_SESSION['wkid'] . "'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($channels, $row);
        }
    }
    return $channels;
}

function getAllUsers($result_set)
{
    $users = [];
    $query = "SELECT * FROM users where wk_id='" . $_SESSION['wkid'] . "'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($users, $row);
        }
    }
    return $users;
}
