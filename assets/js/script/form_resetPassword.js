const email = document.querySelector("#email");
const new_password = document.querySelector("#new_password");
const check_new_password = document.querySelector("#check_new_password");

email.addEventListener("input", () => resetError(email));
new_password.addEventListener("input", () => resetError(new_password));
check_new_password.addEventListener("input", () =>
  resetError(check_new_password)
);

form.addEventListener("submit", (e) => {
  const isValid = form_verify();

  if (!isValid) {
    e.preventDefault();
  }
});

/*--Fonction pour vérifier chaque champ lors de la réinitialisation du mot de passe--*/
function form_verify() {
  const emailValue = email.value.trim();
  const new_passwordValue = new_password.value.trim();
  const check_new_passwordValue = check_new_password.value.trim();

  /*--Vérification de l'email--*/
  if (emailValue === "") {
    let message = "Veuillez saisir votre email";
    setError(email, message);
  } else {
    setSuccess(email);
  }

  /*--Vérification du mot de passe--*/
  if (new_passwordValue === "") {
    let message = "Veuillez saisir votre nouveau mot de passe";
    setError(new_password, message);
  } else if (
    new_passwordValue.length < 10 ||
    !new_passwordValue.match(/[0-9]/g) ||
    !new_passwordValue.match(/[A-Z]/g) ||
    !new_passwordValue.match(/[a-z]/g) ||
    !new_passwordValue.match(/[^a-zA-Z\d]/g)
  ) {
    let message =
      "Le mot de passe doit contenir 10 caractères dont 1 chiffre, 1 caractère spécial, 1 majuscule";
    setError(new_password, message);
  } else {
    setSuccess(new_password);
  }

  /*--Vérification de la confirmation du mot de passe--*/
  if (check_new_passwordValue === "") {
    let message = "Veuillez saisir à nouveau votre mot de passe";
    setError(check_new_password, message);
  } else if (check_new_passwordValue !== new_passwordValue) {
    let message = "Les mots de passe ne correspondent pas";
    setError(check_new_password, message);
  } else {
    setSuccess(check_new_password);
  }

  return !document.querySelector(".input-group.error");
}

/*--Fonction pour afficher les messages d'erreurs--*/
function setError(elem, message) {
  const inputGroup = elem.parentElement;
  const small = inputGroup.querySelector("small");
  small.innerText = message;
  inputGroup.className = "input-group error";
}

/*--Fonction pour afficher les messages en cas de succès--*/
function setSuccess(elem) {
  const inputGroup = elem.parentElement;
  inputGroup.className = "input-group success";
}

function resetError(elem) {
  const inputGroup = elem.parentElement;
  const small = inputGroup.querySelector("small");
  small.innerText = "";
  inputGroup.className = "input-group";
}
