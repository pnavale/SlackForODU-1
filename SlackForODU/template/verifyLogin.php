<?php
include 'includes/db_connection.php';
session_start();

$data = [
    'success' => false,
    'message' => 'Please enter Username and Password!',
];
if (!empty($_POST['user']) && !empty($_POST['pass'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $query = "SELECT * FROM users WHERE username='" . $user . "' AND password='" . $pass . "'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            $dbfullname = $row['full_name'];
            $dbgroup_id = $row['group_id'];
            $dbworkspace_id = $row['workspace_id'];
            $dbprofile_pic = $row['profile_pic'];
            $dbchannel = $row['channel_id'];
            $dbimage = $row['image'];
        }

        if (($user == $dbusername && $pass == $dbpassword && $_SESSION['wkid'] == $dbworkspace_id) || ($user=='admin' && $pass == 'admin')) {
            $_SESSION['sess_user'] = $dbusername;
            $_SESSION['sess_user_fullname'] = $dbfullname;
            $_SESSION['sess_user_profile_pic'] = $dbprofile_pic;
            $_SESSION['sess_image'] = $dbimage;
            $_SESSION['sess_user_wk'] = $dbworkspace_id;
            $_SESSION['sess_user_ch'] = $dbchannel;
            $data['success'] = true;
            $data['message'] = 'Login Successful.';
        }
    
        if ($user == $dbusername && $pass == $dbpassword) {
            $data['message'] = "It seems you don't have an account for this workspace!";
        }
    } else {
        $data['message'] = "Invalid username or password!";
    }
}

// ob_end_clean();
mysqli_close($connection);
header('Content-Type: application/json');
echo json_encode($data);
