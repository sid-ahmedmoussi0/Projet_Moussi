<?php session_start(); ?>
<?php include("../../../ConnexionDB/connexionBd.php"); ?>
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
  <link rel="stylesheet" href="/Projet_Moussi/assets/css/styleform.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="/Projet_Moussi/assets/css/Header/style.css" type="text/css">
  <link rel="stylesheet" href="/Projet_Moussi/assets/css/Footer/footer.css" type="text/css">
</head>

<?php
include "../../../header.php";

if (isset($_GET['client_id'])) {
  $client_id = $_GET['client_id'];

  $query = $pdo->prepare("SELECT * FROM client WHERE cli_id = ?");
  $query->execute([$client_id]);
  $client = $query->fetch(PDO::FETCH_ASSOC);

  if ($client) {

    $name = $client['cli_nom'];
    $firstname = $client['cli_prenom'];
    $username = $client['cli_username'];
    $phone = $client['cli_telephone'];
    $email = $client['cli_mail'];
  } else {
    $_SESSION['erreur'] = "Client non trouvé.";
    header("Location: afficher_client.php");
    exit();
  }
} else {
  $_SESSION['erreur'] = "ID du client non spécifié.";
  header("Location: afficher_client.php");
  exit();
}
?>

<body>
  <div class="py-2 py-md-3 py-xl-6">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-6">
          <div class="bg-white p-4 p-md-5 rounded shadow-sm">
            <div class="row">
              <div class="col-12">
                <div class="text-center mb-2">
                  <h1> Modifier client </h1>
                </div>
                <?php if (isset($_SESSION['erreur'])) {
                  echo $_SESSION['erreur'];
                  unset($_SESSION['erreur']);
                }  ?>
              </div>
            </div>
          </div>

          <form class="form-horizontal" id="form" method="post" action="edit_clientBD.php">
            <input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id; ?>" />
            <div class="row gy-3 gy-md-4 overflow-hidden">

              <div class="col-6 md-4">
                <label for="name" class="form-label">Nom<span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class='fas fa-user'></i>
                  </span>
                  <input type="text" class="form-control" name="name" id="name" value="<?php echo $name ?>" placeholder="Nom">
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
                  <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $firstname ?>" placeholder="Prénom">
                  <i class='fas fa-check-circle'></i>
                  <i class='fas fa-exclamation'></i>
                  <small> Message d'erreur</small>
                </div>
              </div>

              <div class="col-6 md-4">
                <label for="username" class="form-label">Nom d'utilisateur<span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class='fas fa-user'></i>
                  </span>
                  <input type="text" class="form-control" name="username" id="username" value="<?php echo $username ?>" placeholder="Nom d'utilisateur">
                  <i class='fas fa-check-circle'></i>
                  <i class='fas fa-exclamation'></i>
                  <small> Message d'erreur</small>
                </div>
              </div>

              <div class="col-6 md-4">
                <label for="phone" class="form-label">Numéro de téléphone<span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class='fas fa-user'></i>
                  </span>
                  <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $phone ?>" placeholder="Veuillez saisir votre numéro de téléphone">
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
                  <input type="email" class="form-control" name="email" id="email" value="<?php echo $email ?>" placeholder="Email">
                  <i class='fas fa-check-circle'></i>
                  <i class='fas fa-exclamation'></i>
                  <small> Message d'erreur</small>
                </div>
              </div>

              <div class="col-12">
                <label for="confirm_email" class="form-label">Confirmez votre adresse mail<span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class='fas fa-envelope'></i>
                  </span>
                  <input type="email" class="form-control" name="confirm_email" id="confirm_email" placeholder="Veuillez saisir à nouveau votre mail">
                  <i class='fas fa-check-circle'></i>
                  <i class='fas fa-exclamation'></i>
                  <small> Message d'erreur</small>
                </div>
              </div>

              <div class="col-12">
                <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class='fas fa-key'></i>
                  </span>
                  <input type="password" class="form-control" name="password" id="password" value="" placeholder="Mot de Passe">
                  <i class='fas fa-check-circle' id="password-check"></i>
                  <i class='fas fa-exclamation' id="password-error"></i>
                  <small> Message d'erreur</small>
                  <span class="input-group-text" onclick="show_password();">
                    <i class="fas fa-eye" id="togglePassword"></i>
                    <i class="fas fa-eye-slash" id="hide_eye"></i>
                  </span>
                  </span>
                </div>
              </div>

              <div class="col-12 mb-4">
                <label for="confirmpassword" class="form-label">Confirmez votre mot de passe <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class='fas fa-key'></i>
                  </span>
                  <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="" placeholder="Veuillez saisir à nouveau votre mot de passe">
                  <i class='fas fa-check-circle' id="password-check"></i>
                  <i class='fas fa-exclamation' id="password-error"></i>
                  <small> Message d'erreur</small>
                  <span class="input-group-text" onclick="show_confirm_password();">
                    <i class="fas fa-eye" id="confirm_togglePassword"></i>
                    <i class="fas fa-eye-slash" id="confirm_hide_eye"></i>
                </div>
              </div>

              <div class="col-12 mt-3">
                <div class="d-grid">
                  <button class="btn btn-primary btn-lg" type="submit" name="modify_client">Modifier</button>
                </div>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include "../../../footer.php" ?>

  <!--- Scripts --->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="/Projet_Moussi/assets/js/script/script.js" async></script>
  <script src="/Projet_Moussi/assets/js/script/show_password.js"></script>

</body>

</html>