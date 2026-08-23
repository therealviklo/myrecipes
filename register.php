<?php
	require_once "db.php";
	require_once "login_funcs.php";
	if (!isset($_POST["register-username"])) {
		header("Location: index.php?error=" . urlencode("Användarnamn skickades inte med."));
		exit;
	}
	if (!isset($_POST["register-password"])) {
		header("Location: index.php?error=" . urlencode("Lösenord skickades inte med."));
		exit;
	}
	if (preg_match("/^(\p{Latin}|[0-9._-])+$/u", $_POST["register-username"]) === 0) {
		header("Location: index.php?error=" . urlencode("Användarnamnet uppfyller inte kraven."));
		exit;
	}
	if (preg_match("/(?=.*\d)(?=.*\p{Ll})(?=.*\p{Lu}).{8,}/u", $_POST["register-password"]) === 0) {
		header("Location: index.php?error=" . urlencode("Lösenordet uppfyller inte kraven."));
		exit;
	}
	if (getUserInfo($_POST["register-username"])) {
		header("Location: index.php?error=" . urlencode("Det finns redan en användare med det användarnamnet."));
		exit;
	}
	if (!registerUser($_POST["register-username"], $_POST["register-password"])) {
		header("Location: index.php?error=" . urlencode("Kunde inte registrera användare."));
		exit;
	}
	login($_POST["register-username"], $_POST["register-password"]);
?>