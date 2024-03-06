<?php session_start() ?>
<?php include('../../ConnexionDB/connexionBd.php'); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des jeux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Jeux/afficher_jeux.css" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Header/style.css" type="text/css" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Footer/footer.css" type="text/css" />
</head>

<?php include("../../header.php"); ?>

<body oncontextmenu='return false' class='snippet-body'>
    <div class="container mt-5">
        <div class="row">
            <?php
            // Tableau associatif pour stocker les jeux par plateforme
            $jeux_par_plateforme = array();
            try {
                $query = $pdo->prepare("SELECT j.j_id, j.j_titre, j.j_editeur, j.j_resume, j.j_parution, j.j_genre, j.j_public, j.j_joueurs, p.plateforme_id AS plateforme_id, p.nom_plateforme, v.visuel_ps5, v.visuel_ps4, v.visuel_xbox, v.visuel_switch
                FROM jeux j
                INNER JOIN jeux_plateformes jp ON j.j_id = jp.j_id
                INNER JOIN plateformes p ON jp.plateforme_id = p.plateforme_id
                LEFT JOIN visuel v ON j.j_id = v.j_id
                ORDER BY j.j_id");
                $query->execute();

                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    $jeux_par_plateforme[$row['nom_plateforme']][] = $row;
                }

                foreach ($jeux_par_plateforme as $plateforme => $jeux) {

                    echo "<div class='row mt-4 mb-5'>";
                    echo "<div class='col-lg-8 col-md-8 col-sm-8'>";
                    echo "<div class='plateforme type_plateform'>";
                    echo "<h4>$plateforme</h4>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='col-lg-4 col-md-4 col-sm-4'>";
                    echo "<div class='btn__all text-lg-end '>";
                    echo "<a href='./show_game_by_platform.php?plateforme_id=" . $jeux[0]['plateforme_id'] . "' class='primary-btn'>Voir tous les jeux <span class='arrow_right'></span></a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";

                    foreach ($jeux as $jeu) {
                        $plateforme_id = $jeu['plateforme_id'];
            ?>

                        <div class="col-md-3">
                            <div class="card card.<?php echo $plateforme; ?>">
                                <div class="image-container">
                                    <?php
                                    $visuel = '';
                                    switch ($jeu['nom_plateforme']) {
                                        case 'PS5':
                                            $visuel = $jeu['visuel_ps5'];
                                            break;
                                        case 'PS4':
                                            $visuel = $jeu['visuel_ps4'];
                                            break;
                                        case 'Xbox':
                                            $visuel = $jeu['visuel_xbox'];
                                            break;
                                        case 'Switch':
                                            $visuel = $jeu['visuel_switch'];
                                            break;
                                    }
                                    if (!empty($visuel)) {
                                        echo "<img src='" . $visuel . "' alt='Visuel." . $plateforme . "' class='img-fluid rounded thumbnail-image." . $jeu['nom_plateforme'] . "'>";
                                    } else {
                                        echo "<p>Aucun visuel disponible pour cette plateforme</p>";
                                    }

                                    ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php echo $jeu['j_titre']; ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
            ?>
        </div>
    </div>
    <?php include "../../footer.php"; ?>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>