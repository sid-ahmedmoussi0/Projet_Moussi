$(document).ready(function () {
  var input_genre = $("#genre_container");
  var inputCount = input_genre.find(".input-group").length;

  input_genre.on("click", ".btn_add", function () {
    var inputGroup = $(this).closest(".input-group");

    inputGroup.after(
      "<div class='input-group'>" +
        "<input class='form-control input-genre' id='genre" +
        inputCount +
        "'name='genre[]' type='text' placeholder='Veuillez saisir le genre du jeu'>" +
        "<div class='btn-add-remove'>" +
        "<button type='button' class='btn btn-primary btn-sm btn_add'>" +
        "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus' viewBox='0 0 16 16'>" +
        "<path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4' />" +
        "</svg>" +
        "</button>" +
        "<button type='button' class='btn btn-danger btn-sm btn_remove'>" +
        "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x' viewBox='0 0 16 16'>" +
        "<path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708'/>" +
        "</svg>" +
        "</button>" +
        "</div>" +
        "</div>"
    );

    inputCount++;
  });

  input_genre.on("click", ".btn_remove", function () {
    var inputGroup = $(this).closest(".input-group");

    if (inputCount >= 2) {
      inputGroup.remove();
      inputCount--;
    } else {
      alert("Impossible de supprimer le champ du formulaire");
    }
  });
});
