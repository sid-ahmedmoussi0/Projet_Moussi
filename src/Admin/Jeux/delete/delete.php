<?php
session_start();
include('../../../ConnexionDB/connexionBd.php');

if (isset($_GET['game_id']) && $_GET['plateforme_id']) {
    $jeu_id = $_GET['game_id'];
    $plateforme_id = $_GET['plateforme_id'];

    try {
        $delete_plat = $pdo->prepare("DELETE FROM jeux_plateformes WHERE j_id = :game_id AND plateforme_id = :plateforme_id");
        $delete_plat->bindParam(':game_id', $jeu_id, PDO::PARAM_INT);
        $delete_plat->bindParam(':plateforme_id',   $plateforme_id, PDO::PARAM_INT);

        $delete_visuel = $pdo->prepare("DELETE FROM visuel WHERE j_id = :game_id");
        $delete_visuel->bindParam(':game_id', $jeu_id, PDO::PARAM_INT);

        $delete_game = $pdo->prepare("DELETE FROM jeux WHERE j_id = :game_id");
        $delete_game->bindParam(':game_id', $jeu_id, PDO::PARAM_INT);

        $delete_plat->execute();
        $delete_visuel->execute();
        $delete_game->execute();

        header("location: ../show_game.php");
        exit();
    } catch (PDOException $e) {
        echo "<p>Echec de la suppression : " . $e->getMessage() . "</p>\n";
    }
}
?>
