<?php session_start(); ?>
<?php require "loginprotect.php"; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>MyRecipes</title>
		<link rel="shortcut icon" href="img/icon.jpg">
        <link rel="stylesheet" href="css/style.css">
		<script src="validate.js"></script>
	</head>
	<body class="food-background">
		<?php require "errorbox.php"; ?>
		<div class="vflexcontainer cover-all">
			<?php require "topmenu.php"; ?>
			<div class="content-box flex-auto center-text">
				<?php
					require_once "db.php";
					if ($userInfo = getUserInfo($_SESSION["username"])) {
						echo "<h2>Användarinformation</h2>
							<p>Användarnamn: {$userInfo['Username']}</p>
							<p>Användar-id: {$userInfo['Id']}</p>
							<h2>Byt lösenord</h2>
							<form action='chpass.php' method='post'>
								<label for='chpass-password'>Nytt lösenord</label><br>
								<input type='password' name='chpass-password' id='chpass-password' required><br>
								<label for='chpass-password2'>Repetera nytt lösenord</label><br>
								<input type='password' name='chpass-password2' id='chpass-password2' required><br>
								<button onclick='validatePasswordChange()'>Byt lösenord</button>
							</form>";
					} else {
						echo "<p>FEL: Du är inloggad men din användarinformation är oåtkomlig.</p>";
					}
				?>
			</div>
		</div>
	</body>
</html>