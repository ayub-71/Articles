<?php

// $paths = "here";
include "config.php";

$get = select("users", "userid", array($_SESSION["userid"])); 
?>

<div class="profile-page">

	<div class="profile-head">
		&nbsp;
		<p></p>
		<h1>profile</h1>
	</div>
	<div class="profile-info">
		<p>username: <span><?php echo $get["username"]; ?></span></p>
		<p>email: <span><?php echo $get["email"]; ?></span></p>
	</div>
</div>