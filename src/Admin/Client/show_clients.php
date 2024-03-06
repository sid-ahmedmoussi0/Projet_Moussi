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
                            <h2>Client</h2>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success" name="add_client">
                                <a href="add/add_client.php">
                                    <i class="material-icons">&#xE147;</i> <span>Ajouter Client</span>
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

                    <table id="clientTable" class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="selectAll">
                                        <label for="selectAll"></label>
                                    </span>
                                </th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <?php
                        try {

                            $client = $pdo->prepare("SELECT * FROM client");
                            $client->execute();
                            while ($row = $client->fetch(PDO::FETCH_ASSOC)) {
                                echo '<tbody>';

                                echo '<tr>';
                                echo '<td>';
                                echo '<span class="custom-checkbox">';
                                echo '<input type="checkbox" id="' . $row['cli_id'] . '" name="options[]" value="' . $row['cli_id'] . '">';
                                echo '<label for="' . $row['cli_id'] . '" ></label>';
                                echo '</span>';
                                echo '</td>';
                                echo '<td>' . $row['cli_nom'] . '</td>';
                                echo ' <td>' . $row['cli_prenom'] . '</td>';
                                echo ' <td>' . $row['cli_username'] . '</td>';
                                echo ' <td>' . $row['cli_mail'] . '</td>';
                                echo ' <td>' . $row['cli_telephone'] . '</td>';
                                echo ' <td>';
                                echo ' <a href="edit/edit_client.php?client_id=' . $row['cli_id'] . '"  class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Modifier">&#xE254;</i></a>';
                                echo '<a href="delete/delete.php?client_id=' . $row['cli_id'] . '" class="delete"><i class="material-icons" title="Supprimer">&#xE872;</i></a>';
                                echo ' </td>';
                                echo '</tr>';
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

    <?php include '../../footer.php' ?>

    <!--Scripts-->
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