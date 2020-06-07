<?php
require_once('inc/init.php');

$title =' | Accueil';
$accueil = 'active';
require_once('inc/header.php');
//echo URL;
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3 text-center">

        <div class="sticky">
            <p class="lead">Catégories</p>

            <div class="list-group pb-4">

            <a href="<?= URL ?>" 
            class="list-group-item list-group-item-action <?=(!isset($_GET['cat'])) ? 'active' : '' ?>">Toutes</a>
        <!--liste des catagories -->
        <?php
            $requete = "SELECT DISTINCT categorie FROM games";
            $resultats = executeRequete($requete);

            while($categories = $resultats->fetch()):
                ?>

                <a href="?cat=<?= $categories['categorie'] ?>" class="list-group-item list-group-item-action 
                <?=(isset($_GET['cat']) &&
                ($_GET['cat']) == $categories['categorie']) ? 'active' : '' ?>">
                    <?= $categories['categorie'] ?></a>

                <?php
            endwhile;
        ?>


            </div>


        </div>

        </div>

<div class="col-md-9">
    <div class="d-flex pb-4 flex-wrap justify-content-around">
<?php
        $requete = "SELECT * FROM games";
        $arguments = array();
        if(!empty($_GET['cat'])){
            $requete .=" WHERE categorie = :cat";
            $arguments[':cat'] = $_GET['cat'];
        }

        $resultats = executeRequete($requete,$arguments);
        while($jeu = $resultats->fetch()) :
            ?> 
            <div class="col-sm-6 col-md-4 text-center mb-4">
                <img src="<?= URL . 'img/' . $jeu['photo'] ?>" alt="<?= $jeu['titre'] ?>" class="img-fluid p-0 m-0">
            <div>
                <h5 class="mt-3"><?= $jeu['titre'] ?></h5>
          <div>

        <div class="float-right h5">
            <span class="badge btn-gamegirl"><?= number_format($jeu['prix'],2,',', ' ') ?>€</span>
        </div>
        <div class="float-left h5">
        <span class="badge btn-gamegirl"><?= $jeu['plateforme'] ?></span>
        </div>
        </div>
            
            </div>
            
            </div>
            <?php
        endwhile;
?>

    </div>

</div>

    </div>
</div>

<?php
require_once('inc/footer.php');

/* container BS (1200px max sur grand ecran)
textes.container max-width : 1200px
container-fluid ( 100% de largeur)
.containder-fluid width 100%;
*/