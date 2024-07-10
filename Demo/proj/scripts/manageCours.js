import getXhr from "./XHR.js";


const form = document.getElementById("coursForm");

const login = document.getElementById("title");
const mdp = document.getElementById("desc");


const loginError = document.getElementById("titleError");
const mdpError = document.getElementById("descError");

const errorField = document.getElementById("failed");
const successField = document.getElementById("success");

login.addEventListener("blur", () => {
  if (login.value === "") {
    loginError.textContent = "Ce champs est obligatoire";
    loginError.hidden = false;
    console.log("No title Error");
  }
});

mdp.addEventListener("blur", () => {
  if (mdp.value === "") {
    mdpError.textContent = "Ce champs est obligatoire";
    mdpError.hidden = false;
    console.log("No desc Error");
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


form.addEventListener("submit", function(event) {
    event.preventDefault();  // Prevent the default form submission

    successField.hidden = true;
    errorField.hidden = true;

    let isValid = form.checkValidity();  // Checks the entire form's validity
    if (!isValid) {
      console.log("Champs non remplis");
      errorField.textContent = "Veuillez remplir tout les champs";
      errorField.hidden = false;
    } else
        sendXHR(); // If all fields are valid, proceed with the XHR request
});

function sendXHR() {
  const xhr = getXhr();      
  xhr.open("POST", "../../controllers/addCours.php", true);

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
    const cleanResponse = response.trim().toLowerCase();

    if (cleanResponse === "ok") {
      successField.textContent = "Cours ajoute avec succees";
      successField.hidden = false;
      errorField.hidden = true;
      fetchCourses();
    } else if (cleanResponse === "already exist") {
      errorField.textContent = "Un cours avec le meme titre existe deja";
      errorField.hidden = false;
    } else {
      errorField.textContent = "Erreur";
      errorField.hidden = false;
      successField.hidden = true;
    }
}

