<!--  <meta http-equiv="refresh" content="10">   
 -->
 <?php
    //if($cname!=''){
    //    $cname=$_SESSION['sess_user'];
    //}

    $chats = array();
    $channelObject = array();
    if($_SESSION['sess_user']){
        if($channelSelected != ''){

        $query="SELECT * FROM channel WHERE channel_name='".$channelSelected."'";
        $result= $connection->query($query);
        //echo $numrows;
        if($result-> num_rows>0)
        {
        while($row=$result->fetch_assoc())
        {
        $channel_idSelected=$row['channel_id'];
    //	$msg=$row['msg_body'];
    ////    $cdate=new DateTime($row['create_date']);
    ////    $displayDate=date_format($cdate, 'h:i');
    //    array_push($chats, $row);
        }

        } else {
    //	echo "No message yet.";
       // header("Location:wklogin.php");
        }    

        $query="SELECT * FROM message WHERE channel_id='".$channel_idSelected."'";
        $result= $connection->query($query);
        $chats = array();   
        if($result-> num_rows>0)
        {
        while($row=$result->fetch_assoc())
        {
    //	$currentThread=$row['thread_id'];
    //	$msg=$row['msg_body'];
    //    $cdate=new DateTime($row['create_date']);
    //    $displayDate=date_format($cdate, 'h:i');
        array_push($chats, $row);
        }   

        } else {
    //	echo "No message yet.";
       // header("Location:wklogin.php");
        }
        }
        else{

        $query="SELECT * FROM message WHERE creator_id='".$cname."' and channel_id='' and recipient_id='".$_SESSION['sess_user']."'";
        $result= $connection->query($query);
        //echo $numrows;
        if($result-> num_rows>0)
        {
        while($row=$result->fetch_assoc())
        {
    //	$currentThread=$row['thread_id'];
    //	$msg=$row['msg_body'];
    //    $cdate=new DateTime($row['create_date']);
    //    $displayDate=date_format($cdate, 'h:i');
        array_push($chats, $row);
        }
        $query="SELECT * FROM message WHERE creator_id='".$_SESSION['sess_user']."' and channel_id='' and recipient_id='".$cname."'";
        $result= $connection->query($query);
        //echo $numrows;
        if($result-> num_rows>0)
        {
        while($row=$result->fetch_assoc())
        {
    //	$currentThread=$row['thread_id'];
    //	$msg=$row['msg_body'];
    //    $cdate=new DateTime($row['create_date']);
    //    $displayDate=date_format($cdate, 'h:i');
        array_push($chats, $row);
        }

        }
        } else {

        }

        }

      }
    ?>