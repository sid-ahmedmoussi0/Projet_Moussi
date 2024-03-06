<?php
session_start();
include('.././../../ConnexionDB/connexionBd.php');
function moveFileToDirectory($file, $platform)
{
    $fileName = basename($file["name"]);
    $directory = "../../../assets/img/plateforme/" . $platform . "/";
    $filePath = $directory . $fileName;

    if (move_uploaded_file($file["tmp_name"], $filePath)) {
        return $filePath;
    } else {
        $_SESSION['err'] = "Erreur lors du téléchargement du visuel.";
        return false;
    }
}

if (isset($_POST['modify_game'])) {
    if (isset($_POST['jeux_id']) && isset($_POST['new_titre']) && isset($_POST['new_editeur']) && isset($_POST['new_parution']) && isset($_POST['new_resume']) && isset($_POST['new_public']) && isset($_POST['genre']) && isset($_POST['new_nb_joueurs'])) {
        if (!empty($_POST['jeux_id'])) {
            $game_id = $_POST['jeux_id'];
            $titre = $_POST['new_titre'];
            $editeur = $_POST['new_editeur'];
            $parution = $_POST['new_parution'];
            $resume = $_POST['new_resume'];
            $public = $_POST['new_public'];
            $genre = $_POST['new_genre'];
            $nb_joueurs = $_POST['new_nb_joueurs'];

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

            try {
                $updates = [];
                $bindParams = [];

                if (!empty($_POST['new_titre'])) {
                    $updates[] = "j_titre = :new_titre";
                    $bindParams[':new_titre'] = $titre;
                }
                if (!empty($_POST['new_editeur'])) {
                    $updates[] = "j_editeur = :new_editeur";
                    $bindParams[':new_editeur'] = $editeur;
                }
                if (!empty($_POST['new_parution'])) {
                    $updates[] = "j_parution = :new_parution";
                    $bindParams[':new_parution'] = $parution;
                }
                if (!empty($_POST['new_resume'])) {
                    $updates[] = "j_resume = :new_resume";
                    $bindParams[':new_resume'] = $resume;
                }
                if (!empty($_POST['new_public'])) {
                    $updates[] = "j_public = :new_public";
                    $bindParams[':new_public'] = $public;
                }
                if (!empty($_POST['new_genre'])) {
                    if (is_array($genre)) {
                        $genres_json = json_encode($genre);
                        $updates[] = "j_genre = :new_genre";
                        $bindParams[':new_genre'] = $genres_json;
                    } else {
                        $updates[] = "j_genre = :new_genre";
                        $bindParams[':new_genre'] = $genre;
                    }
                }
                if (!empty($_POST['new_nb_joueurs'])) {
                    $updates[] = "j_joueurs = :new_nb_joueurs";
                    $bindParams[':new_nb_joueurs'] = $nb_joueurs;
                }

                $sql = "UPDATE jeux SET " . implode(", ", $updates) . " WHERE j_id = :game_id";
                $bindParams[':game_id'] = $game_id;

                $stmt = $pdo->prepare($sql);

                foreach ($bindParams as $param => &$value) {
                    $stmt->bindParam($param, $value);
                }

                $stmt->execute();

                $selectVisuels = $pdo->prepare("SELECT * FROM visuel WHERE j_id = :game_id");
                $selectVisuels->bindParam(':game_id', $game_id);
                $selectVisuels->execute();
                $existingVisuels = $selectVisuels->fetch(PDO::FETCH_ASSOC);

                $visuelsUpdates = [];
                $visuelsBindParams = [];
                foreach ($visuels as $plateforme => $visuel) {
                    if (isset($visuel["tmp_name"]) && !empty($visuel["tmp_name"])) {
                        $links = moveFileToDirectory($visuel, $plateforme);
                        if (!empty($links)) {
                            $visuelsUpdates[] = "visuel_" . strtoupper($plateforme) . " = :visuel_" . $plateforme;
                            $visuelsBindParams[':visuel_' . $plateforme] = $links;
                        } else {
                            $_SESSION['err'] = "Erreur lors du téléchargement du visuel.";
                            return;
                            header("location: ./edit_gameBD.php");
                            exit();
                        }
                    } else {
                        $visuelsUpdates[] = "visuel_" . strtoupper($plateforme) . " = :visuel_" . $plateforme;
                        $visuelsBindParams[':visuel_' . $plateforme] = $existingVisuels["visuel_" . $plateforme];
                    }
                }

                if (!empty($visuelsUpdates)) {
                    $visuelsSql = "UPDATE visuel SET " . implode(", ", $visuelsUpdates) . " WHERE j_id = :game_id";
                    $stmtVisuels = $pdo->prepare($visuelsSql);
                    $visuelsBindParams[':game_id'] = $game_id;
                    foreach ($visuelsBindParams as $param => &$value) {
                        $stmtVisuels->bindParam($param, $value);
                    }
                    $stmtVisuels->execute();
                }
                foreach ($types_platform as $platform => $values) {
                    if (!empty($values)) {
                        $select_plateforme = $pdo->prepare("SELECT plateforme_id FROM plateformes WHERE nom_plateforme = :nom_plateforme");
                        $select_plateforme->bindParam(':nom_plateforme', $values);
                        $select_plateforme->execute();
                        $plateforme_id = $select_plateforme->fetchColumn();

                        $check_association = $pdo->prepare("SELECT COUNT(*) FROM jeux_plateformes WHERE j_id = :game_id AND plateforme_id = :plateforme_id");
                        $check_association->bindParam(':game_id', $game_id);
                        $check_association->bindParam(':plateforme_id', $plateforme_id);
                        $check_association->execute();
                        $association_exists = $check_association->fetchColumn();

                        if (!$association_exists) {
                            $insert_jeu_plateforme = $pdo->prepare("INSERT INTO jeux_plateformes (j_id, plateforme_id) VALUES (:game_id, :plateforme_id)");
                            $insert_jeu_plateforme->bindParam(':game_id', $game_id);
                            $insert_jeu_plateforme->bindParam(':plateforme_id', $plateforme_id);
                            $insert_jeu_plateforme->execute();
                        }
                    }
                }
                header("Location: ../show_game.php");
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            $_SESSION["erreur"] = "Aucun jeu trouvé";
            header("location: edit_game.php");
            exit();
        }
    } else {
        $_SESSION["erreur"] = "Toutes les données doivent d'être transmises";
        header("location: edit_game.php");
        exit();
    }
}
?>