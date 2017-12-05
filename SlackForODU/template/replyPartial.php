<!-- <meta http-equiv="refresh" content="10"> -->
<?php
$prevDate1 = '';
$replies = [];
if ($_SESSION['sess_user']) {
    if ('' != $channelSelected) {
        $query = "SELECT * FROM Reply WHERE msg_id='" . $value['msg_id'] . "' and reply_type='reply'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($replies, $row);
            }
        }
        usort($replies, function ($a, $b) {
            return strtotime($a['replied_at']) - strtotime($b['replied_at']);
        });

        foreach ($replies as $value) {
            $crfdate = date_format(new DateTime($value['replied_at']), 'l, F j, Y');
            $crdate = date_format(new DateTime($value['replied_at']), 'g:i a');
            ?>
    <center>
        <?php
if (strcmp($crfdate, $prevDate1) > 0) {
                echo $crfdate;
                $prevDate1 = $crfdate;
            }
            ?>
    </center>
    <div class="chat-message clearfix">
                        <?php 
           
                $query = "SELECT * FROM users where username='" . $value['replied_by'] . "'";
                $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row['image']) {
                            echo '<img width="32" height="32" src="data:image/jpeg;base64,' . base64_encode($row['image']) . '"/>';
                        } else {
                            echo "<img width='32' height='32' src='../images/" . $row['profile_pic'] . "' alt='profile pic'>";
                        }
                    }
                }
            ?>
<!--         <img src="../images/<?php echo $value['profile_pic'] ?>" alt="profile pic" width="24" height="24"> -->
        <div class="chat-message-content clearfix">
            <span class="chat-time"><?php echo $crdate ?></span>
            <b><?php echo ucwords($value['replied_by']) ?></b>
            <p>
                <?php echo $value['reply_msg']; ?>
            </p>
            <?php
            $plusReaction = [];
            $query = "SELECT * FROM Reply WHERE reply_id='" . $value['reply_id'] . "' and reaction='+1'";
            $result = $connection->query($query);
            //echo $numrows;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($plusReaction, $row);
                }
            }
            $minusReaction = [];
            $query = "SELECT * FROM Reply WHERE reply_id='" . $value['reply_id'] . "' and reaction='-1'";
            $result = $connection->query($query);
            //echo $numrows;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($minusReaction, $row);
                }
            }

            ?>
        </div>
    </div>
    <?php
}
    }
}
?>
        <form method="post">
            <fieldset>
                <div class="row">
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xs-8">
                        <input type="text" placeholder="Reply here…" id="<?php echo "reply" . $value['msg_id'] ?>" name="reply_message" autofocus>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4 col-xs-4">
                        <input type="submit" value="Reply" class="btn reply" name="reply" id="<?php echo "msg" . $value['msg_id'] ?>"/>
                        <!-- style="position: absolute; left: -9999px"-->
                    </div>
                </div>
                <!--close row div-->
            </fieldset>
        </form>
<script >
    $('.reply').on('click', function() {
            var msgId = this.id.substring(3, this.id.length);
            var replyInput = 'reply' + msgId;
            var replyInput = $('#' + replyInput).val();
            $.ajax({
                type: 'GET',
                url: 'reply.php?ch='+location.search.substring(location.search.indexOf('ch=')+3,location.search.length),
                data: {
                    msg_id: msgId,
                    reply: replyInput
                },
                success: function(response) {
                }
            });
        });
</script>
