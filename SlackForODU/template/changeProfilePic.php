<?php
include 'includes/htmlheader.php';
include 'includes/db_connection.php';
include 'includes/functions.php';
session_start();
if (!$_SESSION['wkid']) {
    header("Location: wklogin.php");
}
?>
<center>
<form action="" enctype="multipart/form-data"   method="POST">
            <br> Upload your profile pic:
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            <input name="userfile" type="file" />
            <br>
            <br>
            <input type="submit" class="btn btn-success" value="Next" name="submit" />
</form>
</center>
 <?php
if (isset($_POST["submit"])) {
    $msg = [];
    if (isset($_FILES['userfile'])) {
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
                                    $wk_id = $_SESSION['wkid'];
                                    $result = $connection->query("update users set profile_pic='".$_FILES['userfile']['name']."', image='".$imgData."' where username='".$_SESSION['sess_user']."'");
                                                    if ($result) {
                                                        echo "Account Successfully Created";
                                                        $query = "SELECT * FROM users WHERE username='" . $_SESSION['sess_user'] . "'";
                                                        $result = $connection->query($query);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                        $_SESSION['sess_image']=$row['image'];
                                                            }}
                                                        header("Location: member.php");
                                                    } else {
                                                        echo mysqli_error($connection);
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