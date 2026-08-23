const unregex = /^(\p{Script=Latin}|[0-9._-])+$/u;
const badUsernameMsg = "Användarnamnet får inte vara tomt och får endast innehålla latinska bokstäver, siffror, punkt, understreck och bindestreck.";
const differentPasswordMsg = "Lösenorden matchar inte.";
const pwregex = /(?=.*\d)(?=.*\p{General_Category=Lowercase_Letter})(?=.*\p{General_Category=Uppercase_Letter}).{8,}/u;
const badPasswordMsg = "Lösenordet måste innehålla minst 8 tecken, minst en liten och en stor bokstav, samt minst en siffra.";
const emptyregex = /^\s*$/u;

function validateRegistration() {
	const username = document.getElementById("register-username");
	const password = document.getElementById("register-password");
	const password2 = document.getElementById("register-password2");
	if (unregex.test(username.value)) {
		username.setCustomValidity("");
	}
	else {
		username.setCustomValidity(badUsernameMsg);
	}
	if (pwregex.test(password.value)) {
		password.setCustomValidity("");
	}
	else {
		password.setCustomValidity(badPasswordMsg);
	}
	if (password.value == password2.value) {
		password2.setCustomValidity("");
	}
	else {
		password2.setCustomValidity(differentPasswordMsg);
	}
}

function validatePasswordChange() {
	const password = document.getElementById("chpass-password");
	const password2 = document.getElementById("chpass-password2");
	if (pwregex.test(password.value)) {
		password.setCustomValidity("");
	}
	else {
		password.setCustomValidity(badPasswordMsg);
	}
	if (password.value == password2.value) {
		password2.setCustomValidity("");
	}
	else {
		password2.setCustomValidity(differentPasswordMsg);
	}
}

function validateComment() {
	const comment = document.getElementById("comment");
	if (emptyregex.test(password.value)) {
		comment.setCustomValidity("Kommentaren får inte vara tom");
	}
	else {
		comment.setCustomValidity("");
	}
}