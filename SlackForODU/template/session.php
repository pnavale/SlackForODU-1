<?php
   include('includes/db_connection.php');
   session_start();
   
   $user_check = $_SESSION['sess_user'];
   
   $ses_sql = mysqli_query($db,"select username from users where username = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['username'];
   
   if(!isset($_SESSION['sess_user'])){
      header("location:login.php");
   }
?>