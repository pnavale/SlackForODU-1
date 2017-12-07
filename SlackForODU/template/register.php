<?php
include 'includes/htmlheader.php';
include 'includes/db_connection.php';
include 'includes/functions.php';
session_start();
if (!$_SESSION['wkid']) {
    header("Location: wklogin.php");
}
?>
    <h2><p style="text-align:right;"><a href="register.php">Sign up</a> | <a href="login.php">Sign in</a></p></h2>
    <div class="login-container" style="width: 400px;">
        <p class="center">
            <h4>Sign up to your workspace</h4>
            <img src="../images/logo.png" alt="SlackForODU Logo"></p>
            
        <form action="" enctype="multipart/form-data"   method="POST">
            Username:
            <input type="text" class="form-control" name="user">
            <br> Password:
            <input type="password" class="form-control" name="pass">
            <br> Email ID:
            <input type="email" class="form-control" name="email">
            <br> Full Name:
            <input type="text" class="form-control" name="fullname">
            <br> Upload your profile pic:
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            <input name="userfile" type="file" />
            <br>
            <div class="g-recaptcha" data-sitekey="6Ley-TsUAAAAAMTG_2XWeKFoY-h3-nV5u1t6NjVi"></div>
            <br>
            <br>
            <input type="submit" class="btn btn-success" value="Next" name="submit" />
        </form>

        <?php
 
            // grab recaptcha library
            require_once "recaptchalib.php";

            // your secret key
            $secret = "6Ley-TsUAAAAAIQ2toBweMQlLGZJuzu070bIWInd";
 
            // empty response
            $response = null;
 
            // check secret key
            $reCaptcha = new ReCaptcha($secret);

            // if submitted check response
            if ($_POST["g-recaptcha-response"]) {
                $response = $reCaptcha->verifyResponse(
                $_SERVER["REMOTE_ADDR"],
                $_POST["g-recaptcha-response"]
                );
            }

 
        ?>
        
        <!-- <?php 
            // foreach ($_POST as $key => $value) {
            //     echo '<p><strong>' . $key.':</strong> '.$value.'</p>';
            // }
        ?> -->



        <?php
if (isset($_POST["submit"])) {
    $msg = [];
//    if (!isset($_FILES['userfile'])) {
//            echo '<p>Please select a file</p>';
//        }
    if (!empty($_POST['user']) && !empty($_POST['pass']) && !empty($_POST['email']) && !empty($_POST['fullname']) && isset($_FILES['userfile']) && $response != null && $response->success) {
            try {
                $maxsize = 10000000; //set to approx 10 MB
                    //check associated error code
                    if (UPLOAD_ERR_OK == $_FILES['userfile']['error']) {
                        //check whether file is uploaded with HTTP POST
                        if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                            //checks size of uploaded image on server side
                            if ($_FILES['userfile']['size'] < $maxsize) {
                                //checks whether uploaded file is of image type
                                //if(strpos(mime_content_type($_FILES['userfile']['tmp_name']),"image")===0) {
                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                if (strpos(finfo_file($finfo, $_FILES['userfile']['tmp_name']), "image") === 0) {
                                    // prepare the image for insertion
                                    $imgData = addslashes(file_get_contents($_FILES['userfile']['tmp_name']));
                                    $msg= 'Image successfully saved in database.';
                                    $user = verify_input(test_input($_POST['user']));
                                    $pass = verify_input(test_input($_POST['pass']));
                                    $email = verify_input(test_input($_POST['email']));
                                    $fullname = test_input($_POST['fullname']);
                                    $wk_id = $_SESSION['wkid'];
                                    if (verify_email($email)) {
                                        $query = "SELECT * FROM users WHERE username='" . $user . "' or email_id='" . $email . "'";
                                        $result = $connection->query($query);
                                        if ($result->num_rows < 1) {
                                            $result1 = $connection->query("INSERT INTO users(username,password,email_id,group_id,full_name,workspace_id,channel_id,profile_pic,signup_date,image) VALUES
                                                ('$user','$pass','$email','','$fullname','$wk_id','','{$_FILES['userfile']['name']}',NOW(),'{$imgData}')");
                                            if ($result1) {
                                                $result2 = $connection->query("SELECT * FROM channel");
                                                        $uninvited = '';
                                                if ($result2->num_rows > 0) {
                                                    while ($row = $result2->fetch_assoc()) {
                                                        $uninvited = $joined='';
                                                        $uninvited = $row['uninvited'] . "," . $user;  
                                                         if($row['channel_name']!='general' && $row['channel_name']!='random'){  
                                                            $connection->query("update channel set uninvited='".$uninvited."' where channel_name='".$row['channel_name']."'");
                                                            }

                                                            if($row['channel_name']=='general'){
                                                                $joined=$row['joined']. "," . $user;
                                                               $connection->query("update channel set joined='".$joined."' where channel_name='".$row['channel_name']."'");
                                                                }
                                                                if($row['channel_name']=='random'){
                                                                        $joined=$row['joined']. "," . $user;
                                                               $connection->query("update channel set joined='".$joined."' where channel_name='".$row['channel_name']."'");
                                                                }
                                                            }
                                                            }
                                                        }
                                                        echo "Account Successfully Created";
                                                        header("Location: member.php");
                                                    
                                                }
                                                 else {
                                                        echo "That username already exists! Please try again with another.";
                                                    }
                                            }else {
                                                echo "Invalid Email!";
                                            } 
                                } else {
                                    $msg = "Uploaded file is not an image.";
                                }
                            } else {

                                // if the file is not less than the maximum allowed, print an error
                                $msg = '<div>File exceeds the Maximum File limit</div>
                                <div>Maximum File limit is ' . $maxsize . ' bytes</div>
                                <div>File ' . $_FILES['userfile']['name'] . ' is ' . $_FILES['userfile']['size'] .
                                    ' bytes</div><hr />';
                            }
                        } else {
                            $msg = "File not uploaded successfully.";
                        }
                        } else {
                            $msg = file_upload_error_message($_FILES['userfile']['error']);
                        }
                                    echo $msg; //Message showing success or failure.
                                } catch (Exception $e) {
                                    echo $e->getMessage();
                                    echo 'Sorry, could not upload file!';
                                }
                        
                                }       
                     else {
                            echo "All fields are required!";
                        }
}
// Function to return error message based on error code

function file_upload_error_message($error_code)
{
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}        
mysqli_close($connection);
?>
    </div>
