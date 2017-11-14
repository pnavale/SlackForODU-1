<?php
include 'includes/db_connection.php';
include 'includes/getCommonInfo.php';
if (!isset($_SESSION)) {
    session_start();
}
$data=[];
$userInfo = $users=$reactions=$channels =[];
if (isset($_GET['userProfile'])) {
    $query = "SELECT * FROM users WHERE workspace_id='" . $_SESSION['wkid'] . "'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['image'] = base64_encode($row['image']);
            array_push($users, $row);
            if($row['username'] == $_GET['userProfile']){
                array_push($userInfo, $row);
            }
        }
    }
}

$query = "SELECT * FROM channel where channel_creator='default' or  joined like '%" . $_GET['userProfile'] . "%' or channel_creator='" . $_GET['userProfile'] . "'";
$result = $connection->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($channels, $row);
    }
}
$query = "SELECT * FROM Reply where reply_type='reaction' and replied_by='" . $_GET['userProfile'] . "'";
$result = $connection->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($reactions, $row);
    }
}


if($_SESSION['sess_user']=='admin'){
    $channel=$userInfo=[];
    $query = "SELECT * FROM users WHERE username='admin'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['image'] = base64_encode($row['image']);
            array_push($users, $row);
            if($row['username'] == $_GET['userProfile']){
                array_push($userInfo, $row);
            }
        }
    }
    $query = "SELECT * FROM channel";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($channels, $row);
            }
        }
}
    

$data['userInfo'] = $userInfo;
$data['channels'] = $channels;
$data['users'] = $users;
$data['reactions'] = $reactions;
ob_end_clean();
mysqli_close($connection);
header('Content-Type: application/json');
echo json_encode($data);

?>