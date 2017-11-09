<?php

if (!isset($_SESSION)) {
    session_start();
}
include 'includes/db_connection.php';

$data = [];
$channelDetail = [];

if ($_SESSION['sess_user']) {
    $query = "SELECT * FROM channel where channel_name='" .$_GET['chDetails'] . "'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($channelDetail, $row);
        }
    }

    }

$data['channelDetail'] = $channelDetail;
ob_end_clean();
mysqli_close($connection);
header('Content-Type: application/json');
echo json_encode($data);
?>