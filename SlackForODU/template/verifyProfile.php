<?php
include 'includes/db_connection.php';
include 'includes/getCommonInfo.php';
include 'includes/functions.php';
if (!isset($_SESSION)) {
    session_start();
}
$data=[];
$userInfo = $users=$reactions=$channels =$posts =$date=$dateCount=$usersCount=$totalPost=$singleUser=[];
$reactionPercent=$postPercent=$channelPercent=$totalPercent=0;

if (isset($_GET['userProfile'])) {
    $query = "SELECT * FROM users WHERE workspace_id='" . $_SESSION['wkid'] . "'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['image'] = base64_encode($row['image']); 
            $data['user']=$_SESSION['sess_user'];
            $url=get_gravatar($row['email_id']);
            echo $url;
            if($url!=null){
                $row['gravatar_exist']=true;
                $row['gravatar']=$url;
            }
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
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['image'] = base64_encode($row['image']); 
        $row['file'] = base64_encode($row['file']); 
        array_push($totalPost, $row);
    }
}

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
        $row['image'] = base64_encode($row['image']); 
        $row['file'] = base64_encode($row['file']); 
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
$countP = $countPost=0;
$prevDate = '';
$countUser=0;
foreach ($posts as $value) {
    $crfdate = date_format(new DateTime($value['create_date']), 'F j');
     $countP++;
     $countPost++;
    if (strcmp($crfdate, $prevDate)== 0) {
        }else{
            array_push($date, $prevDate);
            array_push($dateCount, $countP);
            $countP=0;
        }

        if(count($posts)==$countPost){
            array_push($date, $crfdate);
            array_push($dateCount, $countP);
        }
        $prevDate = $crfdate;
}

foreach ($users as $value) {
        array_push($singleUser, $value['username']);
        foreach ($totalPost as $post) {
            if($value['username'] == $post['creator_id']){
                   $countUser++;
                }
        }
        array_push($usersCount,$countUser);
        $countUser=0;
        
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
$data['postsArray'] = $posts;
$data['postCountByDate'] = $dateCount;
$data['dateArray'] = $date;
$data['usersCount'] = $usersCount;
$data['chartUsers'] = $singleUser;
ob_end_clean();
mysqli_close($connection);
header('Content-Type: application/json');
echo json_encode($data);

?>