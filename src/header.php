<?php

$menuConnexion = "";
$menuConnexionAdmin = "";


if (isset($_SESSION['user_id'])) {
  if (isset($_SESSION['user_username'])) {
    $user_name = $_SESSION['user_username'];
  }
  $menuConnexion = "<li class='nav-item dropdown'>
                          <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                            Bienvenue, " .  $user_name . " <i class='bi bi-lock'></i>
                          </a>
                          <ul class='dropdown-menu text-black dropdown-menu-end' aria-labelledby='navbarDropdown'>
                            <li><a class='dropdown-item' href='/Projet_Moussi/src/Client/Jeux/show_game_locate.php'>Mes Jeux Loués</a></li>
                            <li><a class='dropdown-item' href='/Projet_Moussi/src/deconnecter.php'>Déconnexion</a></li>
                          </ul>
                        </li>";
} else {
  $menuConnexion = "<li class='nav-item'><a class='nav-link' href='/Projet_Moussi/src/Client/connexion/connexionClient.php'>Connexion</a></li>";
}


if (isset($_SESSION['admin_id'])) {
  if (isset($_SESSION['user_admin'])) {

    $admin_user = $_SESSION['user_admin'];
  }
  $menuConnexionAdmin = "
                    <li class='nav-item dropdown'>
                      <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        Bienvenue, " . $admin_user . " <i class='bi bi-lock'></i>
                      </a>
                        <ul class='dropdown-menu text-black dropdown-menu-end' aria-labelledby='navbarDropdown'>
                          <li><a class='dropdown-item' href='/Projet_Moussi/src/Admin/Jeux/show_game.php'>Jeux ajoutés</a></li>
                          <li><a class='dropdown-item' href='/Projet_Moussi/src/Admin/Client/show_clients.php'>Liste des clients</a></li>
                          <li><a class='dropdown-item' href='/Projet_Moussi/src/deconnecter.php'>Déconnexion</a></li>
                        </ul>
                    </li>
                    
                      ";
}
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark ">
  <div class="container-fluid">
    <a class="navbar-brand" href="/Projet_Moussi/src/index.php">
      <img src="/Projet_Moussi/assets/img/logo.png" alt="Logo QuantumGamerShop" width="auto" height="50">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="/Projet_Moussi/src/index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/Projet_Moussi/src/Jeux/Afficher/show_all_game.php">Jeux Disponibles</a>
        </li>
        <?php echo $menuConnexion; ?>
        <?php echo $menuConnexionAdmin; ?>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>