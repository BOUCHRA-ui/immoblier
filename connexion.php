<?php

require_once('../inc/init.php');

// ?action=deconnecter
if (isset($_GET['action']) && $_GET['action'] == 'deconnecter') {
    unset($_SESSION['user']); // détruit ce qui, en session, m'indique que je suis connecté
    header('location:' . URL);
    exit();
}

if (isConnected()) {
    header('location:' . URL . 'pages/profil.php');
    exit();
}

if (!empty($_POST)) {

    $erreurs = array();

    if (empty($_POST['login'])) {
        $erreurs[] = "Login manquant";
    }

    if (empty($_POST['password'])) {
        $erreurs[] = "Password manquant";
    }

    if (empty($erreurs)) {
        // les champs sont remplis

        $controle = existsPseudo($_POST['login']);
        // existence du login en BDD
        if($controle){
            $user = $controle->fetch();
            // verif du mot de passe
            // password_verify(mot de passe saisi,mdp_crypte)
            if( password_verify($_POST['password'],$user['password']) ){
                $_SESSION['user'] = $user;
                header('location:' . URL);
                exit();
            }else{
                $erreurs[] = 'Identifiants incorrects'; //mdp incorrect
            }
        }
        else{
            $erreurs[] = 'Identifiants incorrects'; // login incorrect
        }
    }
}

$title = ' | Connexion';
$connexion = 'active';
require_once('../inc/header.php');
?>


<!-- .container>.row>.col  (cf. combinateurs css) -->
<div class="container pt-5">
    <div class="row">
        <div class="col">
            <h1 class="text-center mb-4">Connexion</h1>

            <?php if (!empty($erreurs)) : ?>
                <div class="alert alert-danger">
                    <?php echo implode('<br>', $erreurs) ?>
                </div>
            <?php endif; ?>

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
                    <input type="submit" class="btn btn-gamegirl d-block  mx-auto" value="Me connecter">
                </div>
            </form>
        </div>
    </div>
</div>


<?php
require_once('../inc/footer.php');
