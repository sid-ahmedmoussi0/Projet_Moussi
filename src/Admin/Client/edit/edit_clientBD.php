<?php
session_start();
include('../../../ConnexionDB/connexionBd.php');

if (isset($_POST['modify_client'])) {
    if (isset($_POST['client_id']) && isset($_POST['name']) && isset($_POST['firstname']) && isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password'])) {
        if (!empty($_POST['client_id'])) {
            $cli_id = $_POST['client_id'];
            $name = $_POST['name'];
            $firstname = $_POST['firstname'];
            $username = $_POST['username'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            try {
                $updates = [];
                $bindParams = [];

                if (!empty($_POST['name'])) {
                    $updates[] = "cli_nom = :nom";
                    $bindParams[':nom'] = $name;
                }
                if (!empty($_POST['firstname'])) {
                    $updates[] = "cli_prenom = :prenom";
                    $bindParams[':prenom'] = $firstname;
                }
                if (!empty($_POST['username'])) {
                    $updates[] = "cli_username = :username";
                    $bindParams[':username'] = $username;
                }
                if (!empty($_POST['phone'])) {
                    $updates[] = "cli_telephone = :phone";
                    $bindParams[':phone'] = $phone;
                }
                if (!empty($_POST['email'])) {
                    $updates[] = "cli_mail = :mail";
                    $bindParams[':mail'] = $email;
                }
                if (!empty($_POST['password'])) {
                    $updates[] = "cli_pwd = :pwd";
                    $pwd = password_hash($password, PASSWORD_DEFAULT);
                    $bindParams[':pwd'] = $pwd;
                }

                $sql = "UPDATE client SET " . implode(", ", $updates) . " WHERE cli_id = :cli_id";
                $bindParams[':cli_id'] = $cli_id;

                $stmt = $pdo->prepare($sql);
                
                foreach ($bindParams as $param => &$value) {
                    $stmt->bindParam($param, $value);
                }

                $stmt->execute();
                header("location: ../show_clients.php");
                exit();

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
     $_SESSION["erreur"] = "Aucun utilisateur trouvé";
     header("location: edit_client.php");
     exit();
        }
    } else {
        $_SESSION["erreur"] = "Toutes les données doivent d'être transmises";
        header("location: edit_client.php");
        exit();
    }
}
?>
