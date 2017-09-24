<?php

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
  		$data = htmlspecialchars($data);
  		$data = mysqli_real_escape_string($connection,$data);
  		return $data;
    }
    function verify_in($data) {
		global $connection;
  		$data = mysqli_real_escape_string($connection,$data);
  		return $data;
    }
	
	function verify_output($data) {

  		$data = stripcslashes($data);
  		$data = htmlspecialchars_decode($data);
  		return $data;
    }
    function verify_out($data) {

  		$data = stripcslashes($data);
  		return $data;
    }

    function select_users($username, $password){
    global $connection;

    $query_login  = "SELECT * FROM users WHERE username = $username and password = $password" ;
    $result_login = mysqli_query($connection, $query_login);
    confirm_query($result_login);
    if($result = mysqli_fetch_assoc($result_login)) {
      echo $result;
      return $result;
    } else {
      return null;
    }
  }

//End of  Get Check Number
?>