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

?>