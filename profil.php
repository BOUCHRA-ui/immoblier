<?php
require_once('../inc/init.php');

if(isConnected()){
    header('location:' . URL  . 'pages/connexion.php');
        exit();

    }



$title =' | Profil';
$profil = 'active';
require_once('../inc/header.php');
//echo URL;
?>

Future page de profil

<?php

var_dump($_SESSION);
require_once('../inc/footer.php');