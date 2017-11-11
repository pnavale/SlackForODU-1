<?php

if (!isset($_SESSION)) {
    session_start();
}
include 'includes/db_connection.php';

$data = [];
$channelDetail = [];
$uninvited='';
$invited='';
$joined='';

if ($_SESSION['sess_user']) {
	if(isset($_GET['chDetails'])){
    $query = "SELECT * FROM channel where channel_name='" .$_GET['chDetails'] . "'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($channelDetail, $row);
        }
    }
    foreach ($channelDetail as $key => $value) {
    		$uninvited=$value['uninvited'];
    		$invited=$value['invites'];
    		$joined=$value['joined'];
    	}
    }
    if(isset($_GET['addList'])){
    	echo strpos($uninvited,$_GET['addList']);
    	//$result = $connection->query("update channel set joined='".$_GET['addList']."' where channel_name='".$_GET['chDetails']."'");
    }
	if(isset($_GET['inviteList'])){

    }
	if(isset($_GET['removeList'])){

    }
}

$data['channelDetail'] = $channelDetail;
// ob_end_clean();
mysqli_close($connection);
header('Content-Type: application/json');
echo json_encode($data);
?>