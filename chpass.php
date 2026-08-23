<?php
	session_start();
	require_once "db.php";
	if (!isset($_POST["chpass-password"])) {
		header("Location: profile.php?error=" . urlencode("Lösenord skickades inte med."));
		exit;
	}
	if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
		header("Location: profile.php?error=" . urlencode("Inte inloggad."));
		exit;
	}
	if (preg_match("/(?=.*\d)(?=.*\p{Ll})(?=.*\p{Lu}).{8,}/u", $_POST["chpass-password"]) === 0) {
		header("Location: profile.php?error=" . urlencode("Lösenordet uppfyller inte kraven."));
		exit;
	}
	if (!updatePassword($_SESSION["id"], $_POST["chpass-password"])) {
		header("Location: profile.php?error=" . urlencode("Kunde inte uppdatera lösenord."));
		exit;
	}
	header("Location: profile.php");
?>