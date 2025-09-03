<?php 

// make a simple dashboard, with users and articles and latest 5, add somethings as you want,
// try to add new ideas;

$paths = "../config.php"; $nonavbar = "";

include $paths;

if(SITE_STATUS == true){

	if(isset($_SESSION["username"])){

		function overview($select, $table){

			global $con;

			$stmt = $con->prepare("SELECT count({$select}) from {$table}");
			$stmt->execute();
			$result = $stmt->fetchColumn();
			// $count = $query->rowCount();

			return $result;
		}

		$latestsUsers = latest("users", "username", 5);
		$latestsPosts = latest("posts", "title", 5);
		
?>

	<div class="dashboard-page">
		<div class="dashboard-view">
			<div class="users"><p><?php echo overview("username", "users"); ?> users</p></div>
			<div class="articles"><p><?php echo overview("postid", "posts") ?> articles</p></div>
			<div class="users"><p>comments</p></div>
			<div class="users"><p>views</p></div>
		</div>
		<div class="latest">
			<div>
				<h3>latest 5 users</h3>
				<?php

					foreach($latestsUsers as $latest){echo $latest["username"] . "<br>";}
				?>
			</div>
			<div>
				<h3>latest 5 articles</h3>
				<?php

					foreach($latestsPosts as $latest){echo $latest["title"] . "<br>";}
				?>
			</div>
		</div>
		<div class="approve-table">
			<h2>pending articles approval</h2>
			<table>
				<tr>
					<th>postid</th>
					<th>title</th>
					<th>poster</th>
					<th>state</th>
					<th>controller</th>
				</tr>
				<tr>
					<td>1</td>
					<td>test</td>
					<td>tester</td>
					<td>pending</td>
					<td>approve/susspend/delete</td>
				</tr>
				<tr>
					<td>1</td>
					<td>test</td>
					<td>tester</td>
					<td>pending</td>
					<td>approve/susspend/delete</td>
				</tr>
				<tr>
					<td>1</td>
					<td>test</td>
					<td>tester</td>
					<td>pending</td>
					<td>approve/susspend/delete</td>
				</tr>
			</table>
		</div>
	</div>
<?php }else{

	header("location: sign-in.php"); exit();
}
}

?>