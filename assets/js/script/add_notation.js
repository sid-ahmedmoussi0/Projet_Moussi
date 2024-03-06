let stars = document.getElementsByClassName("star");
let currentRating = 0;

/*--Fonction pour pour noter un jeu--*/
function notation(n) {
  currentRating = n;
  remove();
  for (let i = 0; i < n; i++) {
    let cls = "";
    if (n === 1) cls = "one";
    else if (n === 2) cls = "two";
    else if (n === 3) cls = "three";
    else if (n === 4) cls = "four";
    else if (n === 5) cls = "five";
    stars[i].className = "star " + cls;
  }
}
/*--Fonction pour réinitialiser la notation à la fermeture du modal--*/
function remove() {
  var starContainer = document.getElementById("notationModal");
  var stars = starContainer.getElementsByClassName("star");
  for (let i = 0; i < stars.length; i++) {
    stars[i].className = "star";
  }
}

$("#notationModal").on("hidden.bs.modal", function (e) {
  remove();
  currentRating = 0;
});

/*--Fonction pour transmettre la notaion d'un client--*/
function submitRating() {
  if (currentRating === 0) {
    alert("Veuillez sélectionner une");
  }
  var jeuId = document.querySelector('input[name="j_id"]').value;
  $.ajax({
    type: "POST",
    url: "/Projet_MOUSSI/src/Jeux/Afficher/notation_jeu.php",
    data: {
      rating: currentRating,
      j_id: jeuId,
    },
    success: function (response) {
      var data = JSON.parse(response);

      if (data.success) {
        alert(data.message);
        $("#notationModal").modal("hide");
        remove();
        currentRating = 0;
      } else {
        alert("Erreur" + data.message);
      }
    },
    error: function (xhr, status, error) {
      alert(
        "Une erreur s'est produite lors de l'envoi du commentaire : " + error
      );
    },
  });
}
