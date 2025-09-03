<?php

$nonavbar = "";
$paths = "../config.php";
include $paths;

if(SITE_STATUS == true){

	// include "includes/functions.php";

	if(isset($_SESSION["username"])){

		header("location: dashboard.php"); exit();
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
			$where 	= "username = ? and password = ? and groupid = ?";
			$params = array($username, sha1($password), 1);

			$signIn = signIn($table, $where, $params);

			if($signIn){

				// $checking = checking("username", "groupid", 1);

				// if(!$checking){echo "you are not an admin!";}
				
				// $_SESSION["username"] = $username;
				//$_SESSION["userid"] = $signIn["userid"];

				// header("location: dashboard.php"); exit();

			}else{echo "username or password incorrect!";}
		}
	}*/


?>

<!-- <form action="<?php //$_SERVER['PHP_SELF'] ?>" method="POST"> -->

<div id="status"></div>
	<div>
		<label for="username">username</label>
		<input type="text" name="username" id="username">
	</div>
	<div>
		<label for="password">password</label>
		<input type="password" name="password" id="password">
	</div>
	<button id="btn">sign-in</button>

	<!-- <input type="submit"> -->

<!-- </form> -->

<script src="../layout/js/jquery-3.4.1.min.js"></script>

<script>
	
	$("#btn").on("click", function(){

		var username = document.getElementById("username").value,
			password = document.getElementById("password").value;

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

				console.log(response);

			},
			error: function(){
				$("#status").html("an error occured while uploading data");
			}
		})
	})
</script>

<!--
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

				/*if(response != 0 && response != 1)$("#status").html(response);

				if(response == 0){$("#status").html("username or password incorrect!")}

				if(response == 1){
					
					window.location.href = "dashboard.php";
				} */
				
				console.log(response);
			},
			error: function(){

				$("status").text("an error occured while uploading data");
			}
		})
	})
</script> -->

<?php }else{?>

	<h1>site closed for mantenance</h1>
<?php }
?>