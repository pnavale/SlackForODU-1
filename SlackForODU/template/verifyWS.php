<?php
include 'includes/db_connection.php';

$data = [
    'success' => false,
    'message' => 'Please enter your workspace url!',
];

if (!empty($_POST['workspaceName'])) {
    $url = $_POST['workspaceName'];
    $query = "SELECT * FROM workspace WHERE url='" . $url . "'";
    $result = $connection->query($query);
    //echo $numrows;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dbwkurl = $row['url'];
            $dbwk_id = $row['wk_id'];
        }
        if ($url == $dbwkurl) {
            session_start();
            $_SESSION['wkurl'] = $dbwkurl;
            $_SESSION['wkid'] = $dbwk_id;
            /* Redirect browser */
            $data['success'] = true;
            $data['message'] = 'Workspace found.';
        }
    } else {
        $data['message'] = 'We couldn’t find your workspace';
    }
}
ob_end_clean();
mysqli_close($connection);
header('Content-Type: application/json');
echo json_encode($data);