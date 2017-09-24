<?php
  include("./includes/db_connection.php");
  include("./includes/functions.php"); 
?>
<?php 
$username=$_POST['username'];
$password=$_POST['password'];
$query_users  = "SELECT * FROM users where username='$username' and password='$password";
$result_users = mysqli_query($connection, $query_users);
//$result_client3 = mysqli_query($connection, $query_client);
$login = select_users($username,$password);

if($login != null){
    echo "valid data";
}

?>
<?php
  require_once("./includes/footer.php");
?>

