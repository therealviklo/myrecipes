<?php
	session_start();
	require_once "db.php";
	require "loginprotect.php";
	if (!isset($_GET["id"])) {
		header("Location: home.php?error=" . urlencode("Inget komments-id skickades med."));
		exit;
	}
	if (!($comment = getComment($_GET["id"]))) {
		header("Location: home.php?error=" . urlencode("Kommentar finns inte."));
		exit;
	}
	if (isModerator($_SESSION["username"])) {
		deleteComment($_GET["id"]);
		header("Location: post.php?id={$comment['PostID']}");
	} else {
		if ($comment["UserID"] == $_SESSION["id"]) {
			deleteComment($_GET["id"]);
			header("Location: post.php?id={$comment['PostID']}");
			exit;
		}
		header("Location: post.php?id={$comment['PostID']}?error=" . urlencode("Du måste vara moderator för att komma åt denna sida."));
		exit;
	}
?>