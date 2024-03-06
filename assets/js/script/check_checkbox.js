$(document).ready(function () {
  var elements = document.querySelectorAll('[id^="type_"]');

  for (var i = 0; i < elements.length; i++) {
    (function () {
      var currentElement = elements[i];
      var platform = currentElement.id.split("_")[1];
      var containerID = "#visuelContainer_" + platform;
      var isChecked = currentElement.checked;

      if (isChecked) {
        $(containerID).show();
      } else {
        $(containerID).hide();
      }

      $(currentElement).change(function () {
        if (this.checked) {
          $(containerID).show();
        } else {
          $(containerID).hide();
        }
      });
    })();
  }
  $("button[type='submit']").before("<br>");
});
