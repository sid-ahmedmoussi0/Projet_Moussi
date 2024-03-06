/*--Transmettre les commentaires saisit par chaque clients--*/
$(document).ready(function() {
    $('.post-comment').click(function() {
       var message = $(this).closest('.commentaires-section').find('#content_comment').val();
        var j_id = $(this).closest('.footer-tabs').find('input[name="j_id"]').val(); 
        $.ajax({
            type: 'POST',
            url: '/Projet_MOUSSI/src/Commentaire/commentaireBD.php',
            data: {
                msg: message,
                j_id: j_id
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    alert("Commentaire ajouté avec succès.");
                } else {
                    alert("Erreur : " + data.message);
                }
            },
            error: function(xhr, status, error) {
                alert("Une erreur s'est produite lors de l'envoi du commentaire : " + error);
            }
        });
    });
});