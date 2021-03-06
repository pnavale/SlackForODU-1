<?php
include 'includes/htmlheader.php';
session_start();
if (!$_SESSION['wkid']) {
    header("Location: wklogin.php");
}
?>
    <br>
    <br>
    <div class="login-container">
        <div class="center">
            <h4>Login to enter in your slack workspace</h4>
        </div>
        <img src="../images/logo.png" alt="SlackForODU Logo">
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
     <br><br><a href="twitter_login.php" class="btn btn-default" style="width: 100%;">
     Sign in with Twitter</a>
        </form>
    </div>
    <script >
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
