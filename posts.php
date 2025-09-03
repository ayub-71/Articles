<?php 

include "config.php";

if(SITE_STATUS == true){

	if(isset($_SESSION["username"])){

		// header("location: homepage.php"); exit();
	// }

		$d = "";

		if(isset($_GET["d"])){$d = $_GET["d"];}else{$d = "manage";}

		if($d == "manage"){

			$stmt = $con->prepare("SELECT * from posts  where user_id = ?");
			$stmt->execute(array($_SESSION["userid"]));
			$results = $stmt->fetchAll();
			$count = $stmt->rowCount(); 
			// echo $count;
		?>

			<div class="posts_managePage">

				<?php

				?>

				<h1>articles manage</h1>

				<a href="?d=add"><button><h3>add new article</h3></button></a>

				<table>
					<tr>
						<th>#id</th>
						<th>title</th>
						<th>state</th>
						<th>control</th>
					</tr>
					<tr>
						<td>
							<?php
								foreach($results as $result){

								echo $result["postid"] . "<br>";

							}
							?>
						</td>
						<td>
							<?php
								foreach($results as $result){

								echo $result["title"] . "<br>";

							}
							?>
						</td>
						<td>
							<?php
								foreach($results as $result){

								echo "state" . "<br>";

							}
							?>
						</td>
						<td>
							<?php
								foreach($results as $result){

								echo "<a href='?d=edit&postid=" . $result["postid"] . "'>edit</a> / <a href='?d=delete&postid=" . $result["postid"] . "'>delete</a>"
								 . "<br>";

							}
							?>
						</td>
						
					</tr>
				</table>
			</div>

		<?php }
		elseif($d == "add"){?>

			<h1>add articles</h1>

			<form action="?d=insert" method="POST">
				<div>
					<label>title</label>
					<input type="text" name="title">
				</div>
				<div>
					<label>text</label>
					<input type="text" name="text">
				</div>
				<div>
					<label>article image</label>
					<input type="file">
				</div>
				<button>add article</button>
			</form>

		<?php }
		elseif($d == "insert"){

			if($_SERVER["REQUEST_METHOD"] == "POST"){

				$title 	= filter_var($_POST["title"], FILTER_SANITIZE_STRING);
				$text 	= filter_var($_POST["text"], FILTER_SANITIZE_STRING);

				$formErrors = array();

				if(empty($title)){$formErrors[] = "title field must not be empty!";}
				if(empty($text)){$formErrors[] 	= "text field must not be empty!";}

				foreach($formErrors as $error){echo $error . "<br>";}

				if(empty($formErrors)){
					
					$stmt = $con->prepare("INSERT INTO posts(title, `text`, user_id) values(:ztitle, :ztext, :zuser_id)");
					$stmt->execute(array(
						"ztitle" => $title,
						"ztext" => $text,
						"zuser_id" => $_SESSION["userid"]
					));

					$count = $stmt->rowCount();
					 echo "you have created a new article";
					 header("refresh:3 url=posts.php"); exit();
				}
			}

		}
		elseif($d == "edit"){

			if(isset($_GET["postid"]) && is_numeric($_GET["postid"])){
				$postid = $_GET["postid"];
			}else{$postid = 0;}

			$stmt = $con->prepare("SELECT * from posts where postid = ?");
			$stmt->execute(array($postid));
			$data = $stmt->fetch();
			$count = $stmt->rowCount();
		?>

		<h1>update article</h1>

			<form action="?d=update" method="POST">
				<div>
					<label>title</label>
					<input type="text" name="title" value="<?php echo $data['title']; ?>">
				</div>

				<div>
					<label>text</label>
					<input type="text" name="text" value="<?php echo $data["text"]; ?>">
				</div>

				<div>
					<label>article image</label>
					<input type="file">
				</div>
				<input type="hidden" name="postid" value="<?php echo $data["postid"]; ?>">
				<button>update</button>
			</form>

		<?php }
		elseif($d == "update"){

			if($_SERVER["REQUEST_METHOD"]){

				$title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
				$text = filter_var($_POST["text"], FILTER_SANITIZE_STRING);
				$postid = $_POST["postid"];
				
				$stmt = $con->prepare("UPDATE posts set title = ?, `text` = ? where postid = ?");
				$stmt->execute(array($title, $text, $postid));
				$count = $stmt->rowCount();
				 echo "article have updated successfuly";

				 header("refresh:3 url=posts.php"); exit();
			}
		}
		elseif($d == "delete"){
			if(isset($_GET["postid"]) && is_numeric($_GET["postid"])){
				$postid = $_GET["postid"];
			}else{$postid = 0;}

			$stmt = $con->prepare("DELETE from posts where postid = ?");
			$stmt->execute(array($postid));
			$count = $stmt->rowCount(); echo $count;
		}
		else{echo "<h1>oops! There is no such get</h1>";}
	}else{
		header("location: sign-in.php"); exit();
	}
}else{echo "<h1>site closed for mantenance</h1>";}
?>