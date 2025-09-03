<?php

$nonavbar = "";
$paths = "config.php";
include $paths;

if(SITE_STATUS == true){

	// include "includes/functions.php";

	if(isset($_SESSION["username"])){

		header("location: homepage.php"); exit();
	}

	/*if($_SERVER["REQUEST_METHOD"] == "POST"){

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

				header("location: homepage.php"); exit();

			}else{echo "username or password incorrect";}
		}
	}*/


?>

<div class="sign-in_page">

	<!-- <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST"> -->
		<div id="status"></div>
	<div>
		<label for="username">username</label>
		<input type="text" name="username" id="username">
	</div>
	<div>
		<label for="password">password</label>
		<input type="password" name="password" id="password">
	</div>

	<!-- <div class="submit"><input type="submit" value="sign-in"></div> -->
	<button id="btn">sign-in</button>

	<p class="not-account">you don't have an account? <a href="register.php">sign-up</a></p>

	<!-- </form> -->
</div>

<script src="layout/js/jquery-3.4.1.min.js"></script>

<script>
	
	$("#btn").on("click", function(){

		var username = document.getElementById("username").value,
			password = document.getElementById("password").value;

		// var formData = new formData();
		var formData = new FormData();

		formData.append("username", username);
		formData.append("password", password);

		$.ajax({
			type: "post",
			url: "ajax/sign-in.php",
			data: formData,
			processData: false,
			contentType: false,
			success: function(response){

				if(response != 0 && response != 1)$("#status").html(response);

				if(response == 0){$("#status").html("username or password incorrect!")}

				if(response == 1){
					
					window.location.href = "homepage.php";
				}
				
				// console.log(response);
			},
			error: function(){

				$("status").text("an error occured while uploading data");
			}
		})
	})
</script>

<?php }else{?>

	<h1>site closed for mantenance</h1>
<?php }
?>