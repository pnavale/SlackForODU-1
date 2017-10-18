<?php
	include 'includes/htmlheader.php';
	include 'includes/db_connection.php';
?>

<!doctype html>
<html>
	
<head>
	<title>Login</title>
    	<style> 
    	</style>
</head>
	
<body>
	<h2><p style="text-align:right;"><a href="register.php">Sign up</a> | <a href="login.php">Sign in</a></p></h2>
    	<br>
    	<div class="login-container">
     	<center><h4>Sign in to your workspace URL</h4></center>
	<img src="../images/logo.png">
   <div class="error-msg" style="margin-left: -2%;">
	<!-- <span class="material-icons">warning</span>-->
        <span style="font-size:14px;">
		
  	<?php
    		global $error;
		if(isset($_POST["submit"]))
		{
			if(!empty($_POST['url']))
			{
				$url=$_POST['url'];
				$query=mysql_query("SELECT * FROM workspace WHERE url='".$url."'");
    				$numrows=mysql_num_rows($query);
    				//echo $numrows;
				if($numrows!=0)
				{
					while($row=mysql_fetch_assoc($query))
					{
						$dbwkurl=$row['url'];
						$dbwk_id=$row['wk_id'];
					}
					if($url == $dbwkurl)
					{
						session_start();
						$_SESSION['wkurl']=$dbwkurl;
    						$_SESSION['wkid']=$dbwk_id;
						/* Redirect browser */
	    					header("Location: login.php");
					}
				} else 
					{
					 echo "We couldn’t find your workspace";
   						// header("Location:wklogin.php");
					}

			} else
				{
				echo "Please enter your workspace url!";
				}
	
		}
		
		mysql_close($connection);
	?>
	</span>
    </div>
	<br>   
	<form action="" method="POST">
		<input type="text" class="form-control" name="url" placeholder="slack workspace url">
		<label>.slack.com</label>
		<br><br>
		<input type="submit" value="Continue &#8594;" class="btn btn-success" name="submit" />
	</form>
    </div>
</body>
</html>
