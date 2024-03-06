/*--Fonction pour visualiser le mot de passe saisit--*/ 
function show_password() {
  var pass = document.getElementById("password");
  var show_eye = document.getElementById("togglePassword");
  var hide_eye = document.getElementById("hide_eye");

  if (pass.type === "password") {
    pass.type = "text";
    show_eye.style.display = "block";
    hide_eye.style.display = "none";
  } else {
    pass.type = "password";
    show_eye.style.display = "none";
    hide_eye.style.display = "block";
  }
}

function show_confirm_password() {
  var pass = document.getElementById("confirm_password");
  var show_eye = document.getElementById("confirm_togglePassword");
  var hide_eye = document.getElementById("confirm_hide_eye");

  if (pass.type === "password") {
    pass.type = "text";
    show_eye.style.display = "block";
    hide_eye.style.display = "none";
  } else {
    pass.type = "password";
    show_eye.style.display = "none";
    hide_eye.style.display = "block";
  } 
}
