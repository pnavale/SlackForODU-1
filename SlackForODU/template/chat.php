<?php
include 'includes/db_connection.php';
include 'includes/functions.php';
include 'includes/htmlheader.php';
include 'chatHistory.php';
if (!isset($_SESSION)) {
    session_start();
}
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700">
<div id="live-chat">
<header class="clearfix">
           <!--  <a href="#" class="chat-close">x</a> -->
<h4><?php
if ($channelSelected) {
         echo "#" . $channelSelected;
} else {
    echo ucwords($cname);
}
?></h4>
            <!-- <span class="chat-message-counter">3</span> -->
</header>


<div class="chat">
    <div class="chat-history">
<?php
$channel_idSelected='';
$channelArchived=false;
if($_SESSION['sess_user']!="admin"){
 $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "' and joined like '%" . $_SESSION['sess_user'] . "%'";
}else{
    $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
}
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $channel_idSelected = $row['channel_id'];
                if($row['archived']==1){
                    $channelArchived=true;
                }
            }
        } 
$limit = 5;
if($channel_idSelected!=''){
$query = "SELECT * FROM message WHERE channel_id='" . $channel_idSelected . "'";
}
else{
 $query = "SELECT * FROM message WHERE channel_id=NULL";   
}
$result1 = mysqli_query($connection, $query);
if ($result1) {
$number = mysqli_num_rows($result1);
$totalpages = ceil($number/$limit);
// if (!isset($_GET['page'])) {
//     $page = 1;
// } else {
//     $page = $_GET['page'];
// }
if( isset($_GET['page'] ) ) {
            $page = $_GET['page'] + 1;
            $offset = $limit * $page ;
         }else {
            $page = 0;
            $offset = 0;
         }
    $left_rec = $number - ($page * $limit);
    // $first_result = ($page-1)*$limit;
    // $query = "SELECT * FROM message WHERE channel_id='" . $channel_idSelected . "' ORDER BY create_date desc LIMIT ".$first_result.", ".$limit."";
    if($channel_idSelected!=''){
    $query = "SELECT * FROM message WHERE channel_id='" . $channel_idSelected . "' ORDER BY create_date desc LIMIT ".$offset.", ".$limit."";
    }else{
    $query = "SELECT * FROM message WHERE creator_id='" . $_SESSION['sess_user'] . "' and recipient_id='" . $cname . "' ORDER BY create_date desc LIMIT ".$offset.", ".$limit.""; 
    $result = $connection->query($query);
    if ($result->num_rows <= 0) {
        $query = "SELECT * FROM message WHERE creator_id='" .$cname. "' and recipient_id='" .  $_SESSION['sess_user'] . "' ORDER BY create_date desc LIMIT ".$offset.", ".$limit.""; 
        $result = $connection->query($query);
        }
    }
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($chats, $row);
            }
    }
