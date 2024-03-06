<?php
session_start();
include('../../../ConnexionDB/connexionBd.php');

if (isset($_POST['delete_all'])) {
    $data = $_POST['options'];
    $data_id = implode(',', $data);

    $delete_all = $pdo->prepare("DELETE * FROM jeux WHERE jeux_id IN($data_id)");
    $delete_all->execute();

    if ($delete_all) {
        $_SESSION['information'] = "Suppression effectuée";
        header("Location: ../show_game.php");
    } else {
        $_SESSION['information'] = "Erreur lors de la suppression";
    }
}
?>