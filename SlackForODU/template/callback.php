<?php
define('CONSUMER_KEY', 'YOUR CONSUMER KEY'); // YOUR CONSUMER KEY
define('CONSUMER_SECRET', 'YOUR CONSUMER SECRET KEY'); //YOUR CONSUMER SECRET KEY 
define('OAUTH_CALLBACK', 'http://localhost/login_with_twitter_using_php/index.php');  // Redirect URL 
require_once 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
session_start();
$config = $config =[
    'consumer_key'      => '3R3owmBJlwURYQci6SConhxmK',
    'consumer_secret'   => 'j2hZy9AuC1GYEImQEPx13wUas2VOnMMemIYkvtPflM6TaLSrCd',
    'url_login'         => 'http://asmi92.cs518.cs.odu.edu/SlackForODU/',
    'url_callback'      => 'http://asmi92.cs518.cs.odu.edu/SlackForODU/template/callback.php',
];
// get and filter oauth verifier
$oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');
// check tokens
if (empty($oauth_verifier) ||
    empty($_SESSION['oauth_token']) ||
    empty($_SESSION['oauth_token_secret'])
) {
    // something's missing, go and login again
    header('Location: ' . $config['url_login']);
}
// connect with application token
$connection = new TwitterOAuth(
    $config['consumer_key'],
    $config['consumer_secret'],
    $_SESSION['oauth_token'],
    $_SESSION['oauth_token_secret']
);
// request user token
$token = $connection->oauth(
    'oauth/access_token', [
        'oauth_verifier' => $oauth_verifier
    ]
);
// connect with user token
$twitter = new TwitterOAuth(
    $config['consumer_key'],
    $config['consumer_secret'],
    $token['oauth_token'],
    $token['oauth_token_secret']
);
$user = $twitter->get('account/verify_credentials');
// if something's wrong, go and log in again
if(isset($user->error)) {
    header('Location: ' . $config['url_login']);
}else{
    header('Location: ' . member.php);
}
// post a tweet
$status = $twitter->post(
    "statuses/update", [
        "status" => "You joined SlackForODU"
    ]
);
echo ('Created new status with #' . $status->id . PHP_EOL);
print_r($status);