<?php
include("includes/db_connection.php");
include("includes/functions.php");
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
  if (!isset($_SESSION)) {
        session_start();
    }
define('CONSUMER_KEY', 'CONSUMER_KEY'); // add your app consumer key between single quotes
define('CONSUMER_SECRET', 'CONSUMER_SECRET'); // add your app consumer secret key between single quotes
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
  $_SESSION["sess_user"] = $username;
  $_SESSION["twitter_user"] = 'True';
  $_SESSION['sess_user_fullname'] = $fullname;
  $_SESSION['email_id'] = $email_id;
    //https://twitter.com/TwitterEng/profile_image?size=original 
  $_SESSION['sess_user_profile_pic'] = 'https://twitter.com/'.$username.'profile_image?size=original';
  header("Location: member.php");
}
