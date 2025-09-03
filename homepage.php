<?php

$paths = "config.php";
include $paths;
// include "includes/functions.php";

if(SITE_STATUS == true){

	if(isset($_SESSION["username"])){

		// bring all posts here in this homepage, and make pagination, most watch 
		// and comments, likes only for regestred peopple and some other things...;

		$query = $con->prepare("SELECT * from posts");
		$query->execute(array());
		$results = $query->fetchAll();
		// $count = $query->rowCount();
		?>

			<div class="homepage">
				<div class="article-container">

					<?php foreach($results as $result){?>
						<div class="article">
							<p>
								<h2><?php echo $result["title"];?></h2>
								<?php echo $result["text"];?>
							</p>
						</div>
					<?php } ?>

				</div>
				<div class="sidebar">
					<div><h2>latest articles</h2></div>
					<div><h2>most view</h2></div>
				</div>
				<div class="clear"></div>
			</div>


<?php		// $username = "ayoub"; $password = sha1("123123");

		// $email = select("users", "username = ? and password = ?", array($username, $password), "email");
		// $userid = select("users", "username = ? and password = ?", array($username, $password), "username");

		// if($email){echo "yes";}else{echo "not";}
		// echo $email["username"];

	include "includes/templates/footer.php";

	}else{ 

		header("location: sign-in.php"); exit();
	}

}else{echo "site closed for mantenance";}

