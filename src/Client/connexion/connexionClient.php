<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <title>Connexion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="/Projet_Moussi/assets/css/Index/css/font-awesome.min.css" type="text/css">
  <link href="/Projet_Moussi/assets/css/co/style.css" rel="stylesheet">
</head>

<body>
  <section class="form-02-main">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="_lk_de">
            <div class="form-03-main">
              <div class="text-center title">
                <h1>Connexion</h1>
              </div>
              <?php

              if (isset($_SESSION['status'])) {
                $alertClass = ($_SESSION['error']) ? "alert-danger" : "alert-success";
              ?>
                <div class="alert <?php echo $alertClass; ?> text-black">
                  <h5><?php echo $_SESSION['status']; ?></h5>
                </div>
              <?php
                unset($_SESSION['status']);
              }
              ?>
              <form class="form-horizontal" method="post" action="./connexionClientBD.php">

                <div class="form-group">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" name="email" id="email" class="form-control _ge_de_ol" type="text" placeholder="Saisir votre email" required="" aria-required="true">
                </div>

                <div class="form-group">
                  <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                  <input type="password" name="password" id="paasword" class="form-control _ge_de_ol" type="text" placeholder="Saisir votre mot de passe" required="" aria-required="true">
                </div>

                <div class="checkbox form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me">
                    <label class="form-check-label" for="remember_me">
                      Se souvenir de moi
                    </label>
                  </div>
                </div>

                <div class="form-group">
                  <button class="_btn_04" type="submit">
                    Connexion
                  </button>
                </div>

                <div class="text-center">
                  <p class="signup-image-link">ou</p>
                  <a href="../inscription/InscriptionClient.php" class="signup-image-link">Inscrivez vous</a>
                </div>

                <hr />

                <div class="text-center">
                  <label data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                    <div class="form-group nm_lk"> <a href="#">Mot de passe oubliée</a></div>
                  </label>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="forgotPasswordModalLabel">Mot de passe oublié ?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="../resetPassword/send_resetPasswordBD.php" method="post">
            <div class="mb-3">
              <label for="forgotEmail" class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" id="forgotEmail" class="form-control _ge_de_ol" placeholder="Saisir votre email" required aria-required="true">
            </div>
            <button type="submit" name="sendMailBtn" class="_btn_04">Réinitialiser le mot de passe</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!---Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>