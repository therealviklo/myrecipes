<?php session_start(); ?>
<?php require "loginprotect.php"; ?>
<?php require "modprotect.php"; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>MyRecipes</title>
		<link rel="shortcut icon" href="img/icon.jpg">
        <link rel="stylesheet" href="css/style.css">
	</head>
	<body class="food-background">
		<?php require "errorbox.php"; ?>
		<?php require "topmenu.php"; ?>
		<div class="content-box">
			<?php
				require_once "db.php";
				if ($userInfo = getUserInfoFromId($_GET["id"])) {
					$mod = $userInfo["Moderator"] === 1 ? "Ja" : "Nej";
					echo "<h2>Användarinformation</h2>
						<p>Användarnamn: {$userInfo['Username']}</p>
						<p>Användar-id: {$userInfo['Id']}</p>
						<p>Moderator: $mod</p>
						<h2>Åtgärder</h2>
						<div class='center-text'>
							<a href='deleteuserposts.php?id={$userInfo['Id']}' class='approve-button'>Radera inlägg</a>
							<a href='deleteuser.php?id={$userInfo['Id']}' class='approve-button'>Radera användare</a>";
					if ($userInfo["Moderator"] === 0) {
						echo "<a href='makemoderator.php?id={$userInfo['Id']}' class='approve-button'>Gör till moderator</a>";
					}
					echo "</div>";
				} else {
					echo "<p>FEL: Användare finns inte.</p>";
				}
			?>
		</div>
	</body>
</html>