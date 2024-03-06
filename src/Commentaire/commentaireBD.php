<?php
session_start();
include('../ConnexionDB/connexionBd.php');

if (!isset($_SESSION['user_id'])) {
    header('Location:/Projet_Moussi/src/Client/connexion/connexionClient.php');
    exit();
}

if (isset($_SESSION['user_username']) && !empty($_SESSION['user_username'])) {
    if (isset($_POST['msg']) && !empty($_POST['msg']) && isset($_POST['j_id'])) {
        $message = $_POST['msg'];
        $client_id = $_SESSION['user_id'];
        $jeux_id = $_POST['j_id'];

        $comment = $pdo->prepare("INSERT INTO commentaire_jeux (commentaire, j_id, cli_id) VALUES (:commentaire, :j_id, :cli_id)");
        $comment->bindParam(':commentaire', $message);
        $comment->bindParam(':j_id', $jeux_id);
        $comment->bindParam(':cli_id', $client_id);

        if ($comment->execute()) {
            $response['success'] = true;
            $response['message'] = "Commentaire ajouté avec succès.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Veuillez saisir un commentaire.";
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Veuillez vous connecter pour accéder à la partie commentaire.';
}
echo json_encode($response);