$prevDate = '';
usort($chats, function ($a, $b) {
    return strtotime($a['create_date']) - strtotime($b['create_date']);
});
foreach ($chats as $value) {
    $crfdate = date_format(new DateTime($value['create_date']), 'l, F j, Y');
    $crdate = date_format(new DateTime($value['create_date']), 'g:i a');
if (strcmp($crfdate, $prevDate) > 0) {
        echo "<p class='center'>".$crfdate."</p>";
        $prevDate = $crfdate;
    }
    ?>

<div class="chat-message clearfix">
<?php 
$query = "SELECT * FROM users where username='" . $value['creator_id'] . "'";
$result = $connection->query($query);
$gravatar_url= get_gravatar($row['email_id']);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // echo $row['group_id']."<br>".$row['screen_name']."<br>".$row['username'];   
            if($row['group_id']=='gituser'){
                if($row['screen_name']){
                    echo '<img width="32" height="32" src="https://github.com/'.$row['screen_name'] . '.png"/>';
                }else{
                    echo '<img width="32" height="32" src="https://github.com/'.$row['username'] . '.png"/>';
                }
            }else if($row['group_id']=='twitteruser'){
                if($row['screen_name']){
                    echo '<img width="32" height="32" src="https://twitter.com/'.$row['screen_name'].'/profile_image?size=original"/>';
                }else{
                    echo '<img width="32" height="32" src="https://twitter.com/'.$row['username'].'/profile_image?size=original"/>';
                }
                 
            }else if($gravatar_url!=null && $row['gravatar_want']==0){
                 echo '<img width="32" height="32" src="'.$gravatar_url.'"/>';
            }
            else if($row['image']){
             echo '<img width="32" height="32" src="data:image/jpeg;base64,' . base64_encode($row['image']) . '"/>';   
            }else{
                echo '<img width="32" height="32" src="../images/person.png"/>';
            }
    }
}
?>

 <div class="chat-message-content clearfix">
    <span class="chat-time"><?php echo $crdate ?></span>
    <b><?php echo ucwords($value['creator_id']); ?></b>
    <?php 
      if($value['msg_type']=='message'){
        if(substr($value['msg_body'],0,4)!='&gt;'){
          echo "<div><p>".$value['msg_body']."</p></div>";;
        }else{
            $value['msg_body']=substr($value['msg_body'],4);
            echo "<div class='vl'><blockquote><pre><code>".$value['msg_body']."</code></pre></blockquote></div>";
        }
      }  else if($value['msg_type']=='image'){
            echo "<div class='row' style='margin-left: 0;'><p>Uploaded Image:".$value['image_name']."</p>";
            echo '<img src="data:image/jpeg;base64,' . base64_encode($value['image']) . '"/></div>';
      } else if($value['msg_type']=='imageUrl'){
            // echo "<canvas style='border:1px solid grey;'' id='my_canvas".$value['msg_id']."' width='300' height='300'></canvas>";
            // echo '<script >createImage("'.$value['image_url'].'","'.$value['msg_id'].'"); </script>';
        echo "<div class='row' style='margin-left: 0;'><p>Uploaded Image:".$value['image_name']."</p>";
        echo "<img src='".$value['image_url']."'></div>";
      }else if($value['msg_type']=='file'){
        echo "<div class='row' style='margin-left: 0;'><p>Uploaded file:".$value['msg_body']."</p>";
        //echo "<p>Uploaded file type:".$value['file_type']."</p>";
        //echo "<p>Uploaded file size:".$value['file_size']."</p>";
        //echo "<a href='".$value['file']."' target='_blank'>view file</a></div>";
//        echo "<a href=''></a>";
        // echo '<object data="data:'.$value['file_type'].';base64,'.base64_encode($value['file']).'" type="'.$value['file_type'].'" style="height:200px;width:60%"></object>';
        // echo '<img src="data:'.$value['file_type'].';base64,' . base64_encode($value['file']) . '"/></div>';
           echo "<a href='../uploads/".$value['msg_body']."' target='_blank'>Download file</a></div>";
      }
     ?>
    <?php
    $plusReaction = [];
    $query = "SELECT * FROM Reply WHERE msg_id='" . $value['msg_id'] . "' and reaction='+1'";
    $result = $connection->query($query);
    //echo $numrows;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($plusReaction, $row);
        }
    }
    $minusReaction = [];
    $query = "SELECT * FROM Reply WHERE msg_id='" . $value['msg_id'] . "' and reaction='-1'";
    $result = $connection->query($query);
    //echo $numrows;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($minusReaction, $row);
        }
    }
    ?>
    <div class="row">
    <a href="javascript:void(0);" data-href="member.php?emoji=+1&person=<?php echo $value['creator_id'] ?>&msgid=<?php echo $value['msg_id'] ?>" class="emoji">&#128077;</a><span><?php echo count($plusReaction) ?></span>
    <a href="javascript:void(0);" data-href="member.php?emoji=-1&person=<?php echo $value['creator_id'] ?>&msgid=<?php echo $value['msg_id'] ?>" class="emoji">&#x1F44E;</a><span><?php echo count($minusReaction) ?></span>
    &nbsp;&nbsp;
    <?php if($_SESSION['sess_user']=='admin'){
    echo "<a href='javascript:void(0);' data-href='member.php?msgid=".$value['msg_id']."' class='delete'>Delete</a>";} ?>
    <?php include 'replyPartial.php';?>
    </div>
    </div>
    <!-- end chat-message-content -->
