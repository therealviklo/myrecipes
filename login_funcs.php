<?php
	require_once "db.php";
	function login($username, $password) {
		if (!($userInfo = getUserInfo($username))) {
			header("Location: index.php?error=" . urlencode("Felaktigt användarnamn."));
			exit;
		}
		if (!password_verify($password, $userInfo["Password"])) {
			header("Location: index.php?error=" . urlencode("Felaktigt lösenord"));
			exit;
		}
		session_start();
		$_SESSION["id"] = $userInfo["Id"];
		$_SESSION["username"] = $userInfo["Username"];
		header("Location: home.php");
		exit;
	}
?>