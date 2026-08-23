<?php
	session_start();
	require_once "db.php";
	require "loginprotect.php";
	require "modprotect.php";
	if (!isset($_GET["id"])) {
		header("Location: home.php?error=" . urlencode("Inget inläggs-id skickades med."));
		exit;
	}
	deleteUserAndAssociatedData($_GET["id"]);
	header("Location: home.php");
?>