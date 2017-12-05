<?php
session_start();
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', '3R3owmBJlwURYQci6SConhxmK'); // add your app consumer key between single quotes
define('CONSUMER_SECRET', 'j2hZy9AuC1GYEImQEPx13wUas2VOnMMemIYkvtPflM6TaLSrCd'); // add your app consumer secret key between single quotes
define('OAUTH_CALLBACK', 'http://asmi92.cs518.cs.odu.edu/SlackForODU/template/callback.php'); // your app callback URL
if (!isset($_SESSION['access_token'])) {
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
  $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
  $_SESSION['oauth_token'] = $request_token['oauth_token'];
  $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
  $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
  redirect_to($url);
} else {
  $access_token = $_SESSION['access_token'];
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
  $params = array('include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true');
  $user = $connection->get("account/verify_credentials", $params);
  echo $user->screen_name;
  echo $user->profile_image_url;
  echo $user->id;
  echo $user->email;
}