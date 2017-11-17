<?php
include 'includes/htmlheader.php';
include 'includes/db_connection.php';
include 'includes/functions.php';
session_start();
if (!isset($_SESSION["sess_user"])) {
    header("location:login.php");
}
?>
  <?php
// define variables and set to empty values
$nameErr = $purposeErr = $invitesErr = "";
$name = $purpose = $c = $invites = $chType = $channel_id = $uninvited = "";
$members = [];
if (isset($_POST["submit"])) {
    $name = verify_input($_POST['name']);
    if (!empty($name)) {
        $lowercaseName = strtolower($name);
        if (($name != $lowercaseName) || ctype_space($name) || strpos($name, '.') || strpos($name, ' ')) {
            $error = "Please enter channel name in lowercase without spaces or period.";
        } else if (($name == $lowercaseName) && !ctype_space($name) && !strpos($name, '.') && !strpos($name, ' ')) {
            if (isset($_POST['purpose'])) {
                $purpose = verify_input($_POST['purpose']);
            }

            if (isset($_POST['chType'])) {
                $chType = $_POST['chType'];
            } else {
                $chType = "public";
            }
            $query = "SELECT * FROM users where workspace_id='" . $_SESSION['wkid'] . "'";
            $result = $connection->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if($row['username']!=$_SESSION['sess_user']){
                        $uninvited=$row['username'].",";
                        array_push($members, $row);
                    }
                }
            }
            foreach ($members as $member) {
                $uninvited = $uninvited . "," . $member['username'];
            }
            if (isset($_POST['invites'])) {
                foreach ($_POST['invites'] as $selectedOption) {
                    $invites = $invites . "," . $selectedOption;
                }
            } else {
                if ("public" == $chType) {
                    $query = "SELECT * FROM users where workspace_id='" . $_SESSION['wkid'] . "'";
                    $result = $connection->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $invites = $invites . "," . $row['username'];
                        }
                    }
                }
            }
            $uninvited = str_replace($invites, '', $uninvited);

            $query = "SELECT * FROM channel where channel_name='" . $name . "'";
            $result = $connection->query($query);
            $user = $_SESSION['sess_user'];
            $wk_id = $_SESSION['wkid'];
            $joined=$_SESSION['sess_user'].",";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $error = 'This channel already exists. Please use different name to start a new channel or go to dashboard to see this channel.';
                }
            } else {
                $result1 = $connection->query("insert into channel (channel_name,channel_creator,channel_created,wk_id,channel_type,purpose,invites,uninvited)    values('$name','$user',NOW(),'$wk_id','$chType','$purpose','$invites','$uninvited');
            ");
                if ($result1) {
                    header("Location: member.php");
                } else {
                    echo mysqli_error($connection);
                }
            }
        }
    } else {
        $error = 'Please enter the channel name.';
    }
}

if (isset($_POST["cancel"])) {
    /* Redirect browser */
    header("Location: member.php");
}
?>
        <div class="login-container" style="width:600px">
            <h2>Create a Channel</h2>
            <br>
            <br>
            <p> Channels are where your members communicate. They're best when organized around a topic. E.g. <b>#foodie</b>.</p>
            <br>
            <br>
            <!--<p><span class="error">* required field.</span></p>-->
            <span class="error"><?php if (isset($error)) {echo $error;}?></span>
            <form method="POST">
                Name
                <input type="text" class="form-control" name="name" maxlength="22" placeholder="# e.g. foodie" value="<?php echo $name; ?>">
                <span class="grey-font">Names must be lowercase, without spaces or periods, and shorter than 22 characters.</span>
                <!--  <span class="error">* <?php echo $nameErr; ?></span>-->
                <br>
                <br>
                <br>
                <br> Purpose <span class="grey-font">(optional)</span>
                <input type="text" class="form-control" name="purpose" value="<?php echo $purpose; ?>">
                <span class="grey-font">What's this channel about?</span>
                <!--  <span class="error">* <?php echo $purposeErr; ?></span>-->
                <br>
                <br>
                <br>
                <br> Send invites to <span class="grey-font">(optional)</span>
                <select class="form-control" id="invites" name="invites[]" multiple="mutliple">
                    <?php
if ($_SESSION['sess_user']) {
    $query = "SELECT * FROM users where workspace_id='" . $_SESSION['wkid'] . "'";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($members, $row);
        }
    }
}
foreach ($members as $value) {
    echo "<option value='" . $value['username'] . "'>" . $value['username'] . "</option>";
}
mysqli_close($connection);
?>
                </select>
                <span class="grey-font">Select up to 10 people to add into this channel.</span>
                <!--  <span class="error"><?php echo $invitesErr; ?></span>-->
                <br>
                <br>
                <center>
                    <div class="input-group"> Channel Type
                        <span style="padding: 40px;">
<input  type="radio" name="chType"
<?php if (isset($chType) && "Private" == $chType) {
    echo "checked";
}
?>
value="private">Private</span>
                        <span style="padding: 40px;">
<input type="radio" name="chType"
<?php if (isset($chType) && "Public" == $chType) {
    echo "checked";
}
?>
value="public">Public</span>
                    </div>
                </center>
                <br>
                <br>
                <div class="btn-group" style="width:100%;">
                    <button type="submit" value="Cancel" class="btn btn-basic" name="cancel" style="width:50%;">Cancel</button>
                    <button type="submit" value="Create Channel" class="btn btn-success" name="submit" style="width:50%;">Create Channel</button>
                </div>
            </form>
        </div>
        <script type="text/javascript">
        // Return an array of the selected opion values
        // select is an HTML select element
        $('#invites').val()
        </script>