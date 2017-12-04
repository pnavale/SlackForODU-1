<?php

function goToAuthUrl(){
	$client_id = 'bc6659230040d5e910fb';
	$redirect_url = 'http://asmi92.cs518.cs.odu.edu/SlackForODU/template/login.php';
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		$url = 'https://github.com/login/oauth/authorize?client_id='.$client_id.'&redirect_url='.$redirect_url.'&scope=user'; 
		header('location:'. $url);
	}
}


function fetchData(){
	$client_id = 'bc6659230040d5e910fb';
	$redirect_url = 'http://asmi92.cs518.cs.odu.edu/SlackForODU/template/login.php';
    $client_secret = '032a86e7b2c0257c5a4aa355a4afb462f3f8d2c1';
    if($_SERVER['REQUEST_METHOD']== 'GET'){
        if(isset($_GET['code'])){
            $code = $_GET['code'];
            $post = http_build_query(array(
                'client_id' => $client_id,
                'redirect_url' => $redirect_url,
                'client_secret' => $client_secret,
                'code' => $code,
            
            ));
        }
        $access_data = file_get_contents("https://github.com/login/oauth/access_token?".$post);
        $exploded1 = explode('access_token=',$access_data);
        $exploded2 = explode('&scope-user=',string);
        $access_token = $exploded2[0];
        $opts = ['http' => [
            'method' => 'GET',
            'header' => ['User-Agent: PHP']
        ]];
        
        //fetching user data
        $url = "https://api.github.com/user?access_token=$access_token";
        $context = stream_context_create($opts);
        $data = file_get_contents($url, false, $context);
        $user_data = json_decode($data, true);
        $username = $user_data['login'];
        
        //fetching email data
        $url1 = "https://api.github.com/user/emails?access_token=$access_token";
        $emails = file_get_contents($url1, false, $context);
        $emails = json_decode($emails, true);
        $email = $emails[0];
        
        $userPayload = [
            'username' => $username,
            'email' => $email,
            'fetched from' => "github"
        ];
        $_SESSION['payload'] = $userPayload;
        $_SESSION['user'] = $username;
        
        return $userPayload;
    }
    else{
        die('error in github login');
    }
}
?>