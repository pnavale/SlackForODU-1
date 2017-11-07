<?php
include 'includes/db_connection.php';
include 'includes/getCommonInfo.php';
if (!isset($_SESSION)) {
    session_start();
}
$data=[];
$userInfo = [];
if (isset($_GET['userProfile'])) {
    $query = "SELECT * FROM users WHERE username='" . $_GET['userProfile'] . "'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['image'] = base64_encode($row['image']);
            array_push($userInfo, $row);
        }
    }
}

$channels = [];

    $query = "SELECT * FROM channel where channel_creator='default' or  joined like '%" . $_GET['userProfile'] . "%' or channel_creator='" . $_GET['userProfile'] . "'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($channels, $row);
        }
    }
    

$data['userInfo'] = $userInfo;
$data['channels'] = $channels;
ob_end_clean();
mysqli_close($connection);
header('Content-Type: application/json');
echo json_encode($data);

?>