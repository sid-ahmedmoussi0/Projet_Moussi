
<?php

$username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Générer un jeton de vérification
    $verif_token = md5(rand());

    // Définir l'adresse email de l'expéditeur
    $fromEmail = "moussisidahmed0@gmail.com";

    // Construire le message HTML avec le lien de réinitialisation du mot de passe
    $message = "Veuillez trouver ci-joint le lien de réinitialisation du mot de passe : 
    <a href='http://projets/geii/view/vues_entreprise/ChangerMotDePasse.php?token=$verif_token'>http://projets/geii/view/vues_entreprise/ChangerMotDePasse.php?token=$verif_token</a>";

    // Définir le destinataire, le sujet et les en-têtes du courrier
    $to = $email;
    $subject = "Réinitialisation du mot de passe";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: '.$fromEmail.'<'.$fromEmail.'>' . "\r\n".'Reply-To: '.$fromEmail."\r\n" . 'X-Mailer: PHP/' . phpversion();

    // Envoyer le courrier et vérifier le résultat
    $result = mail($to, $subject, $message, $headers);

    if ($result) {
        echo "Le courrier a été envoyé avec succès.";
    } else {
        echo "Erreur lors de l'envoi du courrier.";
    }




    ?>