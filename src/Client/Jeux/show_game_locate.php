<?php
session_start();
include('../../ConnexionDB/connexionBd.php');

if (!isset($_SESSION['user_id'])) {
    header('Location:/Projet_Moussi/src/Client/connexion/connexionClient.php');
    exit();
}

if (isset($_SESSION['user_id'])) {
    $platforms = isset($_GET['platforms']) ? explode(',', $_GET['platforms']) : [];
    $platformFilter = "";
    if (!empty($platforms)) {
        $platformsString = "'" . implode("', '", $platforms) . "'";
        $platformFilter = "AND p.nom_plateforme IN ($platformsString)";
    }
    $query = $pdo->prepare("SELECT DISTINCT j.j_id, j.j_titre, j.j_editeur, j.j_resume, j.j_parution, j.j_genre, j.j_public, j.j_joueurs, p.nom_plateforme, p.plateforme_id, v.visuel_ps5, v.visuel_ps4, v.visuel_xbox, v.visuel_switch
                FROM jeux j
                INNER JOIN location loc ON j.j_id = loc.jeu_id
                INNER JOIN plateformes p ON loc.plateforme_id = p.plateforme_id
                LEFT JOIN visuel v ON j.j_id = v.j_id
                WHERE loc.client_id = :client_id $platformFilter
                ORDER BY j.j_id");

    $query->execute(['client_id' => $_SESSION['user_id']]);

?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listes des jeux loués</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
        <link rel="stylesheet" href="/Projet_Moussi/assets/css/style.css" />
        <link rel="stylesheet" href="/Projet_Moussi/assets/css/Jeux/afficher_jeux.css" />
        <link rel="stylesheet" href="/Projet_Moussi/assets/css/Jeux/game_locate.css" />
        <link rel="stylesheet" href="/Projet_Moussi/assets/css/Header/style.css" type="text/css">
        <link rel="stylesheet" href="/Projet_Moussi/assets/css/Footer/footer.css" type="text/css">
    </head>
    <?php include("../../header.php"); ?>

    <body>
        <section>
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sidebar">
                            <h3 class="sidebar-title">Filtrer par plateforme</h3>
                            <div class="filter-option">
                                <label for="platform_ps5">
                                    <input type="checkbox" id="platform_ps5" name="platform[]" value="PS5" onchange="filterGames()"> PS5
                                </label>
                            </div>
                            <div class="filter-option">
                                <label for="platform_ps4">
                                    <input type="checkbox" id="platform_ps4" name="platform[]" value="PS4" onchange="filterGames()"> PS4
                                </label>
                            </div>
                            <div class="filter-option">
                                <label for="platform_xbox">
                                    <input type="checkbox" id="platform_xbox" name="platform[]" value="Xbox" onchange="filterGames()"> Xbox
                                </label>
                            </div>
                            <div class="filter-option">
                                <label for="platform_switch">
                                    <input type="checkbox" id="platform_switch" name="platform[]" value="Switch" onchange="filterGames()"> Switch
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row justify-content-center mb-3" id="game-list">
                            <?php
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                $plateforme_id = $row['plateforme_id'];
                            ?>
                                <div class='col-md-12 col-xl-10 game-item' data-platform="<?php echo $row['nom_plateforme']; ?>">
                                    <div class='card shadow-0 border rounded-3'>
                                        <div class='card-body'>
                                            <div class='row'>
                                                <div class='col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0'>
                                                    <div class='bg-image hover-zoom ripple rounded ripple-surface'>
                                                        <?php
                                                        $visuel = '';
                                                        switch ($row['nom_plateforme']) {
                                                            case 'PS5':
                                                                $visuel = $row['visuel_ps5'];
                                                                break;
                                                            case 'PS4':
                                                                $visuel = $row['visuel_ps4'];
                                                                break;
                                                            case 'Xbox':
                                                                $visuel = $row['visuel_xbox'];
                                                                break;
                                                            case 'Switch':
                                                                $visuel = $row['visuel_switch'];
                                                                break;
                                                        }
                                                        if (!empty($visuel)) {
                                                            echo "<img src='" . $visuel . "' alt='Visuel." . $row['nom_plateforme'] . "' class='card-img-top'>";
                                                        } else {
                                                            echo "<p class='card-text'>Aucun visuel disponible pour cette plateforme</p>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class='col-md-6 col-lg-6 col-xl-6'>
                                                    <h5><?php echo $row['j_titre']; ?></h5>
                                                    <div class='d-flex flex-row'>
                                                    </div>
                                                    <div class='mt-1 mb-0 text-muted small'>
                                                        <span>Editeur: <?php echo $row['j_editeur']; ?></span>
                                                        <span class='text-primary'> • </span>
                                                        <span>Genre: <?php echo implode(", ", json_decode($row['j_genre'])); ?></span>
                                                    </div>
                                                    <p class='text-truncate mb-4 mb-md-0'>
                                                        <?php echo $row['j_resume']; ?>
                                                    </p>
                                                </div>
                                                <?php $id_loue = $row['j_id']; ?>
                                                <div class='col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start'>
                                                    <div class='d-flex flex-row align-items-center mb-1'>
                                                    </div>
                                                    <div class='d-flex flex-column mt-4'>

                                                        <a href='../../Jeux/Afficher/show_game_details.php?id=<?php echo $id_loue; ?>&plateforme_id=<?php echo $plateforme_id; ?>' class='btn btn-primary btn-sm'>Détails</a>
                                                    </div>
                                                    <?php

                                                    $get_LocationId = $pdo->prepare("SELECT loc_id FROM location WHERE client_id = :cli_id AND jeu_id = :jeu_id AND plateforme_id = :plateforme_id LIMIT 1");
                                                    $get_LocationId->bindParam(':cli_id', $_SESSION['user_id']);
                                                    $get_LocationId->bindParam(':jeu_id', $id_loue);
                                                    $get_LocationId->bindParam(':plateforme_id', $plateforme_id);
                                                    $get_LocationId->execute();
                                                    $location_row = $get_LocationId->fetch(PDO::FETCH_ASSOC);

                                                    if ($location_row) {
                                                        $location_id = $location_row['loc_id'];
                                                        echo "<a href='../../Retour/retour.php?location=$location_id' class='btn btn-danger btn-sm btn-retour'>Retour</a>";
                                                    } else {
                                                        echo "Aucune location trouvée pour ce client et ce jeu.";
                                                    }
                                                    ?>
                                                </div>
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
        </section>
        <?php include("../../footer.php"); ?>

        <!---Scripts-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function filterGames() {
                var platforms = [];
                var checkboxes = document.querySelectorAll('input[name="platform[]"]:checked');
                checkboxes.forEach(function(checkbox) {
                    platforms.push(checkbox.value);
                });
                var games = document.querySelectorAll('.game-item');
                games.forEach(function(game) {
                    var platform = game.dataset.platform;
                    if (platforms.length === 0 || platforms.includes(platform)) {
                        game.style.display = 'block';
                    } else {
                        game.style.display = 'none';
                    }
                });
            }
        </script>
    </body>

    </html>
<?php
} else {
    echo "La session n'est pas démarrée ou l'identifiant de l'utilisateur n'est pas défini.";
}
?>