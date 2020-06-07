<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamegirl<?php echo $title ?? '' ?></title>

    <!-- feuille Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Feuille font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <!-- Feuille CSS perso -->
    <link rel="stylesheet" href="<?php echo URL . 'css/style.css' ?>">


</head>

<body>
    <header>

        <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="<?php echo URL ?>">GAMEGIRL</a>
            <button class="navbar-toggler btn-gamegirl" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
              <span class="colorgame">&#9776;</span>
               <!-- <span class="navbar-toggler-icon"></span>-->
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item <?php if(isset($accueil)) echo $accueil ?>">
                        <a class="nav-link" href="<?php echo URL ?>">Boutique</a>
                    </li>

                    <!-- liens en mode déconnecté -->
                    <?php if (!isConnected()) : ?>
                    <li class="nav-item <?php echo $inscription ?? '' ?>">
                        <a class="nav-link" href="<?php echo URL . 'pages/inscription.php'?>">Inscription</a>
                    </li>
                    <li class="nav-item <?= $connexion ?? '' ?>">
                        <a class="nav-link" href="<?php echo URL . 'pages/connexion.php'?>">Connexion</a>
                    </li>

                    <!-- liens en mode connecté -->
                    <?php else: ?>
                    <li class="nav-item <?= $profil ?? '' ?>">
                        <a class="nav-link" href="<?php echo URL . 'pages/profil.php'?>">Profil(<?= $_SESSION['user']['login']?>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL . 'pages/connexion.php?action=deconnecter'?>">Déconnexion</a>
                    </li>
                    <?php endif; ?>
                    <!-- liens vers le BO si je suis admin -->
                    <?php if (isAdmin()) : ?>
                    <li class="nav-item dropdown <?= $bo ?? '' ?>">

                        <a class="nav-link dropdown-toggle" href="#" id="dropdown1" role="button" data-toggle="dropdown">Back Office</a>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?php echo URL . 'pages/admin_produits.php' ?>">Gestion des produits</a>
                            <a class="dropdown-item" href="<?php echo URL . 'pages/admin_users.php' ?>">Membres inscrits</a>
                        </div>                        
                    </li>
                    <?php endif; ?>
                    <!-- liens  vers le panier -->
                    <li class="nav-item <?= $contact ?? '' ?>">
                        <a class="nav-link" href="<?php echo URL . 'pages/contact.php'?>"> Contact </a>
                    </li>
                    <!-- liens  vers le panier -->
                    <li class="nav-item <?= $panier ?? '' ?>">
                        <a class="nav-link" href="<?php echo URL . 'pages/panier.php'?>"> <i class="fas fa-shopping-cart"></i> Panier </a>
                    </li>


                </ul>
                <form class="form-inline mt-2 mt-md-0">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>

    </header>
    <main>

    