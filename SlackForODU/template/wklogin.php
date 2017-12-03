<?php
include 'includes/htmlheader.php';
include 'includes/db_connection.php';
include 'includes/functions.php';
$_GET['code']='05cc187ee8e255087f44';
if(isset($_GET['code']))
    {
            $code = $_GET['code'];
            $post = http_build_query(array(
                'client_id' => 'bc6659230040d5e910fb',
                'redirect_url' => 'http://asmi92.cs518.cs.odu.edu/SlackForODU/template/loginGit.php',
                'client_secret' => '032a86e7b2c0257c5a4aa355a4afb462f3f8d2c1',
                'code' => $code,
            ));
            $context = stream_context_create(
                array(
                    "http" => array(
                        "method" => "POST",
                        'header'=> "Content-type: application/x-www-form-urlencoded\r\n" .
                                    "Content-Length: ". strlen($post) . "\r\n".
                                    "Accept: application/json" ,  
                        "content" => $post,
                    )
                )
            );
            $json_data = file_get_contents("https://github.com/login/oauth/access_token", false, $context);
            $r = json_decode($json_data , true);
            $access_token = $r['access_token'];
            $scope = $r['scope']; 
            $url = "https://api.github.com/user?access_token=".$access_token."";
            $options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
            $context  = stream_context_create($options);
            $data = file_get_contents($url, false, $context); 
            $user_data  = json_decode($data, true);
            $username = $user_data['login'];
            $username_1 = $user_data['login'];
            /*- Get User e-mail Details -*/                
            $url = "https://api.github.com/user/emails?access_token=".$access_token."";
            $options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
            $context  = stream_context_create($options);
            $emails =  file_get_contents($url, false, $context);
            $email_data = json_decode($emails, true);
            $email_id = $email_data[0]['email'];
            $email_primary = $email_data[0]['primary'];
            $email_verified = $email_data[0]['verified'];
            $result = git_validate_user($username);
            $row = mysqli_fetch_assoc($result);
            if ($row["username"] != NULL)
            {
                //echo "User Exists";
                //$_SESSION["uid"] = (int)$row["u_id"];
                //echo $_SESSION["uid"];
                $_SESSION["username"] = $row["username"];
                //echo $_SESSION["username"];
                $_SESSION["git_user"] = 'True';
                //echo $_SESSION["git_user"];
                $_SESSION["git_image"] = 'https://github.com/'.$row["username"].'png';
                //echo $_SESSION["git_image"];
                redirect_to("member.php");
            }
            else
            {
                //echo "User do not Exists";
                $query  = "INSERT INTO users(username, email_id, signup_date,group_id) VALUES ('{$user_data['login']}', '{$email_data[0]['email']}', NOW(),'gituser') ";
                $result_id = mysqli_query($connection, $query);
                $result_new = git_validate_user($user_data['login']);
                $row_new = mysqli_fetch_assoc($result_new);
                if ($row_new["username"] != NULL)
                {
                    //$_SESSION["uid"] = (int)$row_new["u_id"];
                  //  echo $_SESSION["uid"];
                    $_SESSION["username"] = $row_new["user_id"];
                  //  echo $_SESSION["username"]; 
                    $_SESSION["git_user"] = 'True';
                   // echo $_SESSION["git_user"];
                    $_SESSION["git_image"] = 'https://github.com/'.$row_new["username"].'.png';
                   // echo $_SESSION["git_image"];
                   redirect_to("member.php");
                }
    }
    }
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
