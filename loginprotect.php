<?php
	if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
		header("Location: index.php");
		exit;
	}
?>