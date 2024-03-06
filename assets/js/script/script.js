const form = document.querySelector("#form");
const lastname = document.querySelector("#name");
const firstname = document.querySelector("#firstname");
const username = document.querySelector("#username");
const phone = document.querySelector("#phone");
const email = document.querySelector("#email");
const verif_email = document.querySelector("#confirm_email");
const password = document.querySelector("#password");
const verif_password = document.querySelector("#confirm_password");

lastname.addEventListener("input", () => resetError(lastname));
firstname.addEventListener("input", () => resetError(firstname));
username.addEventListener("input", () => resetError(username));
phone.addEventListener("input", () => resetError(phone));
email.addEventListener("input", () => resetError(email));
verif_email.addEventListener("input", () => resetError(verif_email));
password.addEventListener("input", () => resetError(password));
verif_password.addEventListener("input", () => resetError(verif_password));

form.addEventListener("submit", (e) => {
  const isValid = form_verify();

  if (!isValid) {
    e.preventDefault();
  }
});

/*--Fonction pour vérifier chaque champ lors de l'inscription de chaque clients--*/
function form_verify() {
  const lastnameValue = lastname.value.trim();
  const firstnameValue = firstname.value.trim();
  const usernameValue = username.value.trim();
  const phoneValue = phone.value.trim();
  const emailValue = email.value.trim();
  const verif_emailValue = verif_email.value.trim();
  const passwordValue = password.value.trim();
  const verif_passwordValue = verif_password.value.trim();

  /*--Vérification du nom--*/
  if (lastnameValue === "") {
    let message = "Veuillez saisir votre nom";
    setError(lastname, message);
  } else if (!lastnameValue.match(/^[A-Z]/)) {
    console.log(lastnameValue);
    console.log(firstnameValue);
    console.log(phoneValue);
    let message = "Votre nom d doit commencer par une majuscule";
    setError(lastname, message);
  } else {
    setError(lastname, "");
    setSuccess(lastname);
  }

  /*--Vérification du prénom--*/
  if (firstnameValue === "") {
    let message = "Veuillez saisir votre prénom";
    setError(firstname, message);
  } else if (!firstnameValue.match(/^[A-Z]/)) {
    let message = "Votre nom d doit commencer par une majuscule";
    setError(firstname, message);
  } else {
    setError(firstname, "");
    setSuccess(firstname);
  }

  /*--Vérification du nom d'utilisateur--*/
  if (usernameValue === "") {
    let message = "Veuillez saisir votre nom d'utilisateur";
    setError(username, message);
  } else if (!usernameValue.match(/^[A-Z]/)) {
    let message = "Votre nom d'utilisateur doit commencer par une majuscule";
    setError(username, message);
  } else {
    setError(username, "");
    setSuccess(username);
  }

  /*--Vérification du numéro de téléphone--*/
  if (phoneValue === "") {
    let message = "Veuillez saisir un numéro de téléphone";
    setError(phone, message);
  } else if (!phoneValue.match(/^\d[10]$/)) {
    let message = "Veuillez saisir un numéro de téléphone valide";
    setError(phone, message);
  } else {
    setError("");
    setSuccess(phone);
  }

  /*--Vérification de l'email--*/
  if (emailValue === "") {
    let message = "Veuillez saisir votre email";
    setError(email, message);
  } else {
    setSuccess(email);
  }

  /*--Vérification de la confirmation de l'email--*/
  if (verif_emailValue === "") {
    let message = "Veuillez saisir à nouveau votre email";
    setError(verif_email, message);
  } else if (verif_emailValue !== emailValue) {
    let message = "Les adresses email ne correspondent pas";
    setError(verif_email, message);
  } else {
    setSuccess(verif_email);
  }

  /*--Vérification du mot de passe--*/
  if (passwordValue === "") {
    let message = "Veuillez saisir votre mot de passe";
    setError(password, message);
  } else if (
    passwordValue.length < 10 ||
    !passwordValue.match(/[0-9]/g) ||
    !passwordValue.match(/[A-Z]/g) ||
    !passwordValue.match(/[a-z]/g) ||
    !passwordValue.match(/[^a-zA-Z\d]/g)
  ) {
    let message = "10 caractères (chiffre, caractère spécial, majuscule)";
    setError(password, message);
  } else {
    setSuccess(password);
  }

  /*--Vérification de la confirmation du mot de passe--*/
  if (verif_passwordValue === "") {
    let message = "Veuillez saisir à nouveau votre mot de passe";
    setError(verif_password, message);
  } else if (verif_passwordValue !== passwordValue) {
    let message = "Les mots de passe ne correspondent pas";
    setError(verif_password, message);
  } else {
    setSuccess(verif_password);
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
