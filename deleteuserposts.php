<?php
	session_start();
	require_once "db.php";
	require "loginprotect.php";
	require "modprotect.php";
	if (!isset($_GET["id"])) {
		header("Location: home.php?error=" . urlencode("Inget inläggs-id skickades med."));
		exit;
	}
	deleteUserPosts($_GET["id"]);
	header("Location: user.php?id={$_GET['id']}");
?>