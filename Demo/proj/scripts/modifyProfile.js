import getXhr from "./XHR.js";

const formModify = document.getElementById("modifyProfile");

const name = document.getElementById("name");
const surname = document.getElementById("surname");
const login = document.getElementById("email");
const address = document.getElementById("address");

const nameError = document.getElementById("nameError");
const surnameError = document.getElementById("surnameError");
const loginError = document.getElementById("emailError");
const addressError = document.getElementById("addressError");


login.addEventListener("blur", () => {
  if (login.value === "") {
    loginError.textContent = "Ce champs est obligatoire";
    loginError.hidden = false;
  }
});

name.addEventListener("blur", () => {
  if (name.value === "") {
    nameError.textContent = "Ce champs est obligatoire";
    nameError.hidden = false;
  }
});

surname.addEventListener("blur", () => {
  if (surname.value === "") {
    surnameError.textContent = "Ce champs est obligatoire";
    surnameError.hidden = false;
  }
});

address.addEventListener("blur", () => {
  if (address.value === "") {
    addressError.textContent = "Ce champs est obligatoire";
    addressError.hidden = false;
  }
});

// Add input event listeners to hide error messages when the user starts typing
login.addEventListener("input", () => {
  if (login.value !== "") {
    loginError.textContent = ""; // Clear the error message
    loginError.hidden = true; // Hide the error message
  }
});


name.addEventListener("input", () => {
  if (name.value !== "") {
    nameError.textContent = ""; // Clear the error message
    nameError.hidden = true; // Hide the error message
  }
});

surname.addEventListener("input", () => {
  if (surname.value !== "") {
    surnameError.textContent = ""; // Clear the error message
    surnameError.hidden = true; // Hide the error message
  }
});

address.addEventListener("input", () => {
  if (address.value !== "") {
    addressError.textContent = ""; // Clear the error message
    addressError.hidden = true; // Hide the error message
  }
});


formModify.addEventListener("submit", function(event) {
    event.preventDefault();  // Prevent the default form submission

    const errorMsgChange = document.getElementById("failedChange");
    errorMsgChange.hidden = true;
    const successMsgChange = document.getElementById("successChange");
    successMsgChange.hidden = true;

    let isValidChange = formModify.checkValidity();  // Checks the entire form's validity
    if (!isValidChange) {
      // If any field is invalid, we iterate through them
      // Find the corresponding error element
      console.log("Test email invalid");
      if (!login.validity.valid)
        errorMsgChange.textContent = "Veuillez entrer un email valide";
      else
        errorMsgChange.textContent = "Veuillez remplir tout les champs";
      errorMsgChange.hidden = false;
    } else
        sendXHR(); // If all fields are valid, proceed with the XHR request
});

function sendXHR() {
    const xhr = getXhr();       //get the xhr response using 
    xhr.open(
      /* Method:       */ "POST",
      /* target URL :  */ window.location.origin + "/proj/controllers/modifyProfile.php",
      /* Async flag :  */ true
    );
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const res = xhr.responseText;
            console.log(res);
            handleResponse(res);
        }
    };
    xhr.send(new FormData(formModify));
}


function handleResponse(response) {

  const errorMsgChange = document.getElementById("failedChange");
  const successMsgChange = document.getElementById("successChange");

  console.log(response);
    if (response === "changed") {
        displayError(successMsgChange, "Profile mis a jour");
        console.log("Success profile changed");
    } else if (response === "emailExists") {
        displayError(errorMsgChange, "Email existe");
        console.error("Failed to change password: email exist");
    } else if (response === "error") {
        displayError(errorMsgChange, "Une erreur s'est produite");
        console.log("Error");
    } else {
        displayError(errorMsgChange, "Une erreur s'est produite");
        console.log("Error undefined");
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

document.getElementById('demande').addEventListener('click', function() {
    const xhrDelete = getXhr();
    xhrDelete.open('POST', window.location.origin + "/proj/controllers/requestDelete.php");
    xhrDelete.onload = function() {
        if (xhrDelete.status === 200) {
            alert("Demande de supression envoyee!");
        } else {
            alert("Erreur lors l\'envoie de demande de supression envoyee");
        }
    };
    xhrDelete.send();
});