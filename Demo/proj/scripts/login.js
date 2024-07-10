import getXhr from "./XHR.js";

const form = document.getElementById("loginForm");

const login = document.getElementById("identifiant");
const mdp = document.getElementById("mdp");
const userType = document.getElementById("userType");

const loginError = document.getElementById("loginError");
const mdpError = document.getElementById("mdpError");
const errorMsg = document.getElementById("failed");

document.addEventListener("DOMContentLoaded", function() {
	userType.dispatchEvent(new Event('change'));
});

userType.addEventListener("change", () => {
	if (userType.value === "admin")
		login.placeholder = "Username";
	else
		login.placeholder = "Email";
});

login.addEventListener("blur", () => {
	if (login.value === "") {
		displayError(loginError, "Ce champs est obligatoire");
		console.log("No identifiant Error");
	}
});

mdp.addEventListener("blur", () => {
	if (login.value === "") {
		displayError(mdpError, "Ce champs est obligatoire");
		console.log("No identifiant Error");
	}
});

// Add input event listeners to hide error messages when the user starts typing
login.addEventListener("input", () => {
	if (login.value !== "")
		hideError(loginError, '');
});

mdp.addEventListener("input", () => {
	if (mdp.value !== "")
		hideError(mdpError, '');
});



form.addEventListener("submit", function(event) {
    event.preventDefault();  // Prevent the default form submission
    console.log("Handling form submission via JavaScript");

    let isValid = form.checkValidity();
    if (isValid)
        sendXHR();
    else
        displayError(errorMsg, "Veuillez remplir tout les champs.");
});

function sendXHR() {
	const xhr = getXhr();       //get the xhr response using 
	xhr.open(
		/* Method:       */ "POST",
		/* target URL :  */ "../controllers/LoginController.php",
		/* Async flag :  */ true
	);
	xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const res = xhr.responseText;
            console.log(res);
            handleResponse(res);
        }
    };
    xhr.send(new FormData(form));
}

function handleResponse(response) {

	switch (response) {
		case 'okAdmin':
			//Redirection page Admin
			hideError(errorMsg, "Admin found");
			window.location.href = "./admin/dashboardAdmin.php";
			break;

		case 'okEtudiant':
			//Redirection page etd
			hideError(errorMsg, "Etudiant found");
			window.location.href = "./etudiant/dashboardEtudiant.php";
			break;

		case 'okProf':
			//Redirection page prof
			hideError(errorMsg, "Prof found");
			window.location.href = './prof/dashboardProf.php';
			break;

		case 'error':
			//Mot de passe ou identifiant incorrect
			displayError(errorMsg, "identifiant ou mot de passe incorrect");
			break;

		default:
			console.log(response);
			break;
	}

}

function displayError(error, message) {
    error.textContent = message;
    error.hidden = false;
}

function hideError(error, consoleMsg) {
	console.log(consoleMsg);
	error.textContent =
		  "";
	error.hidden = true;
}
