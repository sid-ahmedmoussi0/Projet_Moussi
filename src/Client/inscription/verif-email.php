<?php
session_start();
include('../../ConnexionDB/connexionBd.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $verify_query = $pdo->prepare("SELECT verify_token, verify_status FROM client WHERE verify_token = :token LIMIT 1");
    $verify_query->bindParam(':token', $token);
    $verify_query->execute();

    $rowCount = $verify_query->rowCount();

    if ($rowCount > 0) {
        $row = $verify_query->fetch(PDO::FETCH_ASSOC);
        // echo $row['verify_token'];
        if ($row['verify_status'] == "0") {
            // $clicked_token = $row['verify_status'];
            $up_query = $pdo->prepare("UPDATE client SET verify_status='1' WHERE verify_token=:token LIMIT 1");
            $up_query->bindParam(':token', $token);
            $up_query->execute();

            if ($up_query) {
                $_SESSION['status'] = 'Votre compte a été vérifié';
                header("location: ../connexion/connexionClient.php");
                exit();
            } else {
                $_SESSION['status'] = 'Erreur lors de la mise à jour du statut de vérification';
                header("location: ../connexion/connexionClient.php");
                exit();
            }
        } else {
            $_SESSION['status'] = 'Email déjà vérifié. Veuillez vous connecter';
            header("location: ../connexion/connexionClient.php");
            exit();
        }
    } else {
        $_SESSION['status'] = 'Ce jeton n\'existe pas';
        header("location: ../connexion/connexionClient.php");
        exit();
    }
} else {
    $_SESSION['status'] = 'Non autorisé';
    header("location: '../../connexion/connexionClient.php");
    exit();
}
