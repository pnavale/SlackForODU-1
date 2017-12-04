<?php
include 'includes/htmlheader.php';
require_once 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
session_start();
if (!$_SESSION['wkid']) {
    header("Location: wklogin.php");
}

$config =[
    'consumer_key'      => '3R3owmBJlwURYQci6SConhxmK',
    'consumer_secret'   => 'j2hZy9AuC1GYEImQEPx13wUas2VOnMMemIYkvtPflM6TaLSrCd',
    'url_login'         => 'http://asmi92.cs518.cs.odu.edu/SlackForODU/',
    'url_callback'      => 'http://asmi92.cs518.cs.odu.edu/SlackForODU/template/callback.php',
];

// create TwitterOAuth object
$twitteroauth = new TwitterOAuth($config['consumer_key'], $config['consumer_secret']);
// request token of application
$request_token = $twitteroauth->oauth(
    'oauth/request_token', [
        'oauth_callback' => $config['url_callback']
    ]
);
// throw exception if something gone wrong
if($twitteroauth->getLastHttpCode() != 200) {
    throw new \Exception('There was a problem performing this request');
}
// save token of application to session
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
// generate the URL to make request to authorize our application
$url = $twitteroauth->url(
    'oauth/authorize', [
        'oauth_token' => $request_token['oauth_token']
    ]
);
// and redirect
header('Location: '. $url);

?>
    <br>
    <br>
    <div class="login-container">
        <center>
            <h4>Login to enter in your slack workspace</h4>
        </center>
        <img src="../images/logo.png">
        <div class='error-msg' id="errorMsg" style="margin-left: -2%;">
            <span style="font-size:14px;"></span>
        </div>
        <br>
        <form action="" method="POST">
            <input type="text" class="form-control" id="user" placeholder="username">
            <br>
            <input type="password" class="form-control" id="pass" placeholder="password">
            <br>
            <label class="checkbox normal inline_block" style="margin-left: -18%;">
                <input type="checkbox" name="remember" checked=""> Remember me</label>
            <br>
            <input type="submit" value="Sign in" class="btn btn-success" name="submit" id="verifyLogin" />
            <br>
            <br>
            <a href="register.php" class="btn btn-default" style="width: 100%;">Sign up</a>
             <br>
            <br><a href="https://github.com/login/oauth/authorize?scope=user:email&client_id=bc6659230040d5e910fb" class="btn btn-default" style="width: 100%;">
     Sign in with Github</a>
        </form>
    </div>
    <script type="text/javascript">
    $('#verifyLogin').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'verifyLogin.php',
            data: {
                user: $('#user').val(),
                pass: $('#pass').val()
            },
            success: function(response) {
                console.log('bdc');
                if (response['success']) {
                    window.location = 'member.php';
                } else {
                    $('#errorMsg span:first').html(response['message']);
                }
            }
        });
    })
    </script>
