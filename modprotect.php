<?php
	require_once "db.php";
	if (!isModerator($_SESSION["username"])) {
		header("Location: home.php?error=" . urlencode("Du måste vara moderator för att komma åt denna sida."));
		exit;
	}
?>