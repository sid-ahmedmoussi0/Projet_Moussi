<?php
session_start();


include('../../../ConnexionDB/connexionBd.php');

function moveFileToDirectory($file, $platform)
{
    $fileName = basename($file["name"]);
    $directory = "../../../../assets/img/plateforme/" . $platform . "/";
    $filePath = $directory . $fileName;
    if (move_uploaded_file($file["tmp_name"], $filePath)) {
        var_dump($filePath);
        return $filePath;
    } else {
        $_SESSION['err'] = "Erreur lors du téléchargement du visuel.";
        var_dump($filePath);
        return false;
        header("location: ./add_game.php");
        exit();
    }
}

if (isset($_POST['add_game'])) {
    if (isset($_POST['titre']) && isset($_POST['editeur']) && isset($_POST['parution']) && isset($_POST['resume']) && isset($_POST['public']) && isset($_POST['genre']) && isset($_POST['nb_joueurs'])) {
        if (empty($_POST['titre']) || empty($_POST['editeur']) || empty($_POST['parution']) || empty($_POST['resume']) || empty($_POST['public']) || empty($_POST['genre']) || empty($_POST['nb_joueurs'])) {
            $_SESSION['err'] = "Impossible d'ajouter un jeu";
            header("location: ./add_game.php");
            exit();
        } else {
            if (!isset($_POST['type_PS5']) && !isset($_POST['type_PS4']) && !isset($_POST['type_Xbox']) && !isset($_POST['type_Switch'])) {
                $_SESSION['err'] = "Le jeu doit comporter au moins une plateforme";
                header("location: ./add_game.php");
                exit();
            } else {

                $titre = $_POST['titre'];
                $editeur = $_POST['editeur'];
                $parution = $_POST['parution'];
                $resume = $_POST['resume'];
                $public = $_POST['public'];
                $genres = $_POST['genre'];
                $joueurs = $_POST['nb_joueurs'];

                $types_platform = [
                    'type_PS5' => $_POST['type_PS5'] ?? null,
                    'type_PS4' => $_POST['type_PS4'] ?? null,
                    'type_Xbox' => $_POST['type_Xbox'] ?? null,
                    'type_Switch' => $_POST['type_Switch'] ?? null,
                ];

                $visuels = [
                    'ps5' => $_FILES["visuel_ps5"] ?? null,
                    'ps4' => $_FILES["visuel_ps4"] ?? null,
                    'xbox' => $_FILES["visuel_xbox"] ?? null,
                    'switch' => $_FILES["visuel_switch"] ?? null,
                ];
                $liens_visuels = [];

                try {
                    $verify_game = $pdo->prepare("SELECT j_id FROM jeux WHERE j_titre = :titre LIMIT 1");
                    $verify_game->bindParam(':titre', $titre);
                    $verify_game->execute();

                    if ($verify_game->rowCount() > 0) {
                        $_SESSION['err'] = "Le jeu a été déjà ajouté dans la liste de jeux.";
                        header("location: ./add_game.php");
                        exit();
                    } else {

                        $ajout_jeu = $pdo->prepare("INSERT INTO jeux (j_titre, j_editeur, j_parution, j_resume, j_genre, j_public, j_joueurs) VALUES (:titre, :editeur, :parution, :resume, :genre, :public, :joueurs)");
                        $ajout_jeu->bindParam(':titre', $titre);
                        $ajout_jeu->bindParam(':editeur', $editeur);
                        $ajout_jeu->bindParam(':parution', $parution);
                        $ajout_jeu->bindParam(':resume', $resume);
                        $ajout_jeu->bindParam(':public', $public);
                        $ajout_jeu->bindParam(':joueurs', $joueurs);

                        if (is_array($genres) && !empty($genres)) {
                            $genres_json = json_encode($genres);
                            $ajout_jeu->bindParam(':genre', $genres_json);
                        } else {
                            $ajout_jeu->bindParam(':genre', $genres);
                        }

                        $ajout_jeu->execute();
                        $jeu_id = $pdo->lastInsertId();

                        foreach ($types_platform as $platform => $value) {
                            if (!empty($value)) {
                                $select_plateforme = $pdo->prepare("SELECT plateforme_id FROM plateformes WHERE nom_plateforme = :nom_plateforme");
                                $select_plateforme->bindParam(':nom_plateforme', $value);
                                $select_plateforme->execute();
                                $plateforme_id = $select_plateforme->fetchColumn();
                                $plat = $pdo->lastInsertId();

                                $insert_jeu_plateforme = $pdo->prepare("INSERT INTO jeux_plateformes (j_id, plateforme_id) VALUES (:jeu_id, :plateforme_id)");
                                $insert_jeu_plateforme->bindParam(':jeu_id', $jeu_id);
                                $insert_jeu_plateforme->bindParam(':plateforme_id', $plateforme_id);
                                $insert_jeu_plateforme->execute();
                            }
                        }

                        foreach ($visuels as $plateforme => $visuel) {
                            if (isset($visuel["tmp_name"]) && !empty($visuel["tmp_name"])) {
                                $links = moveFileToDirectory($visuel, $plateforme);
                                if (!empty($links)) {
                                    $liens_visuels[$plateforme] = $links;
                                } else {
                                    $_SESSION['err'] = "Erreur lors du téléchargement du visuel.";
                                    return;
                                    header("location: ./add_game.php");
                                    exit();
                                }
                            }
                        }
                        foreach ($liens_visuels as $plateforme => &$lien) {
                            $lien = substr($lien, 3);
                        }
                        $insert_visuel = $pdo->prepare("INSERT INTO visuel (visuel_PS5, visuel_PS4, visuel_Xbox, visuel_Switch, j_id) VALUES (:visuel_ps5, :visuel_ps4, :visuel_xbox, :visuel_switch, :j_id)");
                        $insert_visuel->bindParam(':visuel_ps5', $liens_visuels['ps5']);
                        $insert_visuel->bindParam(':visuel_ps4', $liens_visuels['ps4']);
                        $insert_visuel->bindParam(':visuel_xbox', $liens_visuels['xbox']);
                        $insert_visuel->bindParam(':visuel_switch', $liens_visuels['switch']);
                        $insert_visuel->bindParam(':j_id', $jeu_id);
                        $insert_visuel->execute();

                        header("location: /Projet_Moussi/src/index.php");
                        exit();
                    }
                } catch (PDOException $e) {
                    $_SESSION['err'] = "Echec de l'insertion :" . $e->getMessage();
                    header("location: ./add_game.php");
                    exit();
                }
            }
        }
    } else {
        $_SESSION['err'] = "Toutes les données doivent être saisies";
        header("location: ./add_game.php");
        exit();
    }
}
?>