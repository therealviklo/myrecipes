<?php
	require_once "db.php";
	require "isempty.php";

	function formatTextField($text) {
		return str_replace("\n", "<br>", $text);
	}

	function dispPost($dbArr, $link = true, $approveButton = false, $deleteButton = false) {
		echo "<div class='post'>";
		if ($link) {
			echo "<h3 class='center-text'><a href='post.php?id={$dbArr['Id']}'>{$dbArr['Title']}</a></h3>";
		} else {
			echo "<h3 class='center-text'>{$dbArr['Title']}</h3>";
		}
		echo	"<p class='smalltext center-text'>av ";
		if (isset($_SESSION["username"]) && isModerator($_SESSION["username"])) {
			echo "<a href='user.php?id={$dbArr['UserId']}' class='usernamelink'>{$dbArr['Username']}</a>";
		} else {
			echo "{$dbArr['Username']}";
		}
		echo " • {$dbArr['Time']}</p>";
		if (!isEmpty($dbArr['Ingredients'])) {
			$formattedIngredients = formatTextField($dbArr['Ingredients']);
			echo "<h4>Ingredienser</h4>
				<p>$formattedIngredients</p>";
		}
		if (!isEmpty($dbArr['Description'])) {
			$formattedDescription = formatTextField($dbArr['Description']);
			echo "<h4>Tillvägagångssätt</h4>
				<p>$formattedDescription</p>";
		}
		if (!isEmpty($dbArr['knownAllergens'])) {
			$formattedKnownAllergens = formatTextField($dbArr['knownAllergens']);
			echo "<h4>Allergiinformation</h4>
				<p>$formattedKnownAllergens</p>";
		}
		if (!isEmpty($dbArr['Allergens'])) {
			$formattedAllergens = formatTextField($dbArr['Allergens']);
			echo "<h4>Möjliga allergener upptäckta i Open Food Facts</h4>
				<p>$formattedAllergens</p>";
		}
		if ($pictures = getPictures($dbArr['Id'])) {
			foreach ($pictures as $pic) {
				echo "<img src='{$pic['FileName']}'>";
			}
		}
		if ($approveButton || $deleteButton) {
			echo "<div class='center-text'>";
			if ($approveButton) {
				echo "<a class='approve-button' href='approvepost.php?id={$dbArr['Id']}'>Godkänn</a>";
			}
			if ($deleteButton) {
				echo "<a class='approve-button' href='deletepost.php?id={$dbArr['Id']}'>Radera</a>";
			}
			echo "</div>";
		}
		if (($comments = getComments($dbArr['Id'])) && count($comments) > 0) {
			echo "<div class='comments'>
				<h4>Kommentarer</h4>";
			foreach ($comments as $comment) {
				echo "<h5>";
				if (isset($_SESSION["username"]) && isModerator($_SESSION["username"])) {
					echo "<a href='user.php?id={$comment['UserID']}' class='usernamelink'>{$comment['Username']}</a>";
				} else {
					echo "{$comment['Username']}";
				}
				echo ":</h5>
					<p class='comment-body'>
					{$comment['Comment']}";
				if ((isset($_SESSION["username"]) && isModerator($_SESSION["username"])) ||
					isset($_SESSION["id"]) && $_SESSION["id"] == $comment["UserID"]) {
					echo "<br><a class='approve-button' href='deletecomment.php?id={$comment['CommentID']}'>Radera</a>";
				}
				echo "</p>";
			}
			echo "</div>";
		}
		echo "</div>";
	}
?>