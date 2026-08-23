function useRecipe() {
	const ingredients = this.parentElement.getElementsByClassName("search-result-ingredients")[0].innerText;
	document.getElementById("post-ingredients").value = ingredients;
	const instructions = this.parentElement.getElementsByClassName("search-result-instructions")[0].innerText;
	document.getElementById("post-description").value = instructions;
	window.scrollTo(0, 0);
}

function createRecipeResult(meal) {
	let div = document.createElement("div");

	let title = document.createElement("h3");
	title.classList = "search-result-title";
	title.innerText = meal["strMeal"];
	div.appendChild(title);

	let ingredientsTitle = document.createElement("h4");
	ingredientsTitle.innerText = "Ingredienser";
	div.appendChild(ingredientsTitle);

	let ingredients = document.createElement("p");
	ingredients.classList = "search-result-ingredients";
	// Det verkar vara hårdkodat att det finns 20 ingredientfält, men
	// de som inte används är tomma eller null.
	for (let i = 1; i <= 20; i++) {
		let ingredient = meal["strIngredient" + i];
		let measure = meal["strMeasure" + i];
		if (ingredient !== "" && ingredient !== null) {
			if (ingredients.innerHTML !== "") {
				ingredients.innerHTML += "<br>";
			}
			ingredients.innerHTML += ingredient + " (" + measure + ")";
		}
	}
	div.appendChild(ingredients);

	let instructionsTitle = document.createElement("h4");
	instructionsTitle.innerText = "Tillvägagångssätt";
	div.appendChild(instructionsTitle);

	let instructions = document.createElement("p");
	instructions.classList = "search-result-instructions";
	instructions.innerHTML = meal["strInstructions"].replace("\n", "<br>");
	div.appendChild(instructions);

	let button = document.createElement("button");
	button.innerText = "Använd";
	button.onclick = useRecipe;
	div.appendChild(button);
	
	return div;
}

function searchRecipe() {
	const input = document.getElementById("search-recipe");
	const resultDiv = document.getElementById("search-results");
	resultDiv.innerHTML = "<p>Söker ...</p>";
	const request = new Request("https://www.themealdb.com/api/json/v1/1/search.php?s=" + encodeURIComponent(input.value));
	fetch(request)
		.then(response => {
			resultDiv.innerHTML = "";
			return response.json();
		})
		.then(data => {
			if (data["meals"]) {
				data["meals"].forEach(meal => {
					resultDiv.appendChild(createRecipeResult(meal));
				});
			}
		})
		.catch(err => {
			resultDiv.innerHTML = "<p>Fel: " + err + "</p>";
		});
}

function enterSearch(event) {
	if (event.keyCode === 13) {
		document.getElementById("search-recipe-button").click();
	}
}