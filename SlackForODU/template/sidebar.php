<?php
include 'includes/db_connection.php';
?>
    <div class="row">
        <div class="col-sm-10 col-md-10 col-lg-10 col-xs-10 wkurl" style="color:#DCDCDC;font-size: 24px;">
            <?php
echo $_SESSION['wkurl'];
?>
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2 alert" style="color:#DCDCDC;">
            <span style="color:#DCDCDC;" class="material-icons" style="font-size:36px">add_alert</span>
        </div>
    </div>
    <!--notification class-->
    <div class="notification">
        <?php
$newchannels = [];
if ($_SESSION['sess_user']) {
    $query = "SELECT * FROM channel where invites like '%" . $_SESSION['sess_user'] . "%'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        echo "<div style='color:#FFFFFF;'>Invitations</div>
                  <div class='row'>";
        while ($row = $result->fetch_assoc()) {
            array_push($newchannels, $row);
        }
    } else {
        echo "<div style='color:#FFFFFF;'>&#x1f61e;No alerts.";
    }
    foreach ($newchannels as $value) {
        echo "<div class ='col-sm-6 col-md-6 col-lg-6 col-xs-6'>";
        echo "<div style='color:#FFFFFF;'>#" . $value['channel_name'] . "</div></div>";
        echo "<div class ='col-sm-6 col-md-6 col-lg-6 col-xs-6'>";
        if (!$value['channel_type']) {
            $value['channel_type'] = "public";
        }
        echo "<div><button class='join' value='" . $value['channel_name'] . "'>Join</button>";
        echo "<button class='cancelbtn' value='" . $value['channel_name'] . "'>Cancel</button></div></div>";
    }
}
?>
    </div>
    </div>
    <div class="short-profile">
        <div class="row">
            <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2" style="color:#DCDCDC;font-size: 24px;">
                <?php if($_SESSION['sess_image']){
                        echo '<img src="data:image/jpeg;base64,'.base64_encode( $_SESSION['sess_image'] ).'"/>';
                    } else {
                        echo "<img src='../images/".$_SESSION['sess_user_profile_pic']."' alt='profile pic'>";
                    }
                 ?>
            </div>
            <div class="col-sm-10 col-md-10 col-lg-10 col-xs-10" style="color:#DCDCDC;">
                <span><?php
echo $_SESSION['sess_user'];
?></span>
            </div>
        </div>
        <div class="row">
            <?php
$channels = [];
$cname = 'slackbot';
if ($_SESSION['sess_user']) {
    $query = "SELECT * FROM channel where channel_creator='default' or  joined like '%" . $_SESSION['sess_user'] . "%' and channel_type='public'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($channels, $row);
        }
    }
    foreach ($channels as $value) {
        if ("public" == $value['channel_type']) {
            echo "<div class ='col-sm-8 col-md-8 col-lg-8 col-xs-8'>";
            echo "<div style='color:#FFFFFF;'>#" . $value['channel_name'] . "</div></div>";
            echo "<div class ='col-sm-4 col-md-4 col-lg-4 col-xs-4'>";
            // if(!$value['channel_type']){
            //     $value['channel_type']="public";
            //   }
            echo "<div style='color:#FFFFFF;'>" . $value['channel_type'] . "</div></div>";
        }
    }
}
//            else {
//  echo "Something went wrong!";
//}
?>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="Channel col-sm-10 col-md-10 col-lg-10 col-xs-10" style="color:#DCDCDC;">
            <span>Channels </span>
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2">
            <a href="channel.php">
          <span style="color:#F5F5F5;" class="glyphicon glyphicon-plus-sign"></span>
        </a>
            <br>
        </div>
    </div>
    <form method="GET">
        <?php
$channels = [];
$cname = 'slackbot';
if ($_SESSION['sess_user']) {
    $query = "SELECT * FROM channel where channel_creator='default' or  joined like '%" . $_SESSION['sess_user'] . "%'";
    $result = $connection->query($query);
    //creator='".$_SESSION['sess_user']."' or
    //creator='default'
    //echo $numrows;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($channels, $row);
        }
    }

    foreach ($channels as $value) {
        echo "<a href='member.php?ch=" . $value['channel_name'] . "' name='ch' value='" . $value['channel_name'] . "'><span style='color:#FFFFFF;'>" . "#" . $value['channel_name'] . "</span><br></a>";
    }
}
//else {
//echo "Something went wrong!";
//}
?>
    </form>
    <div class="Direct Messages" style="color:#DCDCDC;">
        <br>
        <br>
        <?php