</div>
<!-- end chat-message -->
<hr>                 
<?php
}
$final=$totalpages-2;
if( $page > 0 && $left_rec > $limit) {
            echo '<ul class="pagination text-center" id="pagination"> ';
            $last = $page - 2;
            echo "<li class='page' id='-1'><a href='javascript:void(0);'>First Page</a></li>";
            echo "<li class='page' id='".$last."'><a href='javascript:void(0);'>Last 5 Records</a></li> ";
            echo "<li class='page' id='".$page."'><a href='javascript:void(0);'>Next 5 Records</a></li>";
            echo "<li class='page' id='".$final."'><a href='javascript:void(0);'>Last Page</a></li>";
            echo "</ul>";
         }else if( $page == 0 && $left_rec<=5) {
        
         }else if( $page == 0 && $left_rec!=0) {
            echo '<ul class="pagination text-center" id="pagination"> ';
            echo "<li class='page' id='".$page."'><a href='javascript:void(0);'>Next 5 Records</a></li>";
            echo "<li class='page' id='".$final."'><a href='javascript:void(0);'>Last Page</a></li>";
            echo "</ul>";
         }
         else if( $left_rec <= $limit && $left_rec!=0) {
            $last = $page - 2;
            echo '<ul class="pagination text-center" id="pagination">';
            echo "<li class='page' id='-1'><a href='javascript:void(0);'>First Page</a></li>";
            echo "<li class='page' id='".$last."'><a href='javascript:void(0);'>Previous 5 Records</a></li>";
            echo "</ul>";
         }       
} 
?>

</div>
    <!-- end chat-history -->
<!-- <p class="chat-feedback">Your partner is typing… </p>-->
<form method="post">
    <fieldset>
        <div class="row">
            <div class="col-sm-8 col-md-10 col-lg-10 col-xs-8">
                <div class="row">
                    <div class="col-sm-2 col-md-1 col-lg-1 col-xs-2 code-add">
                        <img src="../images/code-snippet.png">
                    </div>
                    <div class="col-sm-2 col-md-1 col-lg-1 col-xs-2 img-add" onclick="on()" >
                        <img src="../images/img-icon.png">
                    </div>
                    <div class="col-sm-8 col-md-10 col-lg-10 col-xs-8">
                            <?php 
                            if($result1==true){
                            echo '<input type="text" placeholder="Type your message…" name="message" class="input-msg" autofocus>';
                            }else{
                            echo '<input type="text" placeholder="Type your message…" name="message" class="input-msg" disabled>';
                            }
                            ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-2 col-lg-2 col-xs-4">
                <input type="submit" value="Send" class="btn msg" name="submit" />
            </div>
        </div>
    </fieldset>
</form>
</div>

        <!-- end chat -->
    </div>
    <!-- end live-chat -->
<div class="overlay1">
    <div style="background-color: white;height:auto;">
     <h3>File Upload</h3><br><br>
    <form method="post" enctype="multipart/form-data">
    <input type="file" name="file" class="file-upload"/><br><br>
    <div id="thumb-output1"></div>
    <input type="submit" class="btn btn-success" value="Upload" name="btn-upload" style="width:10%;" />
     <input type="button" class="btn btn-default" value="Cancel" style="width:10%;" onclick="off()" />
    </form>
    </div>
