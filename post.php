<?php session_start(); ?>
<?php require "loginprotect.php"; ?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <title>Sökruta</title>
        <link rel="stylesheet" href="css/style.css">
		<script src="js/validate.js"></script>
	</head>
	<body class="post-background">
		<?php require "errorbox.php"; ?>
		<?php require "topmenu.php"; ?>
		<?php
			require_once "db.php";
			require_once "disppost.php";
			if (isset($_GET["id"])) {
				echo "<div class='content-box'>";
				if ($post = getPost($_GET["id"])) {
					if (isModerator($_SESSION["username"])) {
						dispPost($post, false, $post["Approved"] === 0, true);
					} elseif ($post["UserId"] == $_SESSION["id"]) {
						dispPost($post, false, false, true);
					} elseif ($post["Approved"] === 1) {
						dispPost($post, false);
					} else {
						header("Location: home.php?error=" . urlencode("Du får inte komma åt det här inlägget."));
						exit;
					}
				} else {
					header("Location: home.php?error=" . urlencode("Inlägget finns inte."));
					exit;
				}
				echo 	"<h4>Kommentera</h4>
						<form action='processcomment.php' method='post'>
							<input type='hidden' name='comment-postid' value='{$_GET['id']}'>
							<textarea type='text' name='comment' id='comment' required></textarea><br>
							<button type='submit' class='send-button'  onclick='validateComment()'>Skicka</button>
						</form>
					</div>";
			} else {
				header("Location: home.php?error=" . urlencode("Inget inläggs-id angavs."));
				exit;
			}
		?>
	</body>
</html>