<?php session_start() ?>
<?php include '../../ConnexionDB/connexionBd.php' ?>
<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location:/Projet_Moussi/src/index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="/Projet_Moussi/assets/css/Admin/Style_Admin.css" rel="stylesheet" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Header/style.css" type="text/css">
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Footer/footer.css" type="text/css">
</head>

<?php include '../../header.php' ?>

<body>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Jeux Disponibles</h2>
                        </div>

                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success" name="add_games">
                                <a href="./add/add_game.php">
                                    <i class="material-icons">&#xE147;</i> <span>Ajouter un jeu</span>
                                </a>
                            </button>
                            <form action="delete/delete_all.php" method="POST">

                                <button type="submit" class="btn btn-danger" name="delete_all">
                                    <a href="delete/delete_all.php">
                                        <i class="material-icons">&#xE15C;</i> <span>Supprimer</span>
                                    </a>
                                </button>
                            </form>
                        </div>
                    </div>
                    <br />
                    <table id="gameTable" class="table table-striped  table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="selectAll">
                                        <label for="selectAll"></label>
                                    </span>
                                </th>
                                <th>Titre</th>
                                <th>Éditeur</th>
                                <th>Date de parution</th>
                                <th>Description</th>
                                <th>Genre</th>
                                <th>Public</th>
                                <th>Nombre de joueurs</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <?php
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

                                echo '<tbody>';

                                foreach ($jeux as $jeu) {

                                    echo '<tr>';
                                    echo '<td>';
                                    echo '<span class="custom-checkbox">';
                                    echo '<input type="checkbox" id="' . $jeu['j_id'] . '" name="options[]" value="' . $jeu['j_id'] . '">';
                                    echo '<label for="' . $jeu['j_id'] . '"></label>';
                                    echo '</span>';
                                    echo '</td>';
                                    echo '<td>' . $jeu['j_titre'] . '</td>';
                                    echo '<td>' . $jeu['j_editeur'] . '</td>';
                                    echo '<td>' . $jeu['j_parution'] . '</td>';
                                    echo '<td>' .  $plateforme . '</td>';
                                    if (is_string($jeu['j_genre'])) {
                                        $genres = json_decode($jeu['j_genre']);
                                        echo '<td>' . implode(', ', $genres) . '</td>';
                                    } else {
                                        echo '<td>' . implode(', ', $jeu['j_genre']) . '</td>';
                                    }
                                    echo '<td>' . $jeu['j_public'] . '</td>';
                                    echo '<td>' . $jeu['j_joueurs'] . " joueur(s)" . '</td>';
                                    echo '<td>';
                                    echo '<a href="edit/edit_game.php?game_id=' . $jeu['j_id'] . '&plateforme_id=' . $jeu['plateforme_id'] . '" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Modifier">&#xE254;</i></a>';
                                    echo '<a href="delete/delete.php?game_id=' . $jeu['j_id'] . '&plateforme_id=' . $jeu['plateforme_id'] . '" class="delete"><i class="material-icons" title="Supprimer">&#xE872;</i></a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                echo '</tbody>';
                            }
                        } catch (PDOException $e) {
                            echo "<p>Echec de l'affichage :" . $e->getMessage() . "</p>\n";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include("../../footer.php"); ?>

    <!--- Script --->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            var checkboxes = document.getElementsByName('options[]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
            }
        });
    </script>

</body>

</html>