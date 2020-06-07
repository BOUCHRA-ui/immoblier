<?php
require_once('../inc/init.php');
//pour acceder a cette page just admin
if(!isAdmin()){
    header('location:' . URL . 'pages/connexion.php');
    exit(); // stopper toute lexecution du script
}
//suppresion dun jeu
// ?action=del&id=1
if(isset($_GET['action']) && $_GET['action'] == 'del' &&
!empty($_GET['id']) && is_numeric($_GET['id'])){
//on va chercher la photo du jeu
    $resultats=executeRequete("SELECT photo FROM games
    WHERE id_game=:id",array('id' => $_GET['id']));
    $jeu = $resultats->fetch();
    
    $fichier = __DIR__ . '/../img/' . $jeu['photo'];

    //s'assurer que le fichier existe
    if(file_exists($fichier)){ 
    //suppression du fichier
    unlink($fichier);
}
//suppression d'un champs
    executeRequete("DELETE FROM games WHERE id_game=:id", 
    array('id'=>$_GET['id']));
    header('location:' . $_SERVER['PHP_SELF']);
    exit();
}
// modification d'un jeu existant
if(isset($_GET['action']) && $_GET['action'] == 'register'
&& !empty ($_GET['id']) && is_numeric($_GET['id'])){

    $resultats = executeRequete("SELECT * FROM games 
    WHERE id_game=:id", array('id' => $_GET['id']));
    //je verifie que jai bien une ligne
    if($resultats->rowCount() == 1){ 
    //je charge les infos du jeu 
    $jeu = $resultats->fetch();

    }
}




//enregistrement dun jeu
if(!empty($_POST)){

    $erreurs = array();

    //controle des champs vides
    $champsvides = 0;
    foreach($_POST as $valeur){
        if(trim($valeur) == '') $champsvides++; // pas dacolades car une seule ligne
        // trim() retirer les espaces avants et apres
    }

    if( empty($_FILES['photo']['name']) && 
    empty($_POST['photo_actuelle'])) { 
    $champsvides++;
}
//si a ce stade jai des champs vides; je genere une erreur
    if($champsvides > 0 ){
        $erreurs[] = "Il manque $champsvides information(s)";
    }

    if(empty($erreurs)){

        if(!empty($_FILES['photo']['name'])){ 
        // copie physique du fichier dans mon rep img/
        //fihier pas de taille 0 et bien rempli
        if($_FILES['photo']['size'] > 0 &&
        in_array($_FILES['photo']['type'], array('image/jpeg', 
        'image/png', 'image/gif')) //type MIME
        
    
        ){

        $dossier = __DIR__ . '/../img/';
        $fichier = uniqid() . '_' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'],$dossier . $fichier);

        
    }
        else{  
            $erreurs[] = 'Fichier vide ou de format incorrect. (Formats autorisés: jpeg,png,gif)';

        }
    }

    if(empty($erreurs)){ 
           // insertion en base de données
    $_POST['photo'] = $fichier ?? $_POST['photo_actuelle'];
  

        if(!empty($_GET['id'])){
            //mode update
            unset($_POST['photo_actuelle']);
            $_POST['id'] = $_GET['id'];
            $requete = "UPDATE games SET 
            titre = :titre,
            plateforme = :plateforme,  
            pegi = :pegi,
            categorie = :categorie,
            description = :description,
            photo = :photo,
            prix = :prix,
            stock = :stock
            WHERE id_game = :id";
            //pas mettre despaces entre le : et le mot qui suit
        }
        else{
            //mode insert
    $requete = "INSERT INTO games VALUES (NULL, :titre, :plateforme, :pegi,
    :categorie, :description, :photo, :prix, :stock)";
 }
    executeRequete($requete, $_POST);

    //redirection sur la liste des produits

   header('location:' . $_SERVER['PHP_SELF']);
   exit();
        }
    }
}

$title =' | Gestion des produits';
$bo = 'active';
require_once('../inc/header.php');
//echo URL;
?>

<div class="container">
    <div class="row">
        <div class="col">
        <h1 class="text-center pt-4">Gestion des produits</h1>
        <?php if(!empty($erreurs)): ?>
                <div class="alert alert-danger">
                    <?php echo implode('<br>',$erreurs) ?>
                </div>
            <?php endif ; ?>
    <?php
if(isset($_GET['action']) && $_GET['action'] == 'register'):
    
    $plateformes = array('PC', 'PS4','XBOX ONE', 'SWITCH','AUTRE');
    $categories = array('aventure','action','rpg','strategie','course','simulation','gestion');
    sort($categories); // trier alphabetiquement
    $pegis = array(3,7,12,16,18);


    ?>
    <a href="<?= URL . 'pages/admin_produits.php' ?>" class="btn btn-gamegirl mt-4">
        Revenir a la liste des produits</a>
      <!--mon formulaire-->
      <form action="" method="post" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group col-md-8"><label for="titre">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" value="<?=$_POST['titre']??  $jeu['titre'] ?? '' ?>"> 
            <!-- dans value cest pour que les champs ne soit pas vidés -->
        </div>
        <div class="form-group col-md-4">
            <label for="categorie">

            </label>
    <select name="categorie" class="form-control">
        <?php foreach($categories as $categorie) : ?>
            <option <?=(
                (isset($_POST['categorie']) && $_POST['categorie']
                == $categorie) || (isset($jeu['categorie']) &&
                $jeu['categorie'] == $categorie)
                ) ? 'selected' : '' ?>><?= $categorie?></option>
        <?php endforeach; ?>
    </select>
    
    </div>
    </div>
    
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="plateforme">Plateforme</label>
        <select class="form-control" id="plateforme" name="plateforme">
        <?php foreach($plateformes as $plateforme) : ?>
            <option <?=(
                (isset($_POST['plateforme']) && $_POST['plateforme']
                == $plateforme)|| (isset($jeu['plateforme']) &&
                $jeu['plateforme'] == $plateforme) 
                ) ? 'selected' : '' ?>><?= $plateforme?></option>
        <?php endforeach; ?>
    </select>
    </div>
        <div class="form-group col-md-3">
            <label for="pegi">PEGI</label>
        <select class="form-control" id="pegi" name="pegi">
        <?php foreach($pegis as $pegi) : ?>
            <option value="<?= $pegi?> " <?=(
                (isset($_POST['pegi']) && $_POST['pegi']
                == $pegi) || (isset($jeu['pegi']) &&
                $jeu['pegi'] == $pegi) 
                ) ? 'selected' : '' ?>>PEGI-<?= $pegi?></option>
        <?php endforeach; ?>
        </select>
    </div>
        <div class="form-group col-md-3">
            <label for="stock">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" min="0" value="<?=$_POST['stock']?? $jeu['stock'] ?? '' ?>"> 
    </div>
        <div class="form-group col-md-3">
            <label for="prix">Prix</label>
        <input type="number" class="form-control" step="0.01" id="prix" name="prix"
        min="0" value="<?=$_POST['prix']?? $jeu['prix'] ?? '' ?>">
    </div>
    </div>
    
    <!--.form-row>.form-group.col-md-6*2>label+input.form-control-->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="15"><?=$_POST['description']?? $jeu['description'] ?? '' ?>
            
            </textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="photo">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo">
            <?php
                if(isset($jeu['photo'])):
            ?>
            <input type="hidden" name="photo_actuelle"
            value="<?= $jeu['photo'] ?>">
            <img src="<?= URL . 'img/'
            . $jeu['photo'] ?>" alt="<?= $jeu['titre'] ?>" 
            class="img-fluid my-3">

            <?php
            endif;

            ?>
        </div>
    </div>
    
    <div class="form-group d-flex justify-content-center">
        <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-warning d-inline-block ">Annuler</a>
        <input type="submit" class="btn btn-gamegirl d-inline-block ml-3" value="Enregistrer">
    </div>

    </form>
    <?php
    else:
    ?>
    <a href="?action=register" class="btn btn-gamegirl mt-4">
        Ajouter un produit</a>
    <!-- liste des produits-->
        <table class="table table-bordered table-striped
        table-responsive-lg mt-4">
        <tr>
            <th>Id</th>
            <th>Titre</th>
            <th>Platemforme</th>
            <th>Pegi</th>
            <th>Categorie</th>
            <th>Description</th>
            <th>Photo</th>
            <th>Prix</th>
            <th>Stock</th>
            <th colspan="2">Actions</th>
        </tr>
<?php
$resultats = executeRequete("SELECT * FROM games");
if($resultats->rowCount() > 0):
while ($game = $resultats->fetch()):
?>
<tr>
<td><?= $game['id_game'] ?></td>
<td><?= $game['titre'] ?></td>
<td><?= $game['plateforme'] ?></td>
<td><?= $game['pegi'] ?></td>
<td><?= $game['categorie'] ?></td>
<td><?= $game['description'] ?></td>
<td><img src="<?= URL . 'img/' . $game['photo']  ?>" alt="<?= $game['titre'] ?>" class="img-fluid"></td>
<td><?= $game['prix'] ?></td>
<td><?= $game['stock'] ?></td>
<td><a href="?action=register&id=
<?= $game['id_game'] ?>">
<i class="far fa-edit"></i>
</a></td>
<td><a href="?action=del&id=
<?= $game['id_game'] ?>" class="confirm">
<i class="fas fa-trash"></i>
</a></td>
</tr>

<?php
    endwhile;
else:
?>
<tr><td colspan="11">Pas encore de produits</td></tr>
        
    <?php
    endif;
    ?>
</table>
<?php
endif;
?>
    </div>
    </div>
</div>

<?php
require_once('../inc/footer.php');