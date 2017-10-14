<?php
include 'includes/htmlheader.php';
include 'includes/db_connection.php';
session_start();
if(!$_SESSION['wkid']){
    header("Location: wklogin.php");
}

?>

<!doctype html>
<html>
<head>
</head>
<body>
   <h2><p style="text-align:right;"><a href="register.php">Sign up</a> | <a href="login.php">Sign in</a></p></h2>
    <br><br>
    <div class="login-container">
     <center><h4>Login to enter in your slack workspace</h4></center>
<img src="../images/logo.png">
         <div class="error-msg" style="margin-left: -2%;">
<!--            <span class="material-icons">warning</span>-->
             <span style="font-size:14px;">
        <?php
if(isset($_POST["submit"])){

if(!empty($_POST['user']) && !empty($_POST['pass'])) {
	$user=$_POST['user'];
	$pass=$_POST['pass'];

	$query=mysql_query("SELECT * FROM users WHERE username='".$user."' AND password='".$pass."'");
	$numrows=mysql_num_rows($query);
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
	$dbusername=$row['username'];
	$dbpassword=$row['password'];
    $dbfullname=$row['full_name'];
    $dbgroup_id=$row['group_id'];
    $dbworkspace_id=$row['workspace_id'];
    $dbprofile_pic=$row['profile_pic'];
    $dbchannel=$row['channel_id'];   
	}
    
        
	if($user == $dbusername && $pass == $dbpassword && $_SESSION['wkid'] == $dbworkspace_id )
	{
	$_SESSION['sess_user']=$dbusername;
    $_SESSION['sess_user_fullname']=$dbfullname;
    $_SESSION['sess_user_profile_pic']=$dbprofile_pic;
    $_SESSION['sess_user_wk']=$dbworkspace_id;
    $_SESSION['sess_user_ch']=$dbchannel;

	/* Redirect browser */
	header("Location: member.php");
	}
    if($user == $dbusername && $pass == $dbpassword){
       echo "It seems you don't have an account for this workspace!"; 
    }    
        
	} else {
	echo "Invalid username or password!";
	}

} else {
	echo "All fields are required!";
}
}
mysql_close($connection);                 
?>
             </span></div>
        <br><br>
        
<form action="" method="POST">
 <input type="text" class="form-control" name="user" placeholder="username or email id" required><br />
 <input type="password" class="form-control" name="pass" placeholder="password" required><br />	
<label class="checkbox normal inline_block" style="
    margin-left: -18%;
"><input type="checkbox" name="remember" checked=""> Remember me</label>
    <br>
<input type="submit" value="Sign in" class="btn btn-success" name="submit" />

</form>
    </div>


</body>
</html>
