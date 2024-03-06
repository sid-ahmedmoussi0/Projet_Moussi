<?php session_start(); ?>
<?php include 'ConnexionDB/connexionBd.php'; ?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location de Jeux Vidéo</title>
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Index/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Index/css/elegant-icons.css" type="text/css" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Index/css/owl.carousel.min.css" type="text/css" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Index/css/style.css" type="text/css" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Header/style.css" type="text/css" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Footer/footer.css" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php include("header.php"); ?>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <section class="hero">
        <div class="container">
            <div class="hero__slider owl-carousel">
                <div class="hero__items set-bg" data-setbg="../assets/img/spidey.jpeg">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <h2>Marvel Spider-Man 2</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero__items set-bg" data-setbg="../assets/img/call.jpg">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <h2>Call of Duty: Modern Warfare II</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero__items set-bg" data-setbg="../assets/img/forza.jpg">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <h2>Forza Horizon 5</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="trending__product">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-8">
                                <div class="section-title">
                                    <h4>Nouvelle Sortie</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="/Projet_Moussi/src/Jeux/Afficher/show_all_game.php" class="primary-btn">voir tout les jeux<span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            // Tableau associatif pour stocker les jeux par plateforme
                            $jeux_par_plateforme = array();

                            try {
                                $query = "SELECT j.j_id, j.j_titre, j.j_editeur, j.j_resume, j.j_parution, j.j_genre, j.j_public, j.j_joueurs, p.plateforme_id AS plateforme_id, p.nom_plateforme, v.visuel_ps5, v.visuel_ps4, v.visuel_xbox, v.visuel_switch
                                FROM jeux j
                                INNER JOIN jeux_plateformes jp ON j.j_id = jp.j_id
                                INNER JOIN plateformes p ON jp.plateforme_id = p.plateforme_id
                                LEFT JOIN visuel v ON j.j_id = v.j_id
                                ORDER BY j.j_id";

                                $statement = $pdo->query($query);

                                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                    $jeux_par_plateforme[$row['nom_plateforme']][] = $row;
                                }

                                foreach ($jeux_par_plateforme as $plateforme => $jeux) {
                                    foreach ($jeux as $jeu) {
                                        $plateforme_id = $jeu['plateforme_id'];
                                        $chemin = $jeu['visuel_' . strtolower($plateforme)];
                                        $nouveauChemin = str_replace("../../", "", $chemin);
                            ?>

                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="product__item">
                                                <div class="product__item__pic set-bg" data-setbg="<?php echo $nouveauChemin; ?>">
                                                </div>
                                                <div class="product__item__text">
                                                    <ul>
                                                        <li> <?php echo $plateforme; ?></li>

                                                    </ul>
                                                    <h5><a href="Jeux/Afficher/show_game_details.php?id=<?php echo $jeu['j_id']; ?>&plateforme_id=<?php echo $plateforme_id; ?>"><?php echo $jeu['j_titre']; ?></a></h5>

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
                </div>
            </div>
        </div>
    </section>
    <?php include('./footer.php'); ?>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Projet_Moussi/assets/js/Index/script/owl.carousel.min.js"></script>
    <script src="/Projet_Moussi/assets/js/Index/script/main.js"></script>
</body>

</html>