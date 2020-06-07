<?php
require_once('../inc/init.php');

$title =' | Contact';
$contact = 'active';
require_once('../inc/header.php');
//echo URL;

//test de mail
$destinataire = 'james.sawyer@lost.fr';
$sujet = 'Test de mail';
$message = 'Bonjour ceci est un mail de test';
//mail($destinataire,$sujet,$message);
$headers = "From: Pierre Durand<pierre.durand@free.fr>". PHP_EOL;
$headers .= "MIME-Version:1.0" . PHP_EOL;
$headers .= "Content-Type:text/html; charset=utf-8" . PHP_EOL;

$message = "<h1>Bonjour</h1><p>Ceci est mon message</p>";
mail($destinataire,$sujet,$message,$headers);
?>


<?php
require_once('../inc/footer.php');