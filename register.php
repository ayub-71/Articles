<?php

include "config.php";
// include "includes/functions.php";

if(SITE_STATUS == true){

	if(isset($_SESSION["username"])){

		header("location: homepage.php"); exit();
	}

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$username 			= filter_var($_POST["username"], FILTER_SANITIZE_STRING);
		$email 				= filter_var($_POST["email"], FILTER_SANITIZE_STRING);
		$password 			= filter_var($_POST["password"], FILTER_SANITIZE_STRING);
		$confirmPassword 	= filter_var($_POST["confirmPassword"], FILTER_SANITIZE_STRING);

		$formerrors = array();

		if(empty($username)){$formerrors[] 			= "username empty!";}
		if(empty($email)){$formerrors[] 			= "email empty!";}
		if(empty($password)){$formerrors[] 			= "password empty!";}
		if(empty($confirmPassword)){$formerrors[] 	= "confirmPassword empty!";}

		foreach($formerrors as $error){echo $error . "<br>";}

		if(empty($formerrors)){

			if($password !== $confirmPassword){echo "password not match!";}else{

				$usernameChecking 	= checking("username", "username", $username);
				$emailChecking 		= checking("email", "email", $email);

				if(!$usernameChecking && !$emailChecking){

					$signUp = signUp($username, $email, $password);

					if($signUp){

						$message = "congratulations! You've successfully registred";
						redirect($message, 3, "sign-in.php");
					}
				}
			}
		}
	}


?>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">

	<div>
		<label for="username">username</label>
		<input type="text" name="username" id="username">
	</div>

	<div>
		<label for="email">email</label>
		<input type="text" name="email" id="email">
	</div>

	<div>
		<label for="password">password</label>
		<input type="password" name="password" id="password">
	</div>

	<div>
		<label for="confirmPassword">confirmPassword</label>
		<input type="password" name="confirmPassword" id="confirmPassword">
	</div>

	<input type="submit">

</form>

<?php }else{?>

	<h1>site closed for mantenance</h1>
<?php }
?>