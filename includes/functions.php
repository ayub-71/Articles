<?php

	// checking function;

	function checking($select, $where, $value){

		global $con;
		
		$query = $con->prepare("SELECT {$select} from users where {$where} = ?");
		$query->execute(array($value));
		$result = $query->fetch();
		$count = $query->rowCount();

		if($count){
			
			echo $select . " is already exist";
		}

		return $count;

	}

	// redirect function after a specific duration;

	function redirect($msg, $time, $url){

		echo $msg;

		header("refresh:$time url=$url");
	}

	// select function from databae;

	/*function select($select, $table, $where = array()){

		global $con;

		$stmt = $con->prepare("SELECT {$select} from {$table} where {$where} = ?");

		$x = 1;
		if(count($where)){
			foreach($where as $feild){
				$stmt->bindValue($x, $feild);
				$x++;
			}
		}

		$stmt->execute();
		$results = $stmt->fetch();
		$count = $stmt->rowCount();
		echo $count;
	}*/



	function signIn($table, $condition, $where = array()){

			global $con;

			$stmt = $con->prepare("SELECT * from {$table} where {$condition}");
			// $stmt = $con->prepare($sql);

			$x = 1;
			if(count($where)){
				foreach($where as $feild){
					$stmt->bindValue($x, $feild);
					$x++;
				}
			}

			$stmt->execute();
		
				$results = $stmt->fetch();
				$count = $stmt->rowCount();
			// else{$count = "error";}
			
			if(!$count){//echo "username or password wrong!";
				 $results = 0;
			}
			if($count){
				$_SESSION["userid"] = $results["userid"];
				$_SESSION["username"] = $results["username"];
			}

			return $results;
		}

		/*$username = "ayoub"; $password = sha1("123123");

		echo select("SELECT * from users where username = ? and password = ?", array($username, $password), "email"); */

		function signUp($username, $email, $password){

			global $con;

			$stmt = $con->prepare("INSERT into users(username, email, password) values(:zusername, :zemail, :zpassword)");

					$stmt->execute(array(
						"zusername" => $username,
						"zemail" 	=> $email,
						"zpassword" => sha1($password)));

					$count = $stmt->rowCount();

					return $count;

		}

	// function of select;

	function select($table, $condition, $where = array()){

		global $con;

		$stmt = $con->prepare("SELECT * from {$table} where {$condition}");
			// $stmt = $con->prepare($sql);

			$x = 1;
			if(count($where)){
				foreach($where as $feild){
					$stmt->bindValue($x, $feild);
					$x++;
				}
			}

			$stmt->execute();
		
				$results = $stmt->fetch();
				$count = $stmt->rowCount();
			// else{$count = "error";}
			
			if(!$count){//echo "username or password wrong!";
				 $results = 0;
			}
			if($count){
				
				return $results;
			}				
	}

	function latest($table, $orderBy, $limit){

		global $con;

		$stmt = $con->prepare("SELECT * from {$table} order by {$orderBy} desc limit {$limit}");
		$stmt->execute();
		$results = $stmt->fetchAll();
		$count = $stmt->rowCount();

		if($count){

			return $results;
		}

		return false;
	}