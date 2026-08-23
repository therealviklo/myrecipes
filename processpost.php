<?php
	session_start();
	require "loginprotect.php";
	
	require "db.php";
	
	function fileExtension($filename) {
		if (preg_match("/\.[^.]*$/u", $filename, $matches) === 1) {
			return $matches[0];
		} else {
			return "";
		}
	}

	function knownFileExtension($ext) {
		return preg_match("/^((.png)|(.jpg)|(.jpeg)|(.jpe)|(.gif)|(.bmp))$/iu", $ext) !== 0;
	}

	if (!isset($_POST["post-title"])) {
		header("Location: createpost.php?error=" . urlencode("Rubrik skickades inte med."));
		exit;
	}
	if (!isset($_POST["post-ingredients"])) {
		header("Location: createpost.php?error=" . urlencode("Ingredienser skackades inte med."));
		exit;
	}
	if (!isset($_POST["post-description"])) {
		header("Location: createpost.php?error=" . urlencode("Tillvägagångssätt skickades inte med."));
		exit;
	}
	if (!isset($_POST["post-allergens"])) {
		header("Location: createpost.php?error=" . urlencode("Allergiinformation skickades inte med."));
		exit;
	}
	if (!isset($_POST["post-barcodes"])) {
		header("Location: createpost.php?error=" . urlencode("Streckkoder skickades inte med."));
		exit;
	}
	if (!isset($_FILES["filename"])) {
		header("Location: createpost.php?error=" . urlencode("Uppladdningsfel."));
		exit;
	}
	$numFiles = count($_FILES["filename"]["name"]);
	// Kontrollerar att filerna är bildfiler med kända filtillägg.
	for ($i = 0; $i < $numFiles; $i++) {
		if ($_FILES["filename"]["name"][$i] != "") {
			$ext = fileExtension($_FILES["filename"]["name"][$i]);
			if (!knownFileExtension($ext)) {
				header("Location: createpost.php?error=" . urlencode("Filnamnet \"{$_FILES['filename']['name'][$i]}\" har ett okänt filformat ($ext)."));
				exit;
			}
		}
	}
	// Gå igenom streckkoder
	$allergens = "";
	foreach (explode(",", $_POST["post-barcodes"]) as $barcode) {
		$trimmedBarcode = trim($barcode);
		if (preg_match("/^[0-9]+$/u", $trimmedBarcode) === 1) {
			$response = file_get_contents("https://world.openfoodfacts.org/api/v0/product/" . $trimmedBarcode . ".json");
			if ($response !== false) {
				$json = json_decode($response, true);
				if (isset($json["product"]) && isset($json["product"]["allergens_hierarchy"])) {
					foreach ($json["product"]["allergens_hierarchy"] as $allergen) {
						if (preg_match("/[^:]*$/u", $allergen, $matches) === 1) {
							if ($allergens !== "") {
								$allergens .= "\n";
							}
							$allergens .= $matches[0];
						}
					}
				}
			}
		}
	}
	// Skapa inlägg
	if (!($postId = createPost($_SESSION["id"], $_POST["post-title"], $_POST["post-ingredients"], $_POST["post-description"], $allergens, $_POST["post-allergens"]))) {
		header("Location: createpost.php?error=" . urlencode("Kunde inte skapa inlägg."));
		exit;
	}
	// Ladda upp bilder
	for ($i = 0; $i < $numFiles; $i++) {
		if ($_FILES["filename"]["name"][$i] != "") {
			$tmplocation = $_FILES["filename"]["tmp_name"][$i];
			$newlocation = "userimg/" . $postId . "-" . $i . fileExtension($_FILES["filename"]["name"][$i]);
			if (move_uploaded_file($tmplocation, $newlocation)) {
				addPostPicture($postId, $newlocation);
			}
		}
	}
	header("Location: post.php?id=$postId");
?>