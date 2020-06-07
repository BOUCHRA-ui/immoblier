<?php

function isConnected(){

    if( isset($_SESSION['user']) ){
        return true;
    }
    else{
        return false;
    }    
}

function isAdmin(){
    
    if( isConnected() && $_SESSION['user']['statut'] == 1 ){
        return true;
    }
    else{
        return false;
    }

}

function executeRequete($requete, $params = array() ){

    if( !empty($params) ){
        // on neutralise les balises HTML
        foreach($params as $index => $valeur){
            // on réécrit la valeur à la même position dans le tableau
            $params[$index] = htmlspecialchars($valeur);
        }
    }

    global $pdo; // on globalise $pdo dans l'espace de la fonction
    
    $resultats = $pdo->prepare($requete);
    $resultats->execute($params);
    return $resultats; 
}

/*
Exemples d'utilisation
$utilisateurs = executeRequete("SELECT * FROM users");
$game12 = executeRequete("SELECT * FROM games WHERE id_game=:id_game",array('id_game' => 12));
$details = $game12->fetch();
*/

function existsPseudo($login){
    
    $user = executeRequete("SELECT * FROM users WHERE login=:login",array('login' => $login));
    // Si je trouve une ligne
    if( $user->rowCount() == 1){
        return $user;
    }
    else{
        return false;
    }

}
