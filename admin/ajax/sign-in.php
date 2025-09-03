<?php

$nonavbar = "";
$paths = "../../config.php";
include $paths;

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
			$where 	= "username = ? and password = ? and groupid = ?";
			$params = array($username, sha1($password), 1);

			$signIn = signIn($table, $where, $params);

			if($signIn){

				//$checking = checking("username", "groupid", 1);

				//if(!$checking){echo "you are not an admin!";}
				
				$_SESSION["username"] = $username;
				$_SESSION["userid"] = $signIn["userid"];

				echo "1";

				// header("location: dashboard.php"); exit();

			}else{echo "0";}
		}
	}