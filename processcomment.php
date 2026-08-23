<?php
	session_start();
	require "loginprotect.php";
	
	require "db.php";
	require "isempty.php";

	if (!isset($_POST["comment-postid"])) {
		header("Location: home.php?error=" . urlencode("Inläggs-id skickades inte med."));
		exit;
	}
	if (!isset($_POST["comment"])) {
		header("Location: post.php?id={$_POST['comment-postid']}&error=" . urlencode("Kommentar skickades inte med."));
		exit;
	}
	if (isEmpty($_POST["comment"])) {
		header("Location: post.php?id={$_POST['comment-postid']}&error=" . urlencode("Kommentar får inte vara tom."));
		exit;
	}
	if (preg_match("/^[0-9]+$/u", $_POST["comment-postid"]) !== 1) {
		header("Location: post.php?id={$_POST['comment-postid']}&error=" . urlencode("Inläggs-id är inte numeriskt."));
		exit;
	}
	if (!getPost($_POST["comment-postid"])) {
		header("Location: post.php?id={$_POST['comment-postid']}&error=" . urlencode("Inlägg finns inte."));
		exit;
	}
	if (!createComment($_POST["comment-postid"], $_SESSION["id"], $_POST["comment"])) {
		header("Location: post.php?id={$_POST['comment-postid']}&error=" . urlencode("Kunde inte skapa kommentar."));
		exit;
	}
	header("Location: post.php?id={$_POST['comment-postid']}");
?>