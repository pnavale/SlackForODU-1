<?php 
include_once("twitter/twitteroauth.php");
define('CONSUMER_KEY', '3R3owmBJlwURYQci6SConhxmK'); // YOUR CONSUMER KEY
define('CONSUMER_SECRET', 'j2hZy9AuC1GYEImQEPx13wUas2VOnMMemIYkvtPflM6TaLSrCd'); //YOUR CONSUMER SECRET KEY 
define('OAUTH_CALLBACK', 'http://asmi92.cs518.cs.odu.edu/SlackForODU/template/twitter_login.php');  // Redirect URL 
if(isset($_GET['request']))
{
		//Fresh authentication
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
		$request_token = $connection->getRequestToken(OAUTH_CALLBACK);

		//Received token info from twitter
		$_SESSION['token'] 			= $request_token['oauth_token'];
		$_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];

		//Any value other than 200 is failure, so continue only if http code is 200
		if($connection->http_code == '200')
		{
		//redirect user to twitter
		$twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
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
			
	}
?>