<?php

if (!isset($_SESSION)) {
    session_start();
}
include 'includes/db_connection.php';

$data = [];
$channelDetail = [];
$msg='';
$uninvited=$invited=$joined=$uninvited1=$joined1=$invites1=$removed='';
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
     if(isset($_GET['archive'])){
        foreach ($channelDetail as $key => $value) {
            if($value['archived']==1){
                $result = $connection->query("update channel set archived=0 where channel_name='".$_GET['chDetails']."'");
                $msg="This channel is unarchived.";
            }else{
                $result = $connection->query("update channel set archived=1 where channel_name='".$_GET['chDetails']."'");
                $msg="This channel is archived.";
            }
    }
    }
    if(isset($_GET['addList'])){
    	$_GET['addList']=trim($_GET['addList']);
    	$uninvited1=str_replace($_GET['addList'], '',$uninvited);
    	$joined1=$_GET['addList'].$joined;
    	$result = $connection->query("update channel set joined='".$joined1."', uninvited='".$uninvited1."' where channel_name='".$_GET['chDetails']."'");
    	$msg="Added user to this channel.";
    }
	if(isset($_GET['inviteList'])){
		 $_GET['inviteList']=trim($_GET['inviteList']);
    	$uninvited1=str_replace($_GET['inviteList'], '',$uninvited);
    	$invites1=$_GET['inviteList'].$invited;
    	$result = $connection->query("update channel set invites='".$invites1."', uninvited='".$uninvited1."' where channel_name='".$_GET['chDetails']."'");
    	$msg="Invited user to this channel.";
    }
	if(isset($_GET['removeList'])){
		$_GET['removeList']=trim($_GET['removeList']);
    	$removed=str_replace($_GET['removeList'], '',$joined);
    	$uninvited1=$_GET['removeList'].$uninvited;
    	$result = $connection->query("update channel set joined='".$removed."', uninvited='".$uninvited1."' where channel_name='".$_GET['chDetails']."'");
    	$msg="Removed user from this channel.";
    }
}

$data['channelDetail'] = $channelDetail;
$data['uninvited'] = $uninvited1;
$data['joined']=$joined1;
$data['msg']=$msg;
// ob_end_clean();
mysqli_close($connection);
header('Content-Type: application/json');
echo json_encode($data);
?>