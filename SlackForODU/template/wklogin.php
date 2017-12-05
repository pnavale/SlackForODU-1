<?php
include 'includes/htmlheader.php';
?>
    <div class="login-container">
        <center>
            <h4>Sign in to your workspace URL</h4>
        </center>
        <img src="../images/logo.png" alt="SlackForODU Logo">
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

        </form>
    </div>
    <script >
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
