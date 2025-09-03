<?php

$nonavbar = ""; $noheader = "";
include "../config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

		$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
		$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

		$formerrors = array();

		if(empty($username)){$formerrors[] = "username empty!";}
		if(empty($password)){$formerrors[] = "password empty!";}

		foreach($formerrors as $error){echo $error . "<br>";}

		if(empty($formerrors)){

			// sign in user into website, function select of signin;

			$table 	= "users"; 
			$where 	= "username = ? and password = ?";
			$params = array($username, sha1($password));

			$signIn = signIn($table, $where, $params);

			if($signIn){

				$_SESSION["username"] = $username;
				$_SESSION["userid"] = $signIn["userid"];

				echo "1";

				// header("location: homepage.php"); exit();

			}else{echo "0";}
		}
	}