</div>
    <div class="overlay">
    <div style="background-color: white;height:250px;">
     <h3>Image Upload</h3><br><br>
    <div id="tabs">
  <ul>
    <li><a href="#tabs-1">Local Image Upload</a></li>
    <li><a href="#tabs-2">Web Image Upload</a></li>
  </ul>
  <div id="tabs-1">
      <form action="" enctype="multipart/form-data" method="POST" >
                <br> Upload your image here:
                <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                <input name="userfile1" type="file"  id="file-input" />
                <br>
                <br>
                <input type="submit" class="btn btn-success" value="Next" name="img" style="width:30%;" /><br>
                <input type="button" class="btn btn-default" value="Cancel" style="width:30%;" onclick="off()" />
                <div id="thumb-output"></div>
    </form>
  </div>
  <div id="tabs-2">
  <h3>Web Image Upload</h3>
    <p>1. Copy image data into clipboard or press Print Screen <br></p>
    <p>2. Press Ctrl+V or paste in the input field:</p>
    <br><br>
<!--     <canvas style="border:1px solid grey;" id="my_canvas" width="300" height="300"></canvas></center>
--><form method="post">   
 <input name="webupload" id="web-upload" type="text" style="border:  1px solid;" />
    <br><br>
    <input type="submit" class="btn btn-success" value="Next" name="webimg" id="web-img" style="width:30%;" /><br>
    <input type="button" class="btn btn-default" value="Cancel" style="width:30%;" onclick="off()" />
    </form>
      <img src="" class="preview" />
  </div>
</div>
</div>
</div>

<script>
$(".page").on('click',function(e){
 //e.preventDefault();
 console.log("i m here");
 var ch = location.search.substring(4,location.search.length);
 console.log(ch);
 $("#live-chat").html('loading...');
 $("#pagination a").removeClass('active');
 $(this).addClass('active');
        var pageNum = this.id;
        //window.location.replace("member.php?ch="+ch+"&page=" + pageNum);
        $.ajax({
            type: 'GET',
            url: "chat.php?ch="+ch+"&page=" + pageNum,
            success: function(response) {
                   jQuery("#live-chat").load("chat.php?ch="+ch+"&page=" + pageNum);
                }
            });
    });

$('#file-input').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#thumb-output').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data
            
            $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element 
                        $('#thumb-output').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
            
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
    });
$('.file-upload').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#thumb-output1').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data
            
            $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img width="128" height="128"/>').addClass('thumb').attr('src', e.target.result); //create image element 
                        $('#thumb-output1').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
            
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
    });
$('[name="webupload"]').on('change', function() {
     $('img.preview').prop('src', this.value);
});
</script>

<?php
 // function isImage( $url )
 //  {
 //    $pos = strrpos( $url, ".");
 //    if ($pos === false)
 //      return false;
 //    $ext = strtolower(trim(substr( $url, $pos)));
 //    $imgExts = array(".gif", ".jpg", ".jpeg", ".png", ".tiff", ".tif"); // this is far from complete but that's always going to be the case...
 //    if ( in_array($ext, $imgExts) )
 //      return true;
 //    return false;
 //  }
