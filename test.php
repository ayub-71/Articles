<?php 

include "config.php";
$query = $con->prepare("SELECT username from users order by userid desc limit 5");
		$query->execute();
		$results = $query->fetchAll();

		foreach($results as $result){echo $result["username"] . "<br>";}