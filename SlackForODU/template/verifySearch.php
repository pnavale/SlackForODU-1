<?php
include 'includes/db_connection.php';
include 'includes/getCommonInfo.php';
if (!isset($_SESSION)) {
    session_start();
}
$data=$users =[];


if($_SESSION['sess_user']){
    $query = "SELECT * FROM users";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['image'] = base64_encode($row['image']);
            array_push($users, $row);
        }
    }
    
}
    


$data['users'] = $users;

// ob_end_clean();
mysqli_close($connection);
header('Content-Type: application/json');
echo json_encode($data);

?>