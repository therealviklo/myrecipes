<?php session_start(); ?>
<?php require "loginprotect.php"; ?>
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
                require_once "disppost.php";
				if ($posts = getRecentPosts(20)) {
					foreach ($posts as $post) {
						dispPost($post);
					}
				}
            ?>
		</div>
	</body>
</html>