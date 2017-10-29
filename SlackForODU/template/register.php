<?php
include 'includes/htmlheader.php';
include 'includes/db_connection.php';
include 'includes/functions.php';
session_start();
if(!$_SESSION['wkid'])
{
	header("Location: wklogin.php");
}
?>
/* Sing-up, Sign-in */
<h2><p style="text-align:right;"><a href="register.php">Sign up</a> | <a href="login.php">Sign in</a></p></h2>
    <div class="login-container" style="width: 400px;">
     <center><h4>Sign up to your workspace</h4>
     <img src="../images/logo.png"></center>
	<form action="" method="POST">       
		Username: <input type="text" class="form-control" name="user" ><br>
		Password: <input type="password"  class="form-control" name="pass" ><br>
		Email ID: <input type="email" class="form-control" name="email" ><br>
		Full Name: <input type="text"  class="form-control" name="fullname" ><br>	
		Upload your profile pic: 
    		<input type="file" name="fileToUpload" id="fileToUpload"><br>
    		<input type="submit" class="btn btn-basic" value="Upload your profile pic" name="submit"><br><br>
		<input type="submit" class="btn btn-success" value="Next" name="submit" />        
	</form>
    
<?php
if(isset($_POST["submit"]))
{
	if(!empty($_POST['user']) && !empty($_POST['pass']) && !empty($_POST['email'])  && !empty($_POST['fullname']))
	{
		$user=test_input($_POST['user']);
		$pass=test_input($_POST['pass']);
		$email=test_input($_POST['email']);
		$fullname=test_input($_POST['fullname']);
		$wk_id=$_SESSION['wkid'];
		if(verify_email($email))
		{
			$query="SELECT * FROM users WHERE username='".$user."' or email_id='".$email."'";
	 		$result= $connection->query($query);
			if($result-> num_rows<1)
			{
				$result=$connection->query("INSERT INTO users(username,password,email_id,group_id,full_name,workspace_id,channel_id,profile_pic,signup_date) VALUES('$user','$pass','$email','','$fullname','$wk_id','','',NOW())");
				if($result)
				{
					echo "Account Successfully Created";
					/* Redirect browser */
					header("Location: member.php");
				} else {
				echo mysqli_error($connection);
			}

		} else {
			echo "That username already exists! Please try again with another.";
	    	}
	  } else{
		echo "Invalid Email!";
		}
	} else {
		echo "All fields are required!";
		}
}
 mysqli_close($connection);
?>
</div>
