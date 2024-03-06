<?php
session_start();
include('../../ConnexionDB/connexionBd.php');

function send_password_reset($get_username, $get_email, $token, $get_id)
{
    $fromEmail = "testsmtp49687@gmail.com";

    $message = "Bonjour " . $get_username . ",<br><br>
    Vous avez demandé une réinitialisation de votre mot de passe sur notre site. Pour changer votre mot de passe, veuillez cliquer sur le lien ci-dessous :<br><br>
    <a href='http://localhost/Projet_MOUSSI/src/Client/resetPassword/resetPassword.php?token=$token&id=$get_id'>Réinitialiser votre mot de passe</a><br><br>
    Si vous n'avez pas demandé cette réinitialisation, veuillez ignorer cet email.<br><br>
    Cordialement,<br>L'équipe de QuantumGamerShop";

    $to = $get_email;
    $subject = "Demande de réinitialisation de mot de passe!!!";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: ' . $fromEmail . ' <' . $fromEmail . '>' . "\r\n" . 'Reply-To: ' . $fromEmail . "\r\n" . 'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
}

if (isset($_POST['sendMailBtn'])) {

    $email_reset = $_POST['email'];
    $token = md5(rand());

    $check_email = $pdo->prepare("SELECT cli_id, cli_username, cli_mail FROM client WHERE cli_mail = :email LIMIT 1");
    $check_email->bindParam(':email', $email_reset);
    $check_email->execute();

    if ($check_email->rowCount() > 0) {
        $row = $check_email->fetch(PDO::FETCH_ASSOC);
        $get_username = $row['cli_username'];
        $get_email = $row['cli_mail'];
        $get_id = $row['cli_id'];

        $update_token = $pdo->prepare("UPDATE client SET verify_token = :update_token WHERE cli_mail = '$get_email'  LIMIT 1");
        $update_token->bindParam(':update_token', $token);
        $update_token->execute();

        if ($update_token) {
            send_password_reset($get_username, $get_email, $token,$get_id );
            $_SESSION['reset_status'] = 'Un lien vous a été transmis par mail pour modifier votre mot de passe.';
            $_SESSION['email'] = $row['cli_mail'];
            header("location: /Projet_Moussi/src/Client/resetPassword/email_reset_succes.php");

            exit();
        } else {
            $_SESSION['reset_status'] = 'Une erreur s\'est produite.';
            header("location: /Projet_Moussi/src/Client/connexion/connexionClient.php");
            exit();
        }
    } else {
        $_SESSION['reset_status'] = 'L\'adresse mail saisit n\'a pas été trouvé';
        header("location: /Projet_Moussi/src/Client/connexion/connexionClient.php");
        exit();
    }
}
