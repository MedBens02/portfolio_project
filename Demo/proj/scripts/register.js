import getXhr from "./XHR.js";

const form = document.getElementById("registerForm");

const login = document.getElementById("identifiant");
const mdp = document.getElementById("mdp");
const userType = document.getElementById("userType");
const name = document.getElementById("name");
const surname = document.getElementById("surname");
const address = document.getElementById("address");

const loginError = document.getElementById("loginError");
const mdpError = document.getElementById("mdpError");
const NameFieldError = document.getElementById("NameFieldError");
const surnameError = document.getElementById("surnameError");
const addressError = document.getElementById("addressError");

login.addEventListener("blur", () => {
  if (login.value === "") {
    loginError.textContent = "Ce champs est obligatoire";
    loginError.hidden = false;
    console.log("No identifiant Error");
  }
});

mdp.addEventListener("blur", () => {
  if (mdp.value === "") {
    mdpError.textContent = "Ce champs est obligatoire";
    mdpError.hidden = false;
    console.log("No password Error");
  }
});

name.addEventListener("blur", () => {
  if (name.value === "") {
    NameFieldError.textContent = "Ce champs est obligatoire";
    NameFieldError.hidden = false;
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


mdp.addEventListener("input", () => {
  if (mdp.value !== "") {
    mdpError.textContent = ""; // Clear the error message
    mdpError.hidden = true; // Hide the error message
  }
});

name.addEventListener("input", () => {
  if (name.value !== "") {
    NameFieldError.textContent = ""; // Clear the error message
    NameFieldError.hidden = true; // Hide the error message
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



form.addEventListener("submit", function(event) {
    event.preventDefault();  // Prevent the default form submission

    let isValid = form.checkValidity();  // Checks the entire form's validity
    if (!isValid) {
      // If any field is invalid, we iterate through them
      // Find the corresponding error element
      console.log("Test email invalid");
      const errorField = document.getElementById("failed");
      if (!login.validity.valid)
        errorField.textContent = "Veuillez entrer un email valide";
      else
        errorField.textContent = "Veuillez remplir tout les champs";
      errorField.hidden = false;
    } else
        sendXHR(); // If all fields are valid, proceed with the XHR request
});

function sendXHR() {
    const xhr = getXhr();       //get the xhr response using 
    xhr.open(
      /* Method:       */ "POST",
      /* target URL :  */ window.location.origin + "/proj/controllers/registerController.php",
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
    const errorMsg = document.getElementById("failed");
    errorMsg.hidden = true;
    const userRole = document.getElementById("userRole").value; // Get the role from the hidden input
    if (response === "okEtudiant") {
        console.log("Etudiant added");
        if (userRole === "admin") {
            const successMsg = document.getElementById("success");
            successMsg.textContent = "Etudiant ajoute avec succes";
            successMsg.hidden = false;
        } else {
            window.location.href = "../pages/login.php"; // Redirect to login page for others
        }
    } else if (response === "okProf") {
        console.log("Prof added");
        if (userRole === "admin") {
            const successMsg = document.getElementById("success");
            successMsg.textContent = "Prof ajoute avec succes";
            successMsg.hidden = false;
        } else {
            window.location.href = "../pages/login.php"; // Redirect to login page for others
        }
    } else if (response === "errorEmail") {
        errorMsg.textContent = "Email existe";
        errorMsg.hidden = false;
    } else if (response === "error") {
        errorMsg.textContent = "Création du compte échouée";
        errorMsg.hidden = false;
    }
}

