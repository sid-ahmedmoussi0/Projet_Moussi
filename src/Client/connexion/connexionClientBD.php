<?php
session_start();
include('../../ConnexionDB/connexionBd.php');

if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {

    $email = $_POST['email'];
    $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT cli_id, cli_username, cli_mail, cli_pwd, verify_status FROM client WHERE cli_mail = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    $isPasswordCorrect = password_verify($_POST['password'], $resultat['cli_pwd']);

    if (!$resultat) {
        $_SESSION['status'] = "Email incorrect!";
        header("location:./connexionClient.php");
        exit();
    } else {

        if ($resultat['verify_status'] == "0") {
            $_SESSION['status'] = "Votre compte n'a pas été vérifié. Veuillez vérifier votre e-mail.";
            $_SESSION['error'] = true;
            header("location: ./connexionClient.php");
            exit();
        }

        if (!$isPasswordCorrect) {
            $_SESSION['status'] = "Mot de passe incorrect !";
            $_SESSION['error'] = true;
            header("location: ./connexionClient.php");
            exit();
        } else {
            $_SESSION['user_id'] =  $resultat['cli_id'];
            $_SESSION['user_username'] =   $resultat['cli_username'];

            if (!empty($_POST['remember_me']) && $_POST['remember_me'] === 'on') {
                $cookie_name = "user_email";
                $cookie_value = $email;
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
            }

            header("location: /Projet_Moussi/src/index.php");
            exit();
        }
    }
}
?>
