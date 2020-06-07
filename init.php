<?php

// initalisation de ce quon doit faire dans toutes nons pages
// ouverture de la session
session_name('GAMEGIRLSESS');
session_start();

//lecture du fichier ini pour recuperer les parametres
$config = parse_ini_file(__DIR__ . '/../config/config.ini');

//definition de la constante URL
define('URL', $config['url']);

//connecion a la BDD
$pdo = new PDO(
    'mysql:host=' . $config['host'] . ';dbname=' 
    . $config['dbname'] . ';charset=utf8',
    $config['user'],
    $config['password'],
    array(
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    )

);

//inclusion du fichier de fonctions
require_once('functions.php');