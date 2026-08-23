<?php
	require_once "login_funcs.php";
	if (!isset($_POST["login-username"])) {
		header("Location: index.php?error=" . urlencode("Användarnamn skickades inte med."));
		exit;
	}
	if (!isset($_POST["login-password"])) {
		header("Location: index.php?error=" . urlencode("Lösenord skickades inte med."));
		exit;
	}
	login($_POST["login-username"], $_POST["login-password"]);
?>