function clickPrivateChat($selectedName)
{
    $cname = $selectedName;
    return $cname;
}

?>
            <div class="row">
                <div class="col-sm-10 col-md-10 col-lg-10 col-xs-10">
                    <span>Direct Messages </span>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xs-2">
                    <a href="#">
                 <span style="color:#F5F5F5;" class="glyphicon glyphicon-plus-sign"></span></a>
                </div>
            </div>
            <form name="usersForm" method="GET" style="font-size: 20px;">
                <a href='#' name='pc' style='color:#FFFFFF;' value="slackbot"><span style='color:#f27670;'>&hearts;</span>slackbot<br></a>
                <?php
$members = [];
if ($_SESSION['sess_user']) {
    $query = "SELECT * FROM users where workspace_id='" . $_SESSION['wkid'] . "'";
    //creator='".$_SESSION['sess_user']."' or
    //creator='default'
    $result = $connection->query($query);
    //echo $numrows;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($members, $row);
        }

        foreach ($members as $value) {
            $uname = $value['username'];

            if ($value['username'] == $_SESSION['sess_user']) {
                echo "<a name='pc' href='member.php?pc=" . $value['username'] . "' class='names' style='color:#FFFFFF;' value='" . $value['username'] . "' ><span style='color:palevioletred;'>&hearts;</span>" . $value['username'] . "&nbsp;&nbsp;(you)<br></a>";
            } else {
                echo "<a name='pc' href='member.php?pc=" . $value['username'] . "' class='names' style='color:#FFFFFF;' value='" . $value['username'] . "'><span style='color:palevioletred;'>&hearts;</span>" . $value['username'] . "<br> </a>";
            }
        }
    } else {
        //echo "We couldn’t find your workspace";
        //header("Location:wklogin.php");
    }
}
//else {
//echo "Something went wrong!";
//}
?>
                    <br>
            </form>
            <?php
$channelSelected = '';
if (isset($_GET["ch"])) {
    $cname = '';
    $channelSelected = $_GET['ch'];
}
if (isset($_GET["pc"])) {
    $channelSelected = '';
    $cname = $_GET['pc'];
}
if (isset($_GET["whichChannelJoined"])) {
    $whichChannelJoined = $_GET["whichChannelJoined"];
    $currUser = $_SESSION['sess_user'];
    $inviteString = '';
    $joinedString = '';
    $query = "SELECT * FROM channel where channel_name='" . $whichChannelJoined . "' and invites like '%" . $currUser . "%'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $inviteString = $row['invites'];
            $inviteString = str_replace($currUser, "", $inviteString);
            $joinedString = $row['joined'];
            $joinedString = $joinedString . "," . $currUser;
            $sql = "update channel set joined='" . $joinedString . "' where channel_name='" . $whichChannelJoined . "'";
            if (mysqli_query($connection, $sql)) {
                echo "Joined channel successfully";
                $sql = "update channel set invites='" . $inviteString . "' where channel_name='" . $whichChannelJoined . "'";
                if (mysqli_query($connection, $sql)) {
                    echo "Invite Accepted";
                } else {
                    echo "Error deleting invite: " . mysqli_error($connection);
                }
            }
        }
    }
}

mysqli_close($connection);
?>
    </div>
    <script type="text/javascript">
    var click = 0;
    var alertClick = 0;
    $('.wkurl').click(function() {
        if (click % 2 == 0) {
            $('.short-profile').css('display', 'block');
            $('.notification').css('display', 'none');
        } else {
            $('.short-profile').css('display', 'none');
        }
        click++;

    })


    $('.alert').click(function() {
        if (alertClick % 2 == 0) {
            $('.notification').css('display', 'block');
            $('.short-profile').css('display', 'none');
        } else {
            $('.notification').css('display', 'none');
        }
        alertClick++;

    })
    $('.join').click(function() {
        var whichChannelJoined = $(this).val();
        console.log('join', whichChannelJoined);
        $.ajax({
            type: 'GET',
            url: 'member.php',
            data: { whichChannelJoined: whichChannelJoined },
            success: function(response) {
                return { whichChannelJoined: whichChannelJoined };
            }
        });
    })
    </script>