<?php
	session_start();
	require_once "db.php";
	require "loginprotect.php";
	if (!isset($_GET["id"])) {
		header("Location: unapprovedposts.php?error=" . urlencode("Inget inläggs-id skickades med."));
		exit;
	}
	if (isModerator($_SESSION["username"])) {
		deletePostAndAssociatedData($_GET["id"]);
		header("Location: unapprovedposts.php");
	} else {
		if ($post = getPost($_GET["id"])) {
			if ($post["UserId"] == $_SESSION["id"]) {
				deletePostAndAssociatedData($_GET["id"]);
				header("Location: home.php");
				exit;
			}
		}
		header("Location: home.php?error=" . urlencode("Du måste vara moderator för att komma åt denna sida."));
		exit;
	}
?>