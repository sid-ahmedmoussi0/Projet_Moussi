<?php session_start(); ?>
<?php
if (!isset($_SESSION['user_id'])) {
    header('Location:/Projet_Moussi/src/Client/connexion/connexionClient.php');
    exit();
}
?>
<?php include('../ConnexionDB/connexionBd.php'); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Location</title>
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Client/Location/style.css" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Header/style.css" type="text/css" />
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Footer/footer.css" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<?php include('../header.php'); ?>

<body>
    <div class="bg-light py-2 py-md-3 py-xl-6">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-6">
                    <div class="bg-white p-4 p-md-5 rounded shadow-sm">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center mb-2">
                                    <h1> Location </h1>
                                </div>
                                <?php if (isset($_SESSION['err'])) {
                                    echo $_SESSION['err'];
                                    unset($_SESSION['err']);
                                }  ?>
                            </div>
                        </div>
                    </div>
                    <form class="form-horizontal" id="form" method="post" action="./locationBD.php">

                        <input type="hidden" name="jeux_id" value="<?php echo $_GET['id_jeux'] ?>" />
                        <input type="hidden" name="plateforme_id" value="<?php echo $_GET['plateforme_id'] ?>" />
                        <div class="row gy-3 gy-md-4 overflow-hidden">
                            <div class="col-6 md-4">
                                <label for="name" class="form-label">Nom<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class='fas fa-user'></i>
                                    </span>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nom">
                                    <i class='fas fa-check-circle'></i>
                                    <i class='fas fa-exclamation'></i>
                                    <small> Message d'erreur</small>
                                </div>
                            </div>

                            <div class="col-6 md-4">
                                <label for="firstname" class="form-label">Prénom<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class='fas fa-user'></i>
                                    </span>
                                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom">
                                    <i class='fas fa-check-circle'></i>
                                    <i class='fas fa-exclamation'></i>
                                    <small> Message d'erreur</small>
                                </div>
                            </div>

                            <div class="col-12 ">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class='fas fa-envelope'></i>
                                    </span>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                    <i class='fas fa-check-circle'></i>
                                    <i class='fas fa-exclamation'></i>
                                    <small> Message d'erreur</small>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg" type="submit">Louer</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include('../footer.php'); ?>

    <!--Scripts-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>