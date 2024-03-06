<?php
session_start();
include('../../ConnexionDB/connexionBd.php');

if (isset($_POST['update_password'])) {

    $email = $_POST['email'];
    $new_pass = $_POST['new_password'];
    $check_new_pass = $_POST['check_new_password'];
    $token = $_POST['pass_token'];
    $id = $_POST['id_user'];


    if (!empty($token) && !empty($id)) {
        if (!empty($email) && !empty($new_pass) && !empty($check_new_pass)) {


            $check_token = $pdo->prepare("SELECT cli_id, verify_token FROM client WHERE verify_token = :token AND cli_id = :user_id LIMIT 1");
            $check_token->bindParam(':user_id', $id);
            $check_token->bindParam(':token', $token);
            $check_token->execute();
            if ($check_token->rowCount() > 0) {

                if ($new_pass == $check_new_pass) {
                    $hashedPassword = password_hash($new_pass, PASSWORD_DEFAULT);

                    $update_pass = $pdo->prepare("UPDATE client SET cli_pwd = :new_password WHERE verify_token = :token AND cli_id = :user_id LIMIT 1");
                    $update_pass->bindParam(':new_password', $hashedPassword);
                    $update_pass->bindParam(':user_id', $id);
                    $update_pass->bindParam(':token', $token);
                    $update_pass->execute();

                    if ($update_pass) {
                        $_SESSION['reset_status'] = 'Votre mot de passe a été mis à jour avec succès !!';
                        header("location: /Projet_Moussi/src/Client/connexion/connexionClient.php");
                        exit();
                    } else {
                        $_SESSION['reset_status'] = 'Impossible de mettre à jour le mot de passe';
                        header("location: ./resetPassword.php?token=$token&id=$id");
                        exit();
                    }
                } else {
                    $_SESSION['reset_status'] = 'Mot de passe ne sont pas les mêmes';
                    header("location: ./resetPassword.php?token=$token&id=$id");
                    exit();
                }
            } else {
                $_SESSION['reset_status'] = 'Token invalide ou ID incorrect';
                header("location: ./resetPassword.php?token=$token&id=$id");
                exit();
            }
        } else {
            $_SESSION['reset_status'] = 'Tous les champs sont requis';
            header("location: ./resetPassword.php?token=$token&id=$id");
            exit();
        }
    } else {
        $_SESSION['reset_status'] = 'Token ou ID manquant';
        header("location: ./resetPassword.php?token=$token&id=$id");
        exit();
    }
}
