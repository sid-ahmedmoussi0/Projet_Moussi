<?php session_start() ?>
<?php include('../../ConnexionDB/connexionBd.php'); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des jeux</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Jeux/game_details.css" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Header/style.css" type="text/css" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Footer/footer.css" type="text/css" />
</head>

<?php include('../../header.php'); ?>

<body>
    <div class="container mt-5">
        <div class="row">
            <?php
            if (isset($_GET['id']) && isset($_GET['plateforme_id'])) {
                $jeu_id = $_GET['id'];
                $plateforme_id = $_GET['plateforme_id'];

                $stmt = $pdo->prepare("SELECT j.*, v.* FROM jeux j 
                                       LEFT JOIN visuel v ON j.j_id = v.j_id
                                       INNER JOIN jeux_plateformes jp ON j.j_id = jp.j_id
                                       WHERE j.j_id = :jeu_id AND jp.plateforme_id = :plateforme_id");
                $stmt->bindParam(':jeu_id', $jeu_id);
                $stmt->bindParam(':plateforme_id', $plateforme_id);
                $stmt->execute();

                $stmt_location = $pdo->prepare("SELECT * FROM location WHERE jeu_id = :jeu_id AND plateforme_id = :plateforme_id ");
                $stmt_location->bindParam(':jeu_id', $jeu_id);
                $stmt_location->bindParam(':plateforme_id', $plateforme_id);
                $stmt_location->execute();
                $jeu_loue = $stmt_location->rowCount() > 0;
                if ($jeu_loue) {
                    $location_row = $stmt_location->fetch(PDO::FETCH_ASSOC);
                    $location_id = $location_row['loc_id'];
                }

                $visuel_ps5 = '';
                $visuel_ps4 = '';
                $visuel_xbox = '';
                $visuel_switch = '';

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $visuel_ps5 = $row['visuel_ps5'];
                    $visuel_ps4 = $row['visuel_ps4'];
                    $visuel_xbox = $row['visuel_xbox'];
                    $visuel_switch = $row['visuel_switch'];
            ?>
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-4 separator">
                                    <div id="visuel">
                                        <?php switch ($plateforme_id) {
                                            case 1:
                                                echo '<img src="' . $visuel_ps5 . '" class="img-fluid" alt="Visuel du jeu">';
                                                break;
                                            case 2:
                                                echo '<img src="' . $visuel_ps4 . '" class="img-fluid" alt="Visuel du jeu">';
                                                break;
                                            case 3:
                                                echo '<img src="' . $visuel_xbox . '" class="img-fluid" alt="Visuel du jeu">';
                                                break;
                                            case 4:
                                                echo '<img src="' . $visuel_switch . '" class="img-fluid" alt="Visuel du jeu">';
                                                break;
                                            default:
                                                echo 'Aucun visuel disponible';
                                        } ?>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['j_titre']; ?></h5>
                                        <p class="card-text"><strong>Sortie le :</strong> <?php echo $row['j_parution']; ?></p>
                                        <p class="card-text"><strong>Description:</strong> <?php echo $row['j_resume']; ?></p>

                                        <div class="d-flex flex-row">
                                            <?php
                                            $stmt_plateformes = $pdo->prepare("SELECT p.plateforme_id, p.nom_plateforme FROM plateformes p
                                                                              INNER JOIN jeux_plateformes jp ON p.plateforme_id = jp.plateforme_id
                                                                              WHERE jp.j_id = :jeu_id");
                                            $stmt_plateformes->bindParam(':jeu_id', $jeu_id);
                                            $stmt_plateformes->execute();
                                            echo "<p class='card-text'><strong>Plateformes :</strong></p>";
                                            while ($plateforme = $stmt_plateformes->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                <button class="btn btn-primary me-2 btn-plateforme" onclick="changeVisuel(<?php echo $plateforme['plateforme_id']; ?>)">
                                                    <?php echo $plateforme['nom_plateforme']; ?>
                                                </button>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <hr />
                                        <?php if (isset($jeu_loue)) : ?>
                                            <?php if (isset($_SESSION['user_id'])) : ?>
                                                <?php if ($jeu_loue) : ?>
                                                    <a href='../../Retour/retour.php?location=<?php echo $location_id ?>' class='btn btn-danger btn-sm'>Retour</a>
                                                <?php else : ?>
                                                    <a href="../../Location/location.php?id_jeux=<?php echo $jeu_id ?>&plateforme_id=<?php echo $plateforme_id ?>" class="btn btn-primary">Location</a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>


    <!-- Affichage de la partie notation -->
    <?php
                    $stmt = $pdo->query("SELECT AVG(note) AS moyenne, COUNT(*) AS total, note FROM notation_jeu WHERE j_id = $jeu_id  GROUP BY note ORDER BY note DESC");
                    $ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $totalAvis = array_reduce($ratings, function ($acc, $rating) {
                        return $acc + $rating['total'];
                    }, 0);
    ?>

    <div class="container mt-5">
        <div class="row">
            <?php if (!empty($ratings)) : ?>

                <div class="col-md-4">
                    <div class="summary-card text-center">
                        <h4> Résumé étoile</h4>
                        <?php foreach ($ratings as $rating) : ?>
                            <div class="mb-3">
                                <div class="progress-label"><?php echo $rating['note']; ?> étoiles (<?php echo $rating['total']; ?>)</div>
                                <div class="custom-progress">
                                    <div class="custom-progress-bar" style="width: <?php echo ($rating['total'] / $totalAvis) * 100; ?>%;"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="summary-card text-center">
                        <h4>Note Générale</h4>
                        <h2 style="color: #ffb347;"><?php echo number_format($ratings[0]['moyenne'], 1); ?></h2>
                        <p style="color: #6c757d;"><?php echo $totalAvis; ?> avis</p>
                    </div>
                </div>

            <?php else : ?>
                <div class="col-md-4">
                    <div class="summary-card text-center">
                        <p>Aucune évaluation disponible pour le moment.</p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-4">
                <div class="summary-card text-center">
                    <h4>Évaluez ce Produit</h4>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#notationModal">Donner un Avis</button>
                        <small class="text-muted d-block mt-2">Laissez une note sur le jeu <?php echo $row['j_titre']; ?> </small>
                    <?php else : ?>
                        <small class="text-muted d-block mt-2">Connectez vous pour pouvoir évaluer le jeu <?php echo $row['j_titre']; ?> </small>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
    <!-- Informations supplementaires et espaces commentaires -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="footer-tabs">
                    <input type="hidden" name="j_id" value="<?php echo $row['j_id']; ?>">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#informations">Informations supplémentaires</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link show-comment" data-bs-toggle="tab" href="#commentaires">Commentaires</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="informations">
                            <table class="table table-gray">
                                <tbody>
                                    <tr>
                                        <td class="card-text"><strong>Éditeur :</strong></td>
                                        <td class="card-text"><?php echo $row['j_editeur']; ?></td>
                                    </tr>

                                    <tr>
                                        <td class="card-text"><strong>Genre :</strong></td>
                                        <?php
                                        if (is_string($row['j_genre'])) {
                                            $genres = json_decode($row['j_genre']);
                                            echo "<td>" . implode("<td>", $genres) . "</td>";
                                        } else {
                                            echo "<td>" . implode("</td><td>", $row['j_genre']) . "</td>";
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td class="card-text"><strong>Public :</strong></td>
                                        <td class="card-text"><?php echo $row['j_public']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="card-text"><strong>Nombre de joueurs :</strong></td>
                                        <td class="card-text"><?php echo $row['j_joueurs'] . " joueur(s)"; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Espace commentaire -->
                        <div class="tab-pane fade" id="commentaires">
                            <div class="form-group">
                                <div class="col-md-15 commentaires-section">

                                    <!-- Contenu des commentaires -->
                                    <div class="card mb-3">
                                        <div class="card-body comment">
                                            <?php if (isset($_SESSION['user_id'])) : ?>
                                                <div class="d-flex flex-row align-items-center  justify-content-around form-color">
                                                    <img src="https://i.imgur.com/FvqLWB3.jpeg" width="50" class="rounded-circle mr-2">
                                                    <input type="text" name="msg" id="content_comment" class="form-control comment-text" placeholder="Entrez votre commentaire...">
                                                    <button type="submit" id="btn_comment" class="btn btn-primary post-comment">Publier</button>
                                                </div>
                                            <?php else : ?>
                                                <small class="text-muted d-block mt-2">Connectez vous pour pouvoir laisser un commentaire sur <?php echo $row['j_titre']; ?> </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <?php
                                        $aff_commentaire = $pdo->prepare("SELECT *, client.cli_username FROM commentaire_jeux JOIN client ON commentaire_jeux.cli_id = client.cli_id WHERE commentaire_jeux.j_id = :j_id");
                                        $aff_commentaire->bindParam(':j_id', $row['j_id'], PDO::PARAM_INT);
                                        $aff_commentaire->execute();
                                        while ($commentaire = $aff_commentaire->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex flex-row align-items-center comment-style">
                                                        <img src="https://i.imgur.com/FvqLWB3.jpeg" width="40" height="40" class="rounded-circle mr-3">
                                                        <div class="w-100">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="username"><?php echo $commentaire['cli_username']; ?></span>
                                                                <small class="date text-muted">
                                                                    <?php
                                                                    $date_ajout = $commentaire['date_ajout'];
                                                                    $timestamp_ajout = strtotime($date_ajout);
                                                                    $timestamp_actuel = time();
                                                                    $difference_secondes = $timestamp_actuel - $timestamp_ajout;
                                                                    $difference_jours = floor($difference_secondes / (3600 * 24));
                                                                    $difference_heures = floor($difference_secondes / 3600);
                                                                    $difference_minutes = floor($difference_secondes / 60);

                                                                    if ($difference_jours > 0) {
                                                                        echo "il y a " . $difference_jours . " jours";
                                                                    } elseif ($difference_heures > 0) {
                                                                        echo "il y a " . $difference_heures . " heures";
                                                                    } elseif ($difference_minutes > 0) {
                                                                        echo "il y a " . $difference_minutes . " minutes";
                                                                    } else {
                                                                        echo "il y a quelques secondes";
                                                                    }
                                                                    ?>
                                                                </small>
                                                            </div>
                                                            <p class="text-justify comment-text mb-0"><?php echo $commentaire['commentaire']; ?></p>
                                                            <?php
                                                            $stmt_note_client = $pdo->prepare("SELECT note FROM notation_jeu WHERE j_id = :jeu_id AND cli_id = :client_id");
                                                            $stmt_note_client->bindParam(':jeu_id', $commentaire['j_id']);
                                                            $stmt_note_client->bindParam(':client_id', $commentaire['cli_id']);
                                                            $stmt_note_client->execute();
                                                            $note_client = $stmt_note_client->fetch(PDO::FETCH_ASSOC)['note'];
                                                            if ($note_client) {
                                                                echo "<div class='text-muted'>&#9733;$note_client étoiles</div>";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
                }
            }
    ?>
        </div>
    </div>

    <!-- Modal de notation -->
    <div class="modal fade" id="notationModal" tabindex="-1" aria-labelledby="notationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notationModalLabel">Noter le jeu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <span onclick="notation(1)" class="star">★
                    </span>
                    <span onclick="notation(2)" class="star">★
                    </span>
                    <span onclick="notation(3)" class="star">★
                    </span>
                    <span onclick="notation(4)" class="star">★
                    </span>
                    <span onclick="notation(5)" class="star">★
                    </span>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="submitRating()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../footer.php'; ?>

    <!--- Scripts ---->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Projet_Moussi/assets/js/script/afficher_commentaire.js"></script>
    <script src="/Projet_Moussi/assets/js/script/add_notation.js"></script>
    <script src="/Projet_Moussi/assets/js/script/envoi_commentaire.js"></script>
    <script>
        function changeVisuel(plateformeId) {
            var visuelElement = document.getElementById('visuel');
            switch (plateformeId) {
                case 1:
                    visuelElement.innerHTML = '<img src="<?php echo $visuel_ps5; ?>" class="img-fluid" alt="Visuel du jeu">';
                    break;
                case 2:
                    visuelElement.innerHTML = '<img src="<?php echo $visuel_ps4; ?>" class="img-fluid" alt="Visuel du jeu">';
                    break;
                case 3:
                    visuelElement.innerHTML = '<img src="<?php echo $visuel_xbox; ?>" class="img-fluid" alt="Visuel du jeu">';
                    break;
                case 4:
                    visuelElement.innerHTML = '<img src="<?php echo $visuel_switch; ?>" class="img-fluid" alt="Visuel du jeu">';
                    break;
                default:
                    visuelElement.innerHTML = 'Aucun visuel disponible';
            }
        }
    </script>

</body>

</html>