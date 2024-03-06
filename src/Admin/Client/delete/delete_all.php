<?php
session_start();
include('../../../ConnexionDB/connexionBd.php');

//Suppression en fonction des clients sélectionnés
if (isset($_POST['delete_all'])) {
    $data = $_POST['options'];
    $data_id = implode(',', $data);

    $delete_all = $pdo->prepare("DELETE * FROM client WHERE client_id IN($data_id)");
    $delete_all->execute();

    if ($delete_all) {
        $_SESSION['information'] = "Suppression effectuée";
        header("Location: ../show_clients.php");
    } else {
        $_SESSION['information'] = "Erreur lors de la suppression";
    }
}
?>