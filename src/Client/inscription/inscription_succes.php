<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width">
 <title>Inscription Réussie</title>
 <link rel="stylesheet" href="/Projet_Moussi/assets/css/Client/Formulaire/Inscription/style_succes.css">

 <link rel="stylesheet" href="/Projet_Moussi/assets/css/Client/Formulaire/Inscription/style.css">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<section class="registration-success section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-12">
                <div class="success-inner">
                <h1><i class="fa fa-check-circle"></i><span><?php if(isset($_SESSION['status'])) { echo $_SESSION['status']; unset($_SESSION['status']); }?></span></h1>
                <p><a href="https://mail.google.com" target="_blank"><?php if(isset($_SESSION['msg'])) { echo $_SESSION['msg']; unset($_SESSION['msg']); }?> </a></p>
                </div>
            </div>
        </div>
    </div>
</section>