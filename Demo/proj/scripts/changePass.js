import getXhr from "./XHR.js";

const form = document.getElementById("changePassForm");

const oldPassword = document.getElementById("oldpass");
const newPassword = document.getElementById("newpass");
const confirmPassword = document.getElementById("newpassConf");

const oldPasswordError = document.getElementById("oldpassError");
const newPasswordError = document.getElementById("newpassError");
const confirmPasswordError = document.getElementById("newpassConfError");

const errorMsg = document.getElementById("failed");
const successMsg = document.getElementById("success");

form.addEventListener("submit", function(event) {
    event.preventDefault();  // Prevent the default form submission

    hideError(oldPasswordError, "");
    hideError(newPasswordError, "");
    hideError(confirmPasswordError, "");
    hideError(errorMsg, "");

    let isValid = form.checkValidity();  // Checks the entire form's validity
    if (!isValid) {
        // If any field is invalid, display error messages
        if (oldPassword.validity.valueMissing)
            displayError(oldPasswordError, "Ce champ est obligatoire");

        if (newPassword.validity.valueMissing) {
            displayError(newPasswordError, "Ce champ est obligatoire");
        }
        if (confirmPassword.validity.valueMissing) {
            displayError(confirmPasswordError, "Ce champ est obligatoire");
        }
        return;
    }

    sendXHR();
});

function sendXHR() {
    const xhr = getXhr();      
    xhr.open("POST", "../../controllers/changePassController.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const res = xhr.responseText;
            console.log(res);
            handleResponse(res);
        }
    };

    // Send the form data as FormData
    xhr.send(new FormData(form));
}

function handleResponse(response) {
    // Handle the response from the server
    const cleanResponse = response; 
    successMsg.hidden = true; 

    if (cleanResponse === "wrongPass") {
        displayError(errorMsg, "Vous avez entrez un mot de passe invalide");
        console.log("wrong password");
    } else if (cleanResponse === "notSimilar") {
        displayError(errorMsg, "Les mots de passes ne sont pas conformes");
        console.log("diff new passwords");
    } else if (cleanResponse === "samePass") {
        displayError(errorMsg, "Veuillez choisir un mot de pass different de l'ancien");
        console.log("Same old password");
    } else if (cleanResponse === "success") {
        displayError(successMsg, "Mot de pass changee");
        console.log("Password changed successfully");
    }
    else {
        displayError(errorMsg, "Une erreur s'est produite");
        console.error("Failed to change password");
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