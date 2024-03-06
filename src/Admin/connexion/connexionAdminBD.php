<?php
session_start();
include('../../ConnexionDB/connexionBd.php');


if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {

    $email = $_POST['email'];
    $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT uti_id, uti_login, uti_pwd FROM admin WHERE uti_login = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    $isPasswordCorrect = password_verify($_POST['password'], $resultat['uti_pwd']);

    if (!$resultat) {
        $_SESSION['status'] = "Email incorrect!";
        header("location:./connexionAdmin.php");
        exit();
    } else {
        if (!$isPasswordCorrect) {
            $_SESSION['status'] = "Mot de passe incorrect !";
            header("location: ./connexionAdmin.php");
            exit();
        } else {
            $_SESSION['admin_id'] =  $resultat['uti_id'];
            $_SESSION['user_admin'] =  $resultat['uti_login'];
            header("location: /Projet_Moussi/src/index.php");
            exit();
        }
    }
}
