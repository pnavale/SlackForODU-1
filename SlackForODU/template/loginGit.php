<?php
  include("includes/db_connection.php");
  include("includes/functions.php");
    if (!isset($_SESSION)) {
        session_start();
    }
if(isset($_GET['code']))
    {
            $code = $_GET['code'];
            $post = http_build_query(array(
                'client_id' => 'bc6659230040d5e910fb',
//                'redirect_url' => 'http://localhost/SlackForODU/SlackForODU/template/loginGit.php',
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
            echo $json_data; 
            $r = json_decode($json_data , true);
            $access_token = $r['access_token'];
            $scope = $r['scope']; 
            $url = "https://api.github.com/user?access_token=".$access_token."";
            $options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
            $context  = stream_context_create($options);
            $data = file_get_contents($url, false, $context); 
            $user_data  = json_decode($data, true);
            $username = $user_data['login'];
            $fullname = $user_data['name'];
            $profile_pic=$user_data['avatar_url'];
            /*- Get User e-mail Details -*/                
            $url = "https://api.github.com/user/emails?access_token=".$access_token."";
            $options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
            $context  = stream_context_create($options);
            $emails =  file_get_contents($url, false, $context);
            $email_data = json_decode($emails, true);
            $email_id = $email_data[0]['email'];
            $email_primary = $email_data[0]['primary'];
            $email_verified = $email_data[0]['verified'];
            $query = "SELECT * from users where email_id = '".$email_id."'";
            $result = $connection->query($query);
            $row = mysqli_fetch_assoc($result);
            if ($result->num_rows > 0){
                echo $row['username'].$row['email_id'];
//                echo "User Exists";
                $_SESSION["sess_user"]=$row["username"];
                $_SESSION["username"] = $row["username"];
//                echo $_SESSION["username"];
                $_SESSION["git_user"] = 'True';
                $_SESSION["email_id"]=$email_id;
//                echo $_SESSION["git_user"];
                $_SESSION["git_image"] = 'https://github.com/'.$row["username"].'png';
//                echo $_SESSION["git_image"];
                $_SESSION['sess_user_fullname'] = $row["full_name"];
                $_SESSION['sess_user_profile_pic'] = 'https://github.com/'.$row["username"].'png';
                redirect_to("member.php");
            }
            else
            {
                echo "User do not Exists";
                $query  = "INSERT INTO users(username, full_name, email_id, signup_date,group_id, workspace_id, profile_pic) VALUES ('{$user_data['login']}', '$fullname','{$email_data[0]['email']}', NOW(),'gituser','{$_SESSION['wkid']}','$profile_pic' ) ";
                $result_id = mysqli_query($connection, $query);
                $result2 = $connection->query("SELECT * FROM channel");
                if ($result2->num_rows > 0) {
                   while ($row = $result2->fetch_assoc()) {
                     $uninvited = $row['uninvited'] . "," . $username;  
                     if($row['channel_name']!='general' && $row['channel_name']!='random'){  
                           $connection->query("update channel set uninvited='".$uninvited."' where channel_name='".$row['channel_name']."'");
                            }
                       if($row['channel_name']=='general'){
                            $joined=$row['joined']. "," . $username;
                            $connection->query("update channel set joined='".$joined."' where channel_name='".$row['channel_name']."'");
                            }
                        if($row['channel_name']=='random'){
                           $joined=$row['joined']. "," . $username;
                           $connection->query("update channel set joined='".$joined."' where channel_name='".$row['channel_name']."'");
                           }
                        }
                }
                $query = "SELECT * from users where email_id = '".$email_data[0]['email']."'";
                $result = $connection->query($query);
                if ($result->num_rows > 0)
                {
                    error_log("inside if");
                    while($row = $result->fetch_assoc()) {
                        $_SESSION["sess_user"] = $row_new["username"];
                        $_SESSION["git_user"] = 'True';
                        $_SESSION['email_id']=$email_data[0]['email'];
                        $_SESSION["sess_user_fullname"] = 'https://github.com/'.$row_new["username"].'.png';
                }
                }
                 redirect_to("member.php");
        }
        redirect_to("member.php");
    }
 ?>   