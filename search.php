<?php session_start(); ?>
<?php require "loginprotect.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sökruta</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="img/pic.jpg">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body class="post-background">
        <?php require "errorbox.php"; ?>
		<?php require "topmenu.php"; ?>
    	<div id="post-background">
        <h3 id="header3title">Sök efter receptinlägg här</h3>
        <div id="search-content">
            <form action="search.php" method="get">
                <i class="fa fa-search" aria-hidden="true"></i>
                <input type="text" name="search" required></input> 
                <button>Sök</button>
            </form>
            <div class="left-text">
                <?php
                    require_once "db.php";
                    require_once "disppost.php";
                    if (isset($_GET["search"])) {
                        if ($searchResults = searchTitle($_GET["search"])) {
                            foreach ($searchResults as $post) {
                                dispPost($post);
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>