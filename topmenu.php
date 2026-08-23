<div id="topmenu">
	<span>
		<a href="home.php">
			Startsida
		</a>
	</span>
	<span>
		<a href="search.php">
			Sök
		</a>
	</span>
	<span>
		<a href="createpost.php">
			Skapa inlägg
		</a>
	</span>
	<?php
		require_once "db.php";
		if (isset($_SESSION["username"]) && isModerator($_SESSION["username"])) {
			echo "<span>
					<a href='unapprovedposts.php'>
						Godkänn inlägg
					</a>
				</span>";
		}
	?>
	<div id="topmenu-right">
		<span>
			<a href="profile.php">
				Profil
			</a>
		</span>
		<span>
			<form action="logout.php">
				<button>Logga ut</button>
			</form>
		</span>
	</div>
</div>