if(isset($_POST['btn-upload']))
{    
     
    $file = rand(1000,100000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder="../uploads/";
    
    // new file size in KB
    $new_size = $file_size/1024;  
    // new file size in KB
    
    // make file name in lower case
    $new_file_name = strtolower($file);
    // make file name in lower case
    $final_file=str_replace(' ','-',$new_file_name);
    $fileData = addslashes(file_get_contents($_FILES['file']['tmp_name']));
    $creator_id = $_SESSION['sess_user'];
     if(substr($file_type,0,5)=='image'){
        $imgData = addslashes(file_get_contents($_FILES['file']['tmp_name']));
        $result=$connection->query("insert into message (image_name,channel_id,image,creator_id,create_date,msg_type,subject)values ('{$_FILES['file']['name']}','$channel_idSelected','{$imgData}','{$_SESSION['sess_user']}',NOW(),'image','$channelSelected')");
        $msg= 'Image successfully saved in database.';
        if ($result) {} else {
         echo mysqli_error($connection);
           } 
        }else if(move_uploaded_file($file_loc,$folder.$final_file))
    {
        $sql="INSERT INTO message(creator_id,create_date,channel_id,msg_type,msg_body,file_type,file_size, file) VALUES('$creator_id',NOW(),'$channel_idSelected','file','$final_file','$file_type','$new_size','$fileData')";
        if(mysqli_query($connection, $sql)){
        }else if (mysqli_error($connection)) {
                echo "Error in posting a message.". mysqli_error($connection);
            }
    }
    
}
    if (isset($_POST['webimg']) && isset($_POST['webupload'])) {
        if(!$channelArchived){
            if($_SESSION['sess_user']!='admin'){
                $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "' and joined like '%" . $_SESSION['sess_user'] . "%'";
            }else{
                $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
            }
            $result = $connection->query($query);
            if ($result->num_rows > 0) {
                $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
                $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                            $channel_idSelected = $row['channel_id'];
                    }
                } 
            $subject = $channelSelected;
            $creator_id = $_SESSION['sess_user'];
            $sql = "insert into message (subject,creator_id,create_date,channel_id,msg_type,image_url,image_name)
        values('$subject','$creator_id',NOW(),'$channel_idSelected','imageUrl','{$_POST['webupload']}','image.png')";
            if (mysqli_query($connection, $sql)) {
            } else if (mysqli_error($connection)) {
                echo "Error in posting a message.";
            }
        }
    }
        else{
          echo "This channel is archived so you can't post or react to any post until admin unarchive this channel.";
        }
    }
