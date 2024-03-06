<?php
session_start();
include('../../ConnexionDB/connexionBd.php');

if (!isset($_SESSION['user_id'])) {
    header('Location:/Projet_Moussi/src/Client/connexion/connexionClient.php');
    exit();
}

if (isset($_POST['j_id']) && isset($_POST['rating'])) {

    $jeuId = $_POST['j_id'];
    $rating = $_POST['rating'];
    $client_id = $_SESSION['user_id'];

    $avisExist = $pdo->prepare("SELECT COUNT(*) AS num_rows FROM notation_jeu WHERE j_id = :j_id AND cli_id = :cli_id");
    $avisExist->bindParam(':j_id', $jeuId);
    $avisExist->bindParam(':cli_id', $client_id);
    $avisExist->execute();
    $result = $avisExist->fetch(PDO::FETCH_ASSOC);
    if ($result['num_rows'] > 0) {
        $response['success'] = false;
        $response['message'] = "Votre notation à déjà été prise en compte";
    } else {
        $notation = $pdo->prepare("INSERT INTO notation_jeu (note, j_id, cli_id) VALUES (:note, :j_id, :cli_id)");
        $notation->bindParam(':note', $rating);
        $notation->bindParam(':j_id', $jeuId);
        $notation->bindParam(':cli_id', $client_id);
        if ($notation->execute()) {
            $response['success'] = true;
            $response['message'] = " Votre notation prise en compte.";
        } else {
            $response['success'] = false;
            $response['message'] = "Veuillez donner une note au jeux";
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = "Données manquantes";
}
echo json_encode($response);
