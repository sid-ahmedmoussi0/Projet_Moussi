<?php session_start(); ?>
<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location:/Projet_Moussi/src/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Inscription</title>
    <link rel="stylesheet" href="/Projet_Moussi/assets/css/Client/Formulaire/Inscription/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
</head>

<body>
    <div class="main">
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-image">
                        <figure><img src="../../../../assets/img/ac.jpg" alt="sing up image"></figure>
                    </div>
                    <div class="signup-form">
                        <h2 class="form-title">Ajouter Client</h2>
                        <?php if (isset($_SESSION['erreur'])) {
                            echo $_SESSION['erreur'];
                            unset($_SESSION['erreur']);
                        }  ?>
                        <form method="POST" class="register-form" id="form" action="./add_clientBD.php">

                            <div class="form-group ">
                                <div class="input-group">
                                    <input type="text" class="form-control left" name="name" id="name" placeholder="Nom">
                                    <i class='fas fa-check-circle'></i>
                                    <i class='fas fa-exclamation'></i>
                                    <small>Message d'erreur</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom">
                                    <i class='fas fa-check-circle'></i>
                                    <i class='fas fa-exclamation'></i>
                                    <small>Message d'erreur</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Nom d'utilisateur">
                                    <i class='fas fa-check-circle'></i>
                                    <i class='fas fa-exclamation'></i>
                                    <small> Message d'erreur</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Veuillez saisir votre numéro de téléphone">
                                    <i class='fas fa-check-circle'></i>
                                    <i class='fas fa-exclamation'></i>
                                    <small> Message d'erreur</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                    <i class='fas fa-check-circle'></i>
                                    <i class='fas fa-exclamation'></i>
                                    <small> Message d'erreur</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="email" class="form-control" name="confirm_email" id="confirm_email" placeholder="Veuillez saisir à nouveau votre mail">
                                    <i class='fas fa-check-circle'></i>
                                    <i class='fas fa-exclamation'></i>
                                    <small> Message d'erreur</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password" value="" placeholder="Mot de Passe">
                                    <i class='fas fa-check-circle' id="password-check"></i>
                                    <i class='fas fa-exclamation' id="password-error"></i>
                                    <small class="mes"> Message d'erreur</small>
                                    <span class="input-group-text" onclick="show_password();">
                                        <i class="fas fa-eye" id="togglePassword"></i>
                                        <i class="fas fa-eye-slash" id="hide_eye"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="" placeholder="Veuillez saisir à nouveau votre mot de passe">
                                    <i class='fas fa-check-circle' id="password-check"></i>
                                    <i class='fas fa-exclamation' id="password-error"></i>
                                    <small class="mes"> Message d'erreur</small>
                                    <span class="input-group-text" onclick="show_confirm_password();">
                                        <i class="fas fa-eye" id="confirm_togglePassword"></i>
                                        <i class="fas fa-eye-slash display-none" id="confirm_hide_eye"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group form-button">
                                <button class="form-submit" type="submit" name="add_new_client" id="add_new_client">Ajouter</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!--- Scripts --->
    <script src="/Projet_Moussi/assets/js/script/script.js" async></script>
    <script src="/Projet_Moussi/assets/js/script//show_password.js"></script>

</body>

</html>