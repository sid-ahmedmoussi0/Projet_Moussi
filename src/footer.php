<footer class="text-center text-lg-start bg-body-tertiary text-muted">

  <section class="d-flex justify-content-center justify-content-lg-between  border-bottom"></section>

  <section class="">
    <div class="container text-center text-md-start mt-5 contain-footer">
      <div class="row mt-3">

        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4 text-footer">
          <h6 class="text-uppercase fw-bold mb-4">
            <img src="/Projet_Moussi/assets/img/logo.png" class="footer-logo" />QuantumGamerShop
          </h6>
          <p>Bienvenue sur QuantumGamerShop. Votre site de location de jeux vidéo pour les consoles PS5, PS4, Xbox, Switch.</p>
        </div>

        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4 text-footer">
          <h6 class="text-uppercase fw-bold mb-4">Navigation</h6>
          <p>
            <a href="/Projet_Moussi/src/index.php" class="text-reset">Accueil</a>
          </p>
          <p>
            <a href="/Projet_Moussi/src/Jeux/Afficher/show_all_game.php" class="text-reset">Jeux Disponibles</a>
          </p>
          <?php
          if (isset($_SESSION['user_id'])) {
            echo "<p>";
            echo "<a href='/Projet_Moussi/src/Client/Jeux/show_game_locate.php' class='text-reset'>Mes jeux</a>";
            echo "</p>";
          }
          ?>
        </div>

        <?php
        if (isset($_SESSION['admin_id'])) {
          echo "<div class='col-md-3 col-lg-2 col-xl-2 mx-auto mb-4 text-footer'>";
          echo "<h6 class='text-uppercase fw-bold mb-4'>Navigation Admin</h6>";
          echo "<p>";
          echo "<a href='/Projet_Moussi/src/Admin/Jeux/show_game.php' class='text-reset'>Jeux ajoutés</a>";
          echo "</p>";
          echo "<p>";
          echo "<a href='/Projet_Moussi/src/Admin/Client/show_clients.php' class='text-reset'>Voir clients</a>";
          echo "</p>";
          echo "</div>";
        }
        ?>

        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4 text-footer">
          <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
          <p><i class="fas fa-envelope me-3"></i><a href="mailto:moussisidahmed0@gmail.com">moussisidahmed0@gmail.com</a></p>
        </div>

      </div>
    </div>
  </section>

  <div class="text-center p-4 text-copy" style="background-color: rgba(0, 0, 0, 0.05); color:white;">
    © 2023 Copyright:
    Moussi Sid-Ahmed
  </div>

</footer>