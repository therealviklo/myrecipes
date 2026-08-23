<?php
	session_start();
	require_once "db.php";
	require "loginprotect.php";
	require "modprotect.php";
	if (!isset($_GET["id"])) {
		header("Location: home.php?error=" . urlencode("Inget användar-id skickades med."));
		exit;
	}
	makeModerator($_GET["id"]);
	header("Location: user.php?id={$_GET['id']}");
?>