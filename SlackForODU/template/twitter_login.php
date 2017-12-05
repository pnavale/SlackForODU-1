<?php
include("includes/db_connection.php");
include("includes/functions.php");
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
  if (!isset($_SESSION)) {
        session_start();
    }
define('CONSUMER_KEY', '3R3owmBJlwURYQci6SConhxmK'); // add your app consumer key between single quotes
define('CONSUMER_SECRET', 'j2hZy9AuC1GYEImQEPx13wUas2VOnMMemIYkvtPflM6TaLSrCd'); // add your app consumer secret key between single quotes
define('OAUTH_CALLBACK', 'http://asmi92.cs518.cs.odu.edu/SlackForODU/template/callback.php'); // your app callback URL
if (!isset($_SESSION['access_token'])) {
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
  $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
  $_SESSION['oauth_token'] = $request_token['oauth_token'];
  $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
  $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
  header("Location: ".$url);
} else {
  $access_token = $_SESSION['access_token'];
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
  $params = array('include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true');
  $user = $connection->get("account/verify_credentials", $params);
  $username=$user->screen_name;
  $profile_pic=$user->profile_image_url;
  $user_id=$user->id;
  $email_id=$user->email;
  $fullname=$user->name;
  echo $username;
  // $_SESSION["username"] = $row["username"];
  // $_SESSION["twitter_user"] = 'True';
  // $_SESSION['sess_user_fullname'] = $row["full_name"];
  //   //https://twitter.com/TwitterEng/profile_image?size=original 
  // $_SESSION['sess_user_profile_pic'] = 'https://twitter.com/'.$row["username"].'profile_image?size=original';
  // header("Location: member.php");
  // $query = "SELECT * from users where email_id = '".$email_id."'";
  // echo $query;
  // $result = $connection->query($query);
  // $row = mysqli_fetch_assoc($result);
  // echo $row['username'].$row['email_id'];
  // if ($result->num_rows > 0){
  //   echo "i m here";
  //   echo $row['username'].$row['email_id'];
  //   $_SESSION["username"] = $row["username"];
  //   $_SESSION["twitter_user"] = 'True';
  //   $_SESSION['sess_user_fullname'] = $row["full_name"];
  //   //https://twitter.com/TwitterEng/profile_image?size=original 
  //   $_SESSION['sess_user_profile_pic'] = 'https://twitter.com/'.$row["username"].'profile_image?size=original';
  //   header("Location: member.php");
  //   }else {
  //       echo "User do not Exists";
  //       $query  = "INSERT INTO users(username, full_name, email_id, signup_date,group_id, workspace_id, profile_pic) VALUES ('$username', '$fullname','$email_id', NOW(),'twitteruser','{$_SESSION['wkid']}','$profile_pic' ) ";
  //       $result_id = mysqli_query($connection, $query);
  // //       $result2 = $connection->query("SELECT * FROM channel");
  // //       if ($result2->num_rows > 0) {
  // //           while ($row = $result2->fetch_assoc()) {
  // //             $uninvited = $row['uninvited'] . "," . $username;  
  // //             if($row['channel_name']!='general' && $row['channel_name']!='random'){  
  // //                $connection->query("update channel set uninvited='".$uninvited."' where channel_name='".$row['channel_name']."'");
  // //                 }
  // //             if($row['channel_name']=='general'){
  // //                $joined=$row['joined']. "," . $username;
  // //                $connection->query("update channel set joined='".$joined."' where channel_name='".$row['channel_name']."'");
  // //                }
  // //             if($row['channel_name']=='random'){
  // //                 $joined=$row['joined']. "," . $username;
  // //                 $connection->query("update channel set joined='".$joined."' where channel_name='".$row['channel_name']."'");
  // //               }
  // //       }
  // //     }
  //     $query = "SELECT * from users where email_id = '".$email_id."'";
  //     $result = $connection->query($query);
  //     if ($result->num_rows > 0) {
  //       while($row = $result->fetch_assoc()) {
  //         $_SESSION["username"] = $row["username"];
  //         $_SESSION["twitter_user"] = 'True';
  //         $_SESSION['sess_user_fullname'] = $row["full_name"];
  //         //https://twitter.com/TwitterEng/profile_image?size=original 
  //         $_SESSION['sess_user_profile_pic'] = 'https://twitter.com/'.$row["username"].'profile_image?size=original';
  //         header("Location: member.php");
  //               }
  //           }
  //               //redirect_to("member.php");
  //   }
}