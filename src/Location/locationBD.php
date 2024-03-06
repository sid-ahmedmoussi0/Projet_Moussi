<?php session_start(); ?>
<?php
include('../ConnexionDB/connexionBd.php');

if (!isset($_SESSION['user_id'])) {
    header('Location:/Projet_Moussi/src/Client/connexion/connexionClient.php');
    exit();
}

function sendmail_check_location($name, $firstname, $titre_jeux, $email)
{
    $fromEmail = "testsmtp49687@gmail.com";
    $message = "Bonjour " . $name . " " . $firstname . ",<br><br>
    Merci d'avoir loué " . $titre_jeux . ".<br><br>
    Cordialement,<br>L'équipe de QuantumGamerShop";

    $to = $email;
    $subject = "Location du jeu, " . $titre_jeux;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: ' . $fromEmail . ' <' . $fromEmail . '>' . "\r\n" . 'Reply-To: ' . $fromEmail . "\r\n" . 'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
}

if (isset($_POST['jeux_id'], $_POST['plateforme_id'], $_POST['name'], $_POST['firstname'], $_POST['email'])) {

    if (empty($_POST['jeux_id'])) {
        $_SESSION['err'] = "Le jeu n'a pas été trouvé.";
        header('Location:/Projet_Moussi/src/Location/location.php');
        exit();
    } else {
        if (empty($_POST['name']) || empty($_POST['firstname']) || empty($_POST['email'])) {
            $_SESSION['err'] = "Veuillez saisir tous les champs présents dans le formulaire de location.";
            header('Location:/Projet_Moussi/src/Location/location.php');
            exit();
        } else {
            $id_loue = $_POST['jeux_id'];
            $id_plateforme = $_POST['plateforme_id'];
            $id_client = $_SESSION['user_id'];
            $name = $_POST['name'];
            $firstname = $_POST['firstname'];
            $email = $_POST['email'];

            try {
                $verif_identity = $pdo->prepare("SELECT cli_id, cli_nom, cli_prenom FROM client WHERE cli_id = :id_client");
                $verif_identity->bindParam(':id_client', $_SESSION['user_id']);
                $verif_identity->execute();
                $clientInfo = $verif_identity->fetch(PDO::FETCH_ASSOC);

                if ($name != $clientInfo['cli_nom'] || $firstname != $clientInfo['cli_prenom']) {
                    $_SESSION['err'] = "Le nom ou prénom saisis ne correspondent pas.";
                    header('Location:/Projet_Moussi/src/Location/location.php');
                    exit();
                } else {
                    $select_quantity = $pdo->prepare("SELECT quantite_jeux FROM jeux_plateformes WHERE j_id = :id_loue AND plateforme_id = :id_plateforme");
                    $select_quantity->bindParam(':id_loue', $id_loue);
                    $select_quantity->bindParam(':id_plateforme', $id_plateforme);
                    $select_quantity->execute();
                    $quantite = $select_quantity->fetch(PDO::FETCH_COLUMN);

                    if ($quantite <= 0) {
                        $_SESSION['err'] = "Le jeu loué sur cette plateforme n'est plus disponible.";
                        header('Location:/Projet_Moussi/src/Jeux/Afficher/show_all_game.php');
                        exit();
                    } else {

                        $title = $pdo->prepare("SELECT j_titre FROM jeux WHERE j_id = :id_loue");
                        $title->execute(array(':id_loue' => $id_loue));
                        $jeu_titre = $title->fetch(PDO::FETCH_COLUMN);

                        $location = $pdo->prepare("INSERT INTO location (client_id, jeu_id, plateforme_id) VALUES(:client_id, :jeu_id, :plateforme_id)");
                        $location->bindParam(':client_id', $_SESSION['user_id']);
                        $location->bindParam(':jeu_id', $id_loue);
                        $location->bindParam(':plateforme_id', $id_plateforme);
                        $location->execute();

                        $new_quant = $quantite - 1;
                        $new_quantity = $pdo->prepare("UPDATE jeux_plateformes SET quantite_jeux = :new_quant WHERE j_id = :id_loue AND plateforme_id = :id_plateforme");
                        $new_quantity->bindParam(':new_quant', $new_quant);
                        $new_quantity->bindParam(':id_loue', $id_loue);
                        $new_quantity->bindParam(':id_plateforme', $id_plateforme);
                        $new_quantity->execute();
                        $_SESSION['id_loue'] = $id_loue;
                        $_SESSION['id_plat_loue'] = $id_plateforme;

                        $LocationId = $pdo->prepare("SELECT loc_id FROM location WHERE client_id = :cli_id");
                        $LocationId->bindParam(':cli_id',  $_SESSION['user_id']);
                        $LocationId->execute();
                        $locationRow = $LocationId->fetch(PDO::FETCH_ASSOC);

                        if ($locationRow) {
                            $_SESSION['location'] = $locationRow['loc_id'];
                        } else {
                            $_SESSION['err'] = "Erreur lors de la récupération de l'ID de la location.";
                            header('Location:/Projet_Moussi/src/Location/location.php');
                            exit();
                        }

                        sendmail_check_location($name, $firstname, $jeu_titre, $email);
                        header("Location: /Projet_Moussi/src/Client/Jeux/show_game_locate.php");
                        exit();
                    }
                }
            } catch (\Exception $e) {
                $_SESSION['err'] = "Échec de l'insertion : " . $e->getMessage();
                echo "Erreur SQL : " . $e->getMessage();
                header("Location: ./location.php");
                exit();
            }
        }
    }
} else {
    $_SESSION['err'] = "Toutes les données doivent être saisies.";
    header("Location: ./location.php");
    exit();
}
?>
