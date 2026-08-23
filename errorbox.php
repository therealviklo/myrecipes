<script src="js/errorbox.js"></script>
<?php
	if (isset($_GET["error"])) {
		echo '<div id="error">
				<h1>Fel</h1>
				<p>' . $_GET["error"] . '</p>
				<button onclick="removeErrorBox()">Stäng</button>
			</div>
			<div id="grey-tint"></div>';
	}
?>