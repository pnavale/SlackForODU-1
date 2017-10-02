<?php
include 'includes/htmlheader.php';
?>

<!doctype html>
<html>
<head>
<title>Register</title>
    <style>          
        
    </style>
</head>
<body>
   
<!--    <center><h2>Sign Up </h2></center>-->
   
<h2><p style="text-align:right;"><a href="register.php">Sign up</a> | <a href="login.php">Sign in</a></p></h2>
    <div class="login-container">
     <center><h2>Sign up to your workspace</h2></center>
         <br>
<img src="../images/logo.png">
        <br><br><br><br>
<form action="" method="POST">
 

        
Username: <input type="text" class="form-control" name="user"><br />
Password: <input type="password"  class="form-control" name="pass"><br />	
<input type="submit" class="btn btn-success" value="Next" name="submit" />
            
  
        
</form>
    
<?php
if(isset($_POST["submit"])){

if(!empty($_POST['user']) && !empty($_POST['pass'])) {
	$user=$_POST['user'];
	$pass=$_POST['pass'];
    //$con=mysql_connect('localhost','admin','M0n@rch$') or die(mysql_error());
	$con=mysql_connect('localhost','root','') or die(mysql_error());
	mysql_select_db('user_registration') or die("cannot select DB");

	$query=mysql_query("SELECT * FROM users WHERE username='".$user."'");
	$numrows=mysql_num_rows($query);
	if($numrows==0)
	{
	$sql="INSERT INTO users(username,password) VALUES('$user','$pass')";

	$result=mysql_query($sql);


	if($result){
	echo "Account Successfully Created";
	} else {
	echo "Failure!";
	}

	} else {
	echo "That username already exists! Please try again with another.";
	}

} else {
	echo "All fields are required!";
}
}
?>
    </div>
</body>
</html>