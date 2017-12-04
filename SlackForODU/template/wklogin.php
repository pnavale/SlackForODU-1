<?php
include 'includes/htmlheader.php';

//require "boot.php";
//$app_id = "3R3owmBJlwURYQci6SConhxmK";
//$app_secret = "j2hZy9AuC1GYEImQEPx13wUas2VOnMMemIYkvtPflM6TaLSrCd";
//
//use Abraham\TwitterOAuth\TwitterOAuth;
//
//$twitteroauth = new TwitterOAuth($app_id,$app_secret);
//
//$twitter = new TwitterAuth($twitteroauth);
//
//if (isset($_GET['oauth_token'])) {
//    $payload = $twitter->getPayload();
//    $twitter->setPayload($payload);
//}
?>
    <div class="login-container">
        <center>
            <h4>Sign in to your workspace URL</h4>
        </center>
        <img src="../images/logo.png">
        <div class='error-msg' id="errorMsg" style="margin-left: -2%;">
            <span style="font-size:14px;"></span>
        </div>
        <br>
        <form action="verifyLogin" method="POST">
            <input type="text" class="form-control" id="workspaceName" placeholder="slack workspace url">
            <label>.slack.com</label>
            <br>
            <br>
            <input type="submit" value="Continue &#8594;" id="verifyWS" class="btn btn-success" name="submit" />

<!--
            <a href="https://github.com/login/oauth/authorize?scope=user&email&client_id=bc6659230040d5e910fb" class="btn btn-default" style="width: 100%;">
     Sign in with Github</a>
-->

<!--?php
        $data = false;
        if (isset($_SESSION['TwitterPayload'])) {
            $data = $_SESSION['TwitterPayload'];
        }

        if (!$data) {
            echo '<a class="btn btn-default" href="' . $twitter->getUrl() . '">Sign In with Twitter</a>';

        }
        else {
            $payload = $_SESSION['TwitterPayload'];
            var_dump($payload);
            echo '<br> <a href="/logout.php">Log Out!</a>';
        }
    ?-->

        </form>
    </div>
    <script type="text/javascript">
    $('#verifyWS').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'verifyWS.php',
            data: {
                workspaceName: $('#workspaceName').val()
            },
            success: function(response) {
                if (response['success']) {
                    window.location = 'login.php';
                } else {
                    $('#errorMsg span:first').html(response['message']);
                }
            }
        });
    })
    </script>
