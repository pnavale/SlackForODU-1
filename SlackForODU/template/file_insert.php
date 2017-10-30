<?php

function upload()
{
    // include "file_constants.php";
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

                    $imageObj = [];
                    $imageObj['image'] = $imgData;
                    $imageObj['name'] = $_FILES['userfile']['name'];
                    

                    $msg= '<p>Image successfully saved in database.</p>';
                     $msg= '<p>Image successfully saved in database.</p>';
                    return $imageObj;
                } else {
                    $msg = "<p>Uploaded file is not an image.</p>";
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
    return $msg;
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
