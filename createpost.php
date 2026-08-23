<?php session_start(); ?>
<?php require "loginprotect.php"; ?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<title>Skapa inlägg </title>
		<link rel="shortcut icon" href="img/icon.jpg">
        <link rel="stylesheet" href="css/style.css">
		<script src="js/searchRecipe.js"></script>
    </head>
    <body class="post-background">
		<?php require "errorbox.php"; ?>
		<?php require "topmenu.php"; ?>
    	<div id="post-background">
        <h2 id="header2title">Skapa ditt inlägg här</h2>
            <div id="search-content">
				<form action="processpost.php" method="post" enctype="multipart/form-data">
					<label for="post-title">Rubrik (obligatorisk)</label><br>
					<input type="text" name="post-title" id="post-title" required><br>
					<label for="post-ingredients">Ingredienser</label><br>
					<textarea type="text" name="post-ingredients" id="post-ingredients"></textarea><br>
                    <label for="post-description">Tillvägagångssätt</label><br>
                    <textarea type="text" name="post-description" id="post-description"></textarea><br>
                    <label for="post-allergens">Allergiinformation</label><br>
                    <textarea type="text" name="post-allergens" id="post-allergens"></textarea><br>
					<label for="post-barcodes">Streckkoder</label>
					<abbr title="Skriv in streckkoderna på de produkter som har använts om du vill att möjliga allergener ska sökas efter automatiskt i Open Food Facts.">?</abbr><br>
					<input type="text" name="post-barcodes" id="post-barcodes"><br>
                    <label for="filename[]">Bilder</label><br>
  					<input type="file" id="filename" name="filename[]" multiple><br>
                    <button type="submit" class="send-button">Skicka</button>
                </form>
				<h2>Sök recept</h2>
				<input type="text" id="search-recipe" onkeydown="enterSearch(event)"><br>
				<button id="search-recipe-button" onclick="searchRecipe()">Sök</button>
				<div id="search-results" class="left-text"></div>
			</div>
		</div>
    </body>
</html>