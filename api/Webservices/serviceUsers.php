<?php
	// urls
	/*create*/
	$app->post('/users','insertUser');
	/*read*/
	$app->get('/users','getUsers');
	$app->get('/users/:idUser','getUserById');
	/*update*/
	$app->post('/users/update/:idUser','updateUserById');
	/*delete*/
	$app->delete('/users/delete/:idUser','deleteUserById');

	/***** CREATE *****/
	function insertUser() {
		$request = \Slim\Slim::getInstance()->request();
		$user = json_decode($request->getBody());
		$sql = "INSERT INTO users (idUser, userName, userAdressEmail) VALUES (:idUser, :userName, :userAdressEmail)";
		try {
			$db = getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("idUser", $user->idUser);
			$stmt->bindParam("userName", $user->userName);
			$stmt->bindParam("userAdressEmail",$user->userAdressEmail);
			$stmt->execute();
			$user->id = $db->lastInsertId();
			$db = null;
			$user_id= $user->idUser;
			getUserById($user_id);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/***** READ *****/
	function getUsers() {
		$sql = "SELECT * FROM users ORDER BY idUser";
		try {
			$db = getDB();
			$stmt = $db->query($sql);
			$users = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			echo '{"users": ' . json_encode($users) . '}';
		} catch(PDOException $e) {
		    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	function getUserById($idUser){

		$sql = "SELECT * FROM users WHERE idUser=:idUser";
		try {
			$db = getDB();
			$stmt = $db->prepare($sql);
	        $stmt->bindParam("idUser", $idUser);
			$stmt->execute();
			$user = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			echo '{"user": ' . json_encode($user) . '}';

		} catch(PDOException $e) {
		    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}


	/***** UPDATE *****/
	function updateUserById($idUser) {
		$request = \Slim\Slim::getInstance()->request();
		$user = json_decode($request->getBody());

		$sql = "UPDATE users SET userName=:userName, userAdressEmail=:userAdressEmail WHERE idUser=".$idUser;
		try {
			$db = getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("userName", $user->userName);
			$stmt->bindParam("userAdressEmail",$user->userAdressEmail);
			$stmt->execute();
			$db = null;
			getUserById($idUser);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/***** DELETE *****/
	function deleteUserById($idUser) {

		$sql = "DELETE FROM users WHERE idUser=:idUser";
		try {
			$db = getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("idUser", $idUser);
			$stmt->execute();
			$db = null;
			echo true;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}

	}
?>
