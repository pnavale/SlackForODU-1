<?php
include 'includes/db_connection.php';
include 'includes/getCommonInfo.php';
if (!isset($_SESSION)) {
    session_start();
}
$data=[];
$userInfo = $users=$reactions=$channels =$posts =[];
$reactionPercent=$postPercent=$channelPercent=$totalPercent=0;
if (isset($_GET['userProfile'])) {
    $query = "SELECT * FROM users WHERE workspace_id='" . $_SESSION['wkid'] . "'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['image'] = base64_encode($row['image']); 
            $data['user']=$_SESSION['sess_user'];
            array_push($users, $row);
            if($row['username'] == $_GET['userProfile']){
                array_push($userInfo, $row);
            }

        }
    }
}
if (isset($_GET['userProfile']) && $_GET['userProfile']=='admin') {
    $query = "SELECT * FROM users";
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
$totalPosts=0;
$query = "SELECT * FROM message";
$result = $connection->query($query);
$totalPosts = $result->num_rows;

$totalReactions=0;
$query = "SELECT * FROM Reply";
$result = $connection->query($query);
$totalReactions = $result->num_rows;

$totalChannels=0;
$query = "SELECT * FROM channel";
$result = $connection->query($query);
$totalChannels = $result->num_rows;

$query = "SELECT * FROM message where creator_id='" . $_GET['userProfile'] . "'";
$result = $connection->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($posts, $row);
    }
}
if($totalPosts!=0){
$postPercent = round((count($posts)/$totalPosts)*100,1,PHP_ROUND_HALF_UP);
}
if($totalReactions!=0){
$reactionPercent = round((count($reactions)/$totalReactions)*100,1,PHP_ROUND_HALF_UP);
}
if($totalChannels!=0){
$channelPercent = round((count($channels)/$totalChannels)*100,1,PHP_ROUND_HALF_UP);
}

$totalPercent = round(($postPercent + $reactionPercent + $channelPercent)/3,1,PHP_ROUND_HALF_UP);
$userType='';
if($totalPercent>90){
    $userType = 'Most active user';
}else if($totalPercent>80){
    $userType = 'Active user';
}else if($totalPercent>50){
    $userType = 'Moderate active user';
}else if($totalPercent>10){
    $userType = 'Not so active user';
}else {
    $userType = 'Least active user';
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
$data['postPercent']=$postPercent;
$data['reactionPercent']=$reactionPercent;
$data['channelPercent']=$channelPercent;
$data['totalPercent']=$totalPercent;
$data['userType']=$userType;
$data['posts'] = count($posts);
ob_end_clean();
mysqli_close($connection);
header('Content-Type: application/json');
echo json_encode($data);

?>