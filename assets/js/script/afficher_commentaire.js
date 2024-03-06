function addSeparator() {
  var separator = $("<hr>").addClass("comment-separator");
  $(".commentaires-section").after(separator);
}

function removeSeparator() {
  $(".comment-separator").remove();
}
