<?php
session_start();
include("../ConnexionDB/connexionBd.php");

if (!isset($_SESSION['user_id'])) {
    header('Location:/Projet_Moussi/src/Client/connexion/connexionClient.php');
    exit();
}

if (isset($_GET['location'])) {
    $id = $_GET['location'];
    try {
        $stmt = $pdo->prepare("DELETE FROM location WHERE loc_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $get_info = $pdo->prepare("SELECT j_id, plateforme_id FROM location WHERE loc_id = :id");
        $get_info->bindParam(':id', $id, PDO::PARAM_INT);
        $get_info->execute();
        $row = $get_info->fetch(PDO::FETCH_ASSOC);
        $id_loue = $row['j_id'];
        $id_plateforme = $row['plateforme_id'];

        $update_quantity = $pdo->prepare("UPDATE jeux_plateformes SET quantite_jeux = quantite_jeux + 1 WHERE j_id = :id_loue AND plateforme_id = :id_plateforme");
        $update_quantity->bindParam(':id_loue', $id_loue);
        $update_quantity->bindParam(':id_plateforme', $id_plateforme);
        $update_quantity->execute();

        header('Location:/Projet_Moussi/src/Client/Jeux/show_game_locate.php');
        exit();
    } catch (PDOException $e) {
        echo "<p>Echec de la suppression : " . $e->getMessage() . "</p>\n";
    }
}
?>