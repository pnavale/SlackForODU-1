<?php


// Include config file and twitter PHP Library
include_once("config.php");
include_once("twitter/twitteroauth.php");
echo $_GET['request'];
if(isset($_GET['request']))
{
    //Fresh authentication
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
    $request_token = $connection->getRequestToken(OAUTH_CALLBACK);

    //Received token info from twitter
    $_SESSION['token']      = $request_token['oauth_token'];
    $_SESSION['token_secret']   = $request_token['oauth_token_secret'];
    echo $_SESSION['token'];
    //Any value other than 200 is failure, so continue only if http code is 200
    if($connection->http_code == '200')
    {
    echo "inside if";
    //redirect user to twitter
    $twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
    echo "inside if".$twitter_url;
    header('Location: ' . $twitter_url); 
    }else{
    die("error connecting to twitter! try again later!");
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Login with Twitter</title>

</head>
<body>
<?php
  if(isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']){

      $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['token'] , $_SESSION['token_secret']);
      $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
      if($connection->http_code == '200')
      {

        $user_data = $connection->get('account/verify_credentials'); 
        $result = '<h1>Twiiter Profile Details </h1>';
        $result .= '<img src="'.$user_data['profile_image_url'].'">';
        $result .= '<br/>Twiiter ID : ' . $user_data['id'];
        $result .= '<br/>Name : ' . $user_data['name'];
        $result .= '<br/>Twiiter Handle : ' . $user_data['screen_name'];
        $result .= '<br/>Follower : ' . $user_data['followers_count'];
        $result .= '<br/>Follows : ' . $user_data['friends_count'];
        $result .= '<br/>Logout from <a href="logout.php?logout">Twiiter</a>';
                echo '<div>'.$result.'</div>';        
      }else{
             die("error, try again later!");
      }
      
  }else{
    //Display login button
    echo '<a href="twitter_login.php?request=twitter"><img src="../images/login_button.jpg" /></a>';
  }
?>  

</body>
</html>