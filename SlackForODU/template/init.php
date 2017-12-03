<?php

function goToAuthUrl(){
	$client_id = 'bc6659230040d5e910fb';
	$redirect_url = 'http://asmi92.cs518.cs.odu.edu/SlackForODU/template/callback.php';
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		$url = 'https://github.com/login/oauth/authorize?client_id='.$client_id.'&redirect_url='.$redirect_url.'&scope=user'; 
		header('location:'. $url);
	}
}
?>