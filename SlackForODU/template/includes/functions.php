<?php
include("db_connection.php");

	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	function redirect_to($new_location) {
	  	header("Location: " . $new_location);
	  	exit;
	}

	function verify_input($data) {
		global $connection;
        $data = trim($data);
  		$data = htmlspecialchars($data);
  		$data = mysqli_real_escape_string($connection,$data);
  		return $data;
    }
    	function verify_in($data) {
		global $connection;
        $data = trim($data);
  		$data = mysqli_real_escape_string($connection,$data);
  		return $data;
    }
	
	function verify_output($data) {
  		//$data = stripcslashes($data);
        $data = trim($data);
  		$data = htmlspecialchars_decode($data);
  		return $data;
    }
    	function verify_out($data) {
        $data = trim($data);
  		$data = stripcslashes($data);
  		return $data;
    }

    	function test_input($data) {
  	$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
 		 return $data;
	}

    	function verify_email($data){
      	$email = test_input($data);
      	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      	return false;
    }
    else{
      return true;
    }
}

function validate_gravatar($email) {
	// Craft a potential url and test its headers
	$hash = md5(strtolower(trim($email)));
	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$headers = @get_headers($uri);
	if (!preg_match("|200|", $headers[0])) {
		$has_valid_avatar = FALSE;
	} else {
		$has_valid_avatar = TRUE;
	}
	return $has_valid_avatar;
}

function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $valid=validate_gravatar($email);
    if($valid){
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        //$url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        //$url .= ' />';
    }
    $headers = @get_headers( $url );
    $result=preg_match( '|200|', $headers[0] ) ? true : false;
    if(!$result){
        $url="nil";
    }
    }
    return $url;
}


?>
