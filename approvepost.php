<?php
	session_start();
	require_once "db.php";
	require "loginprotect.php";
	require "modprotect.php";
	if (!isset($_GET["id"])) {
		header("Location: unapprovedposts.php?error=" . urlencode("Inget inläggs-id skickades med."));
		exit;
	}
	approvePost($_GET["id"]);
	header("Location: unapprovedposts.php");
?>