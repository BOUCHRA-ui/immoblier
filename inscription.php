<?php

require_once('../inc/init.php');
if(isConnected()){
    header('location:' . URL  . 'pages/inscription.php');
        exit();

    }

if(!empty($_POST)){
   
    // var_dump($_POST);
    // Test des champs
    $erreurs = array(); // initialisation de mon tableau d'erreurs

    if(empty($_POST['login'])){
        $erreurs[] = "Login manquant";
    }
    
    if(empty($_POST['password'])){
        $erreurs[] = "Password manquant";
    }
    
    if(empty($_POST['email'])){
        $erreurs[] = "Email manquant";
    }

    if(empty($erreurs)){
        // ok aucune erreur rencontrée
        // controler l'unicité du pseudo
        if(existsPseudo($_POST['login'])){
          $erreurs[] = "Login indisponible. Merci d'en choisir un autre";        
        }
        else{
            // crypter le mot de passe
            $_POST['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);
            // Procéder à l'inscription en l'ajoutant dans la table users
            executeRequete("INSERT INTO users VALUES (NULL,:login,:password,:email,0)",$_POST);            
            // redirection vers la page d'accueil en mode connecté
            $user = existsPseudo($_POST['login']);
            $_SESSION['user'] = $user->fetch() ;
            header('location:' .URL );
            exit();
        }
    }
    
}

$title = ' | Inscription';
$inscription = 'active';
require_once('../inc/header.php');
?>

<!-- .container>.row>.col  (cf. combinateurs css) -->
<div class="container pt-5">
    <div class="row">
        <div class="col">
            <h1 class="text-center mb-4">Inscription</h1>

            <?php if(!empty($erreurs)): ?>
                <div class="alert alert-danger">
                    <?php echo implode('<br>',$erreurs) ?>
                </div>
            <?php endif ; ?>

            <form action="" method="post">

                <!-- .form-row>.form-group.col-md-6*2>label+input.form-control -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="login">Login</label>
                        <input type="text" class="form-control" id="login" name="login">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-gamegirl d-block  mx-auto" value="M'inscrire">
                </div>
            </form>
        </div>
    </div>
</div>


<?php
require_once('../inc/footer.php');
