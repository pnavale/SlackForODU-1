<?php
include 'includes/htmlheader.php';
?>

<!doctype html>
<html>
<head>
<title>Login</title>
    <style> 
        body{
            
    margin-top: 100px;
    margin-bottom: 100px;
    margin-right: 150px;
    margin-left: 80px;
    background-color: azure ;
    color: palevioletred;
    font-family: verdana;
    font-size: 100%;
    background: #eee url("../images/background.png");      
    
        }
            h1 {
    color: indigo;
    font-family: verdana;
    font-size: 100%;
}
        h3 {
    color: indigo;
    font-family: verdana;
    font-size: 100%;
}
  html,body{
    position: relative;
    height: 100%;
}
.login-container{
    position: relative;
    width: 300px;
    margin: 80px auto;
    padding: 20px 40px 40px;
    text-align: center;
    background: #fff;
    border: 1px solid #ccc;
}
   
 
.login-container::before,.login-container::after{
    content: "";
    position: absolute;
    width: 100%;height: 100%;
    top: 3.5px;left: 0;
    background: #fff;
    z-index: -1;
    -webkit-transform: rotateZ(4deg);
    -moz-transform: rotateZ(4deg);
    -ms-transform: rotateZ(4deg);
    border: 1px solid #ccc;
}
.login-container::after{
    top: 5px;
    z-index: -2;
    -webkit-transform: rotateZ(-2deg);
     -moz-transform: rotateZ(-2deg);
      -ms-transform: rotateZ(-2deg);
}
        
    </style>
</head>
<body>
    <h2><p style="text-align:right;"><a href="register.php">Register</a> | <a href="login.php">Login</a></p></h2>
    <br><br><br><br>
    <div class="login-container">
     <center><h4>Login to enter in your slack workspace</h4></center>
<img src="../images/logo.png">
        <br><br><br><br>
<form action="" method="POST">
 <input type="text" class="form-control" name="user" placeholder="username or email id"><br />
 <input type="password" class="form-control" name="pass" placeholder="password"><br />	
    <br><br> 
<input type="submit" value="Login" class="btn" name="submit" />
</form>
    </div>
<?php
if(isset($_POST["submit"])){

if(!empty($_POST['user']) && !empty($_POST['pass'])) {
	$user=$_POST['user'];
	$pass=$_POST['pass'];

	$con=mysql_connect('localhost','admin','M0n@rch$') or die(mysql_error());
	mysql_select_db('slack') or die("cannot select DB");

	$query=mysql_query("SELECT * FROM users WHERE username='".$user."' AND password='".$pass."'");
	$numrows=mysql_num_rows($query);
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
	$dbusername=$row['username'];
	$dbpassword=$row['password'];
    $dbworkspace_id=$row['workspace_id'];
	}
    
   global $dbwk_id;
        echo $dbwk_id;
	if($user == $dbusername && $pass == $dbpassword && $dbwk_id == $dbworkspace_id )
	{
	
	$_SESSION['sess_user']=$user;

	/* Redirect browser */
	header("Location: member.php");
	}
	} else {
	echo "Invalid username or password!";
	}

} else {
	echo "All fields are required!";
}
}
?>

</body>
</html>