if (isset($_POST["img"])) {
    if (isset($_FILES['userfile1'])) {
            try {
                $maxsize = 10000000; //set to approx 10 MB
                    //check associated error code
                    if (UPLOAD_ERR_OK == $_FILES['userfile1']['error']) {
                        //check whether file is uploaded with HTTP POST
                        if (is_uploaded_file($_FILES['userfile1']['tmp_name'])) {
                            //checks size of uploaded image on server side
                            if ($_FILES['userfile1']['size'] < $maxsize) {
                                //checks whether uploaded file is of image type
                                //if(strpos(mime_content_type($_FILES['userfile']['tmp_name']),"image")===0) {
                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                if (strpos(finfo_file($finfo, $_FILES['userfile1']['tmp_name']), "image") === 0) {
                                    // prepare the image for insertion
                                    $imgData = addslashes(file_get_contents($_FILES['userfile1']['tmp_name']));
                                    $msg='';
                                   if(!$channelArchived){
                                    if($_SESSION['sess_user']!='admin'){
                                        $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "' and joined like '%" . $_SESSION['sess_user'] . "%'";
                                        }else{
                                            $query = "SELECT * FROM channel WHERE channel_name='" . $channelSelected . "'";
                                        }
                                        $result = $connection->query($query);
                                        if ($result->num_rows > 0) {
                                        $result=$connection->query("insert into message (image_name,channel_id,image,creator_id,create_date,msg_type,subject)values ('{$_FILES['userfile1']['name']}','$channel_idSelected','{$imgData}','{$_SESSION['sess_user']}',NOW(),'image','$channelSelected')");
                                                $msg= 'Image successfully saved in database.';
                                                    if ($result) {
                                       
                                                    } else {
                                                        echo mysqli_error($connection);
                                                    }  
                                }
                            }
                                else{
                                    $msg = "This channel is archived so you can't post or react to any post until admin unarchive this channel.";
                                }
                                } else {
                                    $msg = "Uploaded file is not an image.";
                                }
                            } else {
                                // if the file is not less than the maximum allowed, print an error
                                $msg = '<div>File exceeds the Maximum File limit</div>
                                <div>Maximum File limit is ' . $maxsize . ' bytes</div>
                                <div>File ' . $_FILES['userfile1']['name'] . ' is ' . $_FILES['userfile1']['size'] .
                                    ' bytes</div><hr />';
                            }
                        } else {
                            $msg = "File not uploaded successfully.";
                        }
                        } else {
                            $msg = file_upload_error_message($_FILES['userfile1']['error']);
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
?>

        <script >
        $( function() {
    $( "#tabs" ).tabs();
  } );
        function on() {
            $('.overlay').css('display','block');
        }
        function off() {
            $('.overlay').css('display','none');
            $('.overlay1').css('display','none');
            window.location.reload();
        }
        var pageId="page"+location.search.substring(location.search.indexOf('page=')+5,location.search.length);
            $('#'+pageId).addClass('active');
                $('.code-add').on('click', function(e) {
                });
             $('.img-add').on('click', function(e) {
                });
            $('.delete').on('click', function(e) {
            var data = $(this).data('href');
            var msgid = data.substring(data.search('msgid=') + 6, data.length);
            console.log(msgid);
            $.ajax({
                type: 'GET',
                url: 'chatHistory.php?ch='+location.search.substring(location.search.indexOf('ch=')+3,location.search.length),
                data: { deleteMsg: msgid },
                success: function(response) {
                    window.location.reload();
                }
            });
        })
     /*    $('.msg').on('click', function(e) {
            console.log($('.input-msg').val());
            var msg = $('.input-msg').val();
            $.ajax({
                type: 'GET',
                url: 'chatHistory.php',
                data: { msg: msg },
                success: function(response) {
                    console.log({ msg: msg });
                    window.location.reload(true);
                    return { msg: msg };
                }
            });
        })*/
        $('.emoji').on('click', function(e) {
            console.log($(this).data('href'));
            var data = $(this).data('href');
            // member.php?emoji=+1&person=mater&msgid=8
            var url = data.substring(0, 10);
            var emoji = data.substring(17, 19);
            var msgid = data.substring(data.search('msgid=') + 6, data.length);
            var person = data.substring(27, data.search('&msgid='));
            $.ajax({
                type: 'GET',
                url: 'chatHistory.php?ch='+location.search.substring(location.search.indexOf('ch=')+3,location.search.length),
                data: { emoji: emoji, person: person, msgid: msgid },
                success: function(response) {
                    window.location.reload();
                }
            });
            // $('.emoji').css('color','#9c7248');
        })
    
    $('.code-add').on('click', function(e) {
    $('.overlay1').css('display','block');
 })
   // var CLIPBOARD = new CLIPBOARD_CLASS("my_canvas", true);
/**
 * image pasting into canvas
 * 
 * @param {string} canvas_id - canvas id
 * @param {boolean} autoresize - if canvas will be resized
 */
function CLIPBOARD_CLASS(canvas_id, autoresize) {
  var _self = this;
  var canvas = document.getElementById(canvas_id);
  var ctx = document.getElementById(canvas_id).getContext("2d");
  //handlers
  document.addEventListener('paste', function (e) { _self.paste_auto(e); }, false);
  //on paste
  this.paste_auto = function (e) {
    if (e.clipboardData) {
        console.log(e.clipboardData);
      var items = e.clipboardData.items;
      if (!items) return;
      
      //access data directly
      for (var i = 0; i < items.length; i++) {
        if (items[i].type.indexOf("image") !== -1) {
          //image
          var blob = items[i].getAsFile();
          console.log(blob);
          var URLObj = window.URL || window.webkitURL;
          var source = URLObj.createObjectURL(blob);
          var imgPaste=$('.img-paste').val();
          console.log(source);
          this.paste_createImage(source);
        }
      }
      e.preventDefault();
    }
  };
  //draw pasted image to canvas
  this.paste_createImage = function (source) {
    var pastedImage = new Image();
         $.ajax({
                type: 'GET',
                url: 'chatHistory.php?ch='+location.search.substring(location.search.indexOf('ch=')+3,location.search.length),
                data: {
                    imgMsg: pastedImage
                },
                success: function(response) {},
                cache: false,
            contentType: false,
            processData: false
            });
    pastedImage.onload = function () {
      if(autoresize == true){
        //resize
        canvas.width = pastedImage.width;
        canvas.height = pastedImage.height;
      }
      else{
        //clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);
      }
      ctx.drawImage(pastedImage, 0, 0);
    };
    pastedImage.src = source;
  };
}
        </script>
        <?php
mysqli_close($connection);
?>
