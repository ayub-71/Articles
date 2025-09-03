<?php

session_start();

if(isset($paths) && $paths == "../config.php"){

	$path = "../layout/css/style.css";
}
else{

	$path = "layout/css/style.css";
}

/*if($paths == "config.php"){

	$path = "layout/css/style.css";
} */

include "includes/functions.php";

if(!isset($noheader)){
	
	include "includes/templates/header.php";
}
if(!isset($nonavbar)){

	// include "includes/templates/header.php";
	include "includes/templates/navbar.php";
}

$dsn 	= "mysql:host=localhost;dbname=articles";
$user 	= "root";
$pass 	= "";

try{

	$con = new PDO($dsn, $user, $pass);
	// echo "connect successfuly";
}
catch(PDOException $e){

	echo "ERROR " . $e->getMessage();
}

define("SITE_STATUS", true);