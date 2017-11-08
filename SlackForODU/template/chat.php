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
$prevDate = '';
usort($chats, function ($a, $b) {
    return strtotime($a['create_date']) - strtotime($b['create_date']);
});

foreach ($chats as $key => $value) {
    $crfdate = date_format(new DateTime($value['create_date']), 'l, F j, Y');
    $crdate = date_format(new DateTime($value['create_date']), 'g:i a');
?>

<center>
<?php
if (strcmp($crfdate, $prevDate) > 0) {
        echo $crfdate;
        $prevDate = $crfdate;
    }
    ?>
</center>

<div class="chat-message clearfix">
<?php 
$query = "SELECT * FROM users where username='" . $value['creator_id'] . "'";
$result = $connection->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
            echo '<img width="32" height="32" src="data:image/jpeg;base64,' . base64_encode($row['image']) . '"/>';
    }
}
?>
                       <!--  <img src="../images/<?php echo $value['profile_pic'] ?>" alt="profile pic" width="32" height="32"> -->
 <div class="chat-message-content clearfix">
    <span class="chat-time"><?php echo $crdate ?></span>
    <b><?php echo ucwords($value['creator_id']); ?></b>
    <p><?php echo $value['msg_body']; ?></p>
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
    <a href="javascript:void(0);" data-href="member.php?emoji=+1&person=<?php echo $value['creator_id'] ?>&msgid=<?php echo $value['msg_id'] ?>" class="emoji">&#128077;</a><span><?php echo count($plusReaction) ?></span>
    <a href="javascript:void(0);" data-href="member.php?emoji=-1&person=<?php echo $value['creator_id'] ?>&msgid=<?php echo $value['msg_id'] ?>" class="emoji">&#x1F44E;</a><span><?php echo count($minusReaction) ?></span>
    <?php include 'replyPartial.php';?>
    </div>
    <!-- end chat-message-content -->
</div>
<!-- end chat-message -->
<hr>                  
<?php

}
?>
</div>
<!-- end chat-history -->
<!-- <p class="chat-feedback">Your partner is typing… </p>-->
    <center>
    <ul class="pagination">
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
  </ul></center>   
            <form method="post">
                <fieldset>
                    <div class="row">
                        <div class="col-sm-8 col-md-10 col-lg-10 col-xs-8">
                            <input type="text" placeholder="Type your message…" name="message" autofocus>
                        </div>
                        <div class="col-sm-4 col-md-2 col-lg-2 col-xs-4">
                            <input type="submit" value="Send" class="btn" name="submit" />
                            <!--  style="position: absolute; left: -9999px"-->
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>

        <!-- end chat -->
    </div>
    <!-- end live-chat -->



        <script type="text/javascript">
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
                url: 'chat.php',
                data: { emoji: emoji, person: person, msgid: msgid },
                success: function(response) {
                    console.log({ emoji: emoji, person: person, msgid: msgid });
                    return { emoji: emoji, person: person, msgid: msgid };
                }
            });

            // $('.emoji').css('color','#9c7248');
        })
        $('.reply').on('click', function(e) {
            e.preventDefault();
            console.log($(this).attr('id'));
            console.log($(this).attr('id'));
            var msgId = this.id.substring(3, this.id.length);
            var replyInput = 'reply' + msgId;
            var replyInput = $('#' + replyInput).val();
            console.log(replyInput);
            console.log(msgId);
            $.ajax({
                type: 'GET',
                url: 'reply.php',
                data: {
                    msg_id: msgId,
                    reply: replyInput
                },
                success: function(response) {}
            });
        });

        </script>
        <?php

mysqli_close($connection);
?>