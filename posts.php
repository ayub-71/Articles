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

				<button ><a href="?d=add"><h3>add new article</h3></a></button>

				<div class="table-container">
					<table>
						<tr class="trr">
							<th class="id">#id</th>
							<th class="title">title</th>
							<th class="state">state</th>
							<th class="control">control</th>
						</tr>

						<?php

							foreach($results as $result){?>
								<tr>
									<td><?php echo $result["postid"]; ?></td>
									<td><?php echo $result["title"]; ?></td>
									<td>state</td>
									<td class="button">
										<a class="edit" href='?d=edit&postid=<?php echo $result["postid"]; ?>'>edit</a>
										<a class="delete" href='?d=delete&postid=<?php echo $result["postid"]; ?>'>delete</a>
									</td>
								</tr>
							<?php } ?>
					</table>
				</div>
			</div>

		<?php }
		elseif($d == "add"){?>

			<div class="post-add-page">

				<h1>add articles</h1>

				<form action="?d=insert" method="POST">
					<div>
						<label>title</label>
						<input type="text" name="title">
					</div>
					<label>article</label>
					<div>
						<!-- <label>article</label> -->
						<textarea rows="20" cols="70"></textarea>

					</div>
					<div>
						<label>article image</label>
						<input type="file">
					</div>
					<button>create article</button>
				</form>
			</div>

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
		<div class="post-edit-page">

			<h1>update article</h1>

				<form action="?d=update" method="POST">
					<div>
						<label>title</label>
						<input type="text" name="title" value="<?php echo $data['title']; ?>">
					</div>

					<label>article</label>
					<div>
						<!-- <label>text</label> -->
						<!-- <input type="text" name="text" value="<?php //echo $data["text"]; ?>"> -->
						<textarea rows="20" cols="70" ><?php echo $data["text"]; ?></textarea>
					</div>

					<div>
						<label>article image</label>
						<input type="file">
					</div>
					<input type="hidden" name="postid" value="<?php echo $data["postid"]; ?>">
					<button>update</button>
				</form>
		</div>

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