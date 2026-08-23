<?php session_start(); ?>
<?php require "logoutprotect.php"; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>MyRecipes</title>
		<link rel="shortcut icon" href="img/icon.jpg">
        <link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="js/validate.js"></script>
	</head>
	<body class="food-background">
		<?php require "errorbox.php"; ?>
        <div id="background">
			<div class="vflexcontainer cover-all">
				<div class="sidebysidecontainer flex-auto">
					<div class="sidebyside medium-column">
						<h1 id="myrecipetitle">MyRecipes</h1>
						<p>
							Hej! Är du intresserad av matlagning, eller behöver inspiration? Välkommen till MyRecipes!
							Logga in eller skapa ett konto hos oss redan idag och ta del av andra användares recept, samt dela med dig av dina genom att skapa inlägg!
						</p>
					</div>
					<div class="sidebyside medium-column center-text">
						<h2>Logga in</h2>
						<form action="login.php" method="post">
							<i class="fa fa-user" aria-hidden="true"></i>
							<label for="login-username">Användarnamn</label><br>
							<input type="text" name="login-username" id="login-username" placeholder="Skriv ditt användarnamn" required><br>
							<i class="fa fa-key" aria-hidden="true"></i>
							<label for="login-password">Lösenord</label><br>
							<input type="password" name="login-password" id="login-password" placeholder="Skriv ditt lösenord" required><br>
							<button>Logga in</button>
						</form>
						<h2>Registrera</h2>
						<form action="register.php" method="post" autocomplete="off">
							<i class="fa fa-user" aria-hidden="true"></i>
							<label for="register-username">Användarnamn</label><br>
							<input type="text" name="register-username" id="register-username" placeholder="Skriv ett användarnamn" autocomplete="false"><br>
							<i class="fa fa-key" aria-hidden="true"></i>
							<label for="register-password">Lösenord</label><br>
							<input type="password" name="register-password" id="register-password" placeholder="Skriv ett lösenord"><br>
							<i class="fa fa-key" aria-hidden="true"></i>
							<label>Repetera lösenord</label><br>
							<input type="password" id="register-password2" placeholder="Repetera lösenord"><br>
							<button onclick="validateRegistration()">Registrera</button>
						</form>
					</div>
				</div>
			</div>
		</div>
    </body>
</html>