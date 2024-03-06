<?php session_start(); ?>
<?php include("../../../ConnexionDB/connexionBd.php"); ?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location:/Projet_Moussi/src/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/styleform.css">
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Header/style.css" type="text/css">
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Footer/footer.css" type="text/css">
</head>

<?php include("../../../header.php"); ?>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Modifier un jeu vidéo</h1>
        <?php if (isset($_SESSION['err'])) {
            echo "<div class='error'>" . $_SESSION['err'] . "</div>";
            unset($_SESSION['err']);
        }
        ?>
        <br />
        <br />
        <?php
        if (isset($_GET['game_id']) && $_GET['plateforme_id']) {
            $jeux_id = $_GET['game_id'];
            $plateforme_id = $_GET['plateforme_id'];

            $stmt = $pdo->prepare("SELECT * FROM jeux WHERE j_id = :id");
            $stmt->bindParam(':id', $jeux_id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $jeu_id = $row['j_id'];
                $jeu_titre = $row['j_titre'];
                $jeu_editeur = $row['j_editeur'];
                $jeu_parution = $row['j_parution'];
                $jeu_resume = $row['j_resume'];
                $jeu_genre = $row['j_genre'];
                $jeu_public = $row['j_public'];
                $jeu_joueurs = $row['j_joueurs'];
            } else {
                $_SESSION['erreur'] = "Jeux non trouvé.";
                header("Location: afficherJeux.php");
                exit();
            }

            $stmt_plateformes = $pdo->prepare("SELECT plateforme_id FROM jeux_plateformes WHERE j_id = :jeu_id AND plateforme_id = :plateforme_id");
            $stmt_plateformes->bindParam(':jeu_id', $jeu_id);
            $stmt_plateformes->bindParam(':plateforme_id', $plateforme_id);
            $stmt_plateformes->execute();

            $plateformesLiees = [];
            while ($row_plateforme = $stmt_plateformes->fetch(PDO::FETCH_ASSOC)) {
                $plateformesLiees[] = $row_plateforme['plateforme_id'];
            }
        }
        ?>
        <form class="form-example" action="edit_gameBD.php" method="post" enctype="multipart/form-data">

            <input type="hidden" id="jeux_id" name="jeux_id" value="<?php echo $jeu_id; ?>" />
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label for="new_titre">Titre :</label>
                    <input class="form-control" id="new_titre" name="new_titre" type="text" placeholder="Saisir le titre du jeu" value="<?php echo  $jeu_titre; ?>">

                </div>

                <div class="col-md-6 mb-3">
                    <label for="new_editeur">Éditeur :</label>
                    <input class="form-control" id="new_editeur" name="new_editeur" type="text" placeholder="Saisir l'éditeur" value="<?php echo  $jeu_editeur; ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="new_parution">Date de parution :</label>
                    <input class="form-control" id="new_parution" name="new_parution" type="text" placeholder="Saisir la date de parution:" pattern="[0-9]{2}[/][0-9]{2}[/][0-9]{1}[0-9]{1}[0-9]{1}[0-9]{1}" value="<?php echo  $jeu_parution; ?>">
                </div>

                <div class="col-md-6 mb-3" id='genre_container'>
                    <div class="form-group">
                        <label for="new_genre">Genre :</label>
                        <div class="input-group">
                            <?php
                            $genres_array = json_decode($jeu_genre, true);

                            if (count($genres_array) == 1) {
                                echo '<input class="form-control" id="genre" name="genre[]" type="text" placeholder="Veuillez saisir le genre du jeu" value="' . $genres_array[0] . '">';
                            } else {
                                foreach ($genres_array as $genre) {
                                    echo '<input class="form-control" id="genre" name="genre[]" type="text" placeholder="Veuillez saisir le genre du jeu" value="' . $genre . '">';
                                }
                            }
                            ?> <div class="btn-add-remove">
                                <button type="button" id="add" class="btn btn-primary btn-sm btn_add">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                    </svg>
                                </button>
                                <button type="button" id="remove" class="btn btn-danger btn-sm btn_remove">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="new_nb_joueurs">Nombre de joueurs :</label>
                        <select class="form-control" id="new_nb_joueurs" name="new_nb_joueurs">
                            <option value="<?php echo $jeu_joueurs; ?>"><?php echo $jeu_joueurs; ?></option>
                            <option value="1">1</option>
                            <option value="1-2">1-2</option>
                            <option value="1-3">1-3</option>
                            <option value="1-4">1-4</option>
                            <option value="1-5">1-5</option>
                            <option value="1-6">1-6</option>
                            <option value="1-7">1-7</option>
                            <option value="1-8">1-8</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="new_public">Public :</label>
                        <select class="form-control" id="new_public" name="new_public">
                            <option value="<?php echo $jeu_public; ?>"><?php echo $jeu_public; ?></option>
                            <option value="+18">+18</option>
                            <option value="+16">+16</option>
                            <option value="+12">+12</option>
                            <option value="tout_public">Tout public</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Résumé :</label>
                    <textarea id="new_resume" name="new_resume" class="form-control" placeholder="Saisir le résumé du jeu"><?php echo $jeu_resume; ?></textarea>
                </div>

                <label for="platforme">Platforme</label>

                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="type_PS5" name="type_PS5" value="PS5" <?php if (in_array(1, $plateformesLiees)) echo "checked"; ?>>
                        <label class="form-check-label" for="type_PS5">PS5</label>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="type_PS4" name="type_PS4" value="PS4" <?php if (in_array(2, $plateformesLiees)) echo "checked"; ?>>
                        <label class="form-check-label" for="type_PS4">PS4</label>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="type_Xbox" name="type_Xbox" value="Xbox" <?php if (in_array(3, $plateformesLiees)) echo "checked"; ?>>
                        <label class="form-check-label" for="type_Xbox">Xbox Series</label>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="type_Switch" name="type_Switch" value="Switch" <?php if (in_array(4, $plateformesLiees)) echo "checked"; ?>>
                        <label class="form-check-label" for="type_Switch">Switch</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3" id="visuelContainer_PS5">
                    <div class="form-group">
                        <label>Visuel PS5:</label>
                        <input name="visuel_ps5" class="form-control-file" type="file" accept=".jpg, .jpeg, .png, .webp" value></input>
                    </div>
                </div>

                <div class="col-md-6 mb-3" id="visuelContainer_PS4">
                    <div class="form-group">
                        <label>Visuel PS4:</label>
                        <input name="visuel_ps4" class="form-control-file" type="file" accept=".jpg, .jpeg, .png, .webp"></input>
                    </div>
                </div>

                <div class="col-md-6 mb-3" id="visuelContainer_Xbox">
                    <div class="form-group">
                        <label>Visuel Xbox:</label>
                        <input name="visuel_xbox" class="form-control-file" type="file" accept=".jpg, .jpeg, .png, .webp"></input>
                    </div>
                </div>

                <div class="col-md-6 mb-3" id="visuelContainer_Switch">
                    <div class="form-group">
                        <label>Visuel Switch:</label>
                        <input name="visuel_switch" class="form-control-file" type="file" accept=".jpg, .jpeg, .png, .webp"></input>
                    </div>
                </div>

                <button type="submit" id="modify_game" name="modify_game" class="btn btn-primary">Modifier</button>
        </form>
    </div>
    </div>

    <?php include("../../../footer.php"); ?>

    <!-- Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="/Projet_Moussi/assets/js/script/check_checkbox.js"> </script>
    <script type="text/javascript" src="/Projet_Moussi/assets/js/script/add_revove_input_genre.js"> </script>
</body>

</html>