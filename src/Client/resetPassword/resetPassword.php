<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Modifier votre mot de passe</title>
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Client/Formulaire/Inscription/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="bg-light py-2 py-md-3 py-xl-6">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-6">
                    <div class="bg-white p-4 p-md-5 rounded shadow-sm">
                        <div class="row">
                            <div class="col-12">
                                <?php if (isset($_SESSION['reset_status'])) {
                                    echo '<div class="alert alert-info" role="alert">' . $_SESSION['reset_status'] . '</div>';
                                    unset($_SESSION['reset_status']);
                                }
                                ?>
                                <div class="text-center mb-2">
                                    <h1> Modifier votre mot de passe </h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form class="form-horizontal" id="form" method="post" action="./resetPasswordBD.php">
                        <input type="hidden" name="pass_token" value="<?php if (isset($_GET['token'])) {
                                                                            echo $_GET['token'];
                                                                        } ?>">
                        <input type="hidden" name="id_user" value="<?php if (isset($_GET['id'])) {
                                                                        echo $_GET['id'];
                                                                    } ?>">
                        <input type="hidden" class="form-control" value="<?php if (isset($_SESSION['email'])) {
                                                                                echo $_SESSION['email'];
                                                                            } ?>" name="email" id="email" readonly>
                        <div class="row gy-3 gy-md-4 overflow-hidden">
                            <div class="col-12 ">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class='fas fa-envelope'></i>
                                    </span>
                                    <input type="email" class="form-control" value="<?php if (isset($_SESSION['email'])) {
                                                                                        echo $_SESSION['email'];
                                                                                    } ?>" name="email" id="email" readonly>
                                    <i class='fas fa-check-circle'></i>
                                    <i class='fas fa-exclamation'></i>
                                    <small> Message d'erreur</small>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="new_password" class="form-label">Nouveau mot de passe <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class='fas fa-key'></i>
                                    </span>
                                    <input type="password" class="form-control" name="new_password" id="new_password" value="" placeholder="Entrez votre nouveau mot de passe">
                                    <i class='fas fa-check-circle' id="password-check"></i>
                                    <i class='fas fa-exclamation' id="password-error"></i>
                                    <small> Message d'erreur</small>
                                    <span class="input-group-text" onclick="show_password();">
                                        <i class="fas fa-eye" id="togglePassword"></i>
                                        <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                    </span>
                                    </span>
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <label for="check_new_password" class="form-label">Confirmez votre mot de passe <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class='fas fa-key'></i>
                                    </span>
                                    <input type="password" class="form-control" name="check_new_password" id="check_new_password" value="" placeholder="Veuillez saisir à nouveau votre mot de passe">
                                    <i class='fas fa-check-circle' id="password-check"></i>
                                    <i class='fas fa-exclamation' id="password-error"></i>
                                    <small> Message d'erreur</small>
                                    <span class="input-group-text" onclick="show_confirm_password();">
                                        <i class="fas fa-eye" id="confirm_togglePassword"></i>
                                        <i class="fas fa-eye-slash d-none" id="confirm_hide_eye"></i>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg" name="update_password" type="submit">Mettre à jour votre mot de passe</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!---Script -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="/Projet_Moussi/assets/js/script/form_resetPassword.js" async></script>
    <script src="/Projet_Moussi/assets/js/script/show_password.js"></script>

</body>

</html>