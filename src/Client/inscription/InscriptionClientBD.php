<?php
session_start();
include('../../ConnexionDB/connexionBd.php');

function sendmail_check($username, $email, $verif_token)
{
    $fromEmail = "testsmtp49687@gmail.com";

    $message = "Bonjour " . $username . ",<br><br>
    Merci de vous être inscrit sur notre site. Pour finaliser votre inscription, veuillez cliquer sur le lien ci-dessous :<br><br>
    <a href='http://localhost/Projet_MOUSSI/src/Client/inscription/verif-email.php?token=$verif_token'>Vérifier votre compte</a><br><br>
    Si vous n'avez pas créé de compte, veuillez ignorer cet email.<br><br>
    Cordialement,<br>L'équipe de Moussi";

    $to = $email;
    $subject = "Bienvenue sur notre site, " . $username;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: ' . $fromEmail . ' <' . $fromEmail . '>' . "\r\n" . 'Reply-To: ' . $fromEmail . "\r\n" . 'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
}

if (isset($_POST['name']) && isset($_POST['firstname']) && isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password'])) {

    $name = $_POST['name'];
    $firstname = $_POST['firstname'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verif_token = md5(rand());

    $check_info = $pdo->prepare("SELECT cli_username, cli_mail FROM client WHERE cli_mail = :email OR cli_username = :username LIMIT 1");
    $check_info->bindParam(':email', $email);
    $check_info->bindParam(':username', $username);
    $check_info->execute();

    if ($check_info->rowCount() > 0) {
        $row = $check_info->fetch(PDO::FETCH_ASSOC);

        if ($row['cli_username'] == $username) {
            $_SESSION['status'] = 'le nom d\'utilisateur ' . $username . ' à déjà été utilisé';
            $_SESSION['error'] = true;
            header("location: InscriptionClient.php");
        } else if ($row['cli_mail'] == $email) {
            $_SESSION['status'] = 'L\'adresse mail ' . $email . ' est déjà existante';
            $_SESSION['error'] = true;
            header("location: InscriptionClient.php");
        }
    } else {
        $pwd = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO client (cli_nom, cli_prenom, cli_username, cli_telephone, cli_mail, cli_pwd, verify_token) VALUES(:nom, :prenom, :username, :telephone, :email,  :password,  :verif_token ) ");
        $stmt->bindParam(':nom', $name);
        $stmt->bindParam(':prenom', $firstname);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':telephone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $pwd);
        $stmt->bindParam(':verif_token', $verif_token);
        $stmt->execute();

        if ($stmt) {
            sendmail_check($username, $email, $verif_token);
            $_SESSION['status'] = 'Inscription Réussie ';
            $_SESSION['msg'] = 'Veuillez vérifier vos mail';
            header("location: inscription_succes.php");
            exit();
        } else {
            $_SESSION['status'] = 'Echoue de votre Inscription';
            header("location: InscriptionClient.php");
            $_SESSION['error'] = true;
            exit();
        }
    }
} else {
    $_SESSION['status'] = "Toutes les données doivent être renseignées";
    header("location: InscriptionClient.php");
    $_SESSION['error'] = true;
    exit();
}
?>