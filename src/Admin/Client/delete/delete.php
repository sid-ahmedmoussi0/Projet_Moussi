<?php
session_start();
include('../../../ConnexionDB/connexionBd.php');

if (isset($_GET['client_id'])) {
    $cli_id = $_GET['client_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM client WHERE cli_id = :id");
        $stmt->bindParam(':id', $cli_id, PDO::PARAM_INT);
        $stmt->execute();
        header("location: ../show_clients.php");
    } catch (PDOException $e) {
        echo "<p>Echec de la suppression : " . $e->getMessage() . "</p>\n";
    }
}
?>