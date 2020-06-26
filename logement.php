<?php

// Inclusion de la connexion
// Fonction executeRequete dispo
require_once('inc/init.php');


/*------------------------------------*/
/* Traitement du POST (insert/edit)   */
/*------------------------------------*/
if (!empty($_POST)) {
     //var_dump($_POST); NE FONCTIONNE PAS

    // contrôles
    $erreurs = array();

    // champs vides
    $champsvides = 0;
    foreach ($_POST as $valeur) {
        if (empty($valeur)) $champsvides++;
    }

    if ($champsvides > 0) {
        $erreurs[] = "Il manque $champsvides information(s)";
    }

    // longueur et nature du code postal
    if (iconv_strlen($_POST['cp']) != 5 || !is_numeric($_POST['cp'])) {
        $erreurs[] = "Code postal incorrect : 5 chiffres requis";
    }

    if (!empty($_GET['id'])) {
        // mode update car j'ai un numero de contact dans l'url
        $requete = "UPDATE logement SET titre = :titre, adresse = :adresse, ville = :ville, cp = :cp, surface = :surface, prix = :prix, type= :type, description = :description WHERE id_logement = :id";
        $_POST['id'] = $_GET['id'];
        
    } else {
        // mode insertion 
        $requete = "INSERT INTO logement VALUES (NULL, :titre, :adresse, :ville, :cp, :surface, :prix, :type, :description)";
    }

    executeRequete($requete, $_POST);
    header('location:' . $_SERVER['PHP_SELF']);
    exit();
}


require_once('inc/header.php')

?>
<a href="description.php">Description</a>

<div class="row">
    <div class="col">

        <h2>Ajouter un logement</h2>

        <!-- Messages d'erreur éventuels -->
        <?php if (!empty($erreurs)) : ?>
            <div class="alert alert-danger"><?= implode('<br>', $erreurs) ?></div>
        <?php endif ?>

        <!-- FORMULAIRE -->
        <form action="" method="post">

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" class="form-control" value="<?= $_POST['titre'] ?? $logement['titre'] ?? '' ?>"></div>
                <div class="form-group col-md-3">
                    <label for="adresse">Adresse</label>
                    <input type="text" id="adresse" name="adresse" class="form-control" value="<?= $_POST['adresse'] ?? $logement['adresse'] ?? '' ?>"></div>

                <div class="form-group col-md-3">
                    <label for="ville">ville</label>
                    <input type="text" id="ville" name="ville" class="form-control" value="<?= $_POST['ville'] ?? $logement['ville'] ?? '' ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="cp">Code Postal</label>
                    <input type="number" id="cp" name="cp" class="form-control" value="<?= $_POST['cp'] ?? $logement['cp'] ?? '' ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="surface">Surface</label>
                    <input type="number" id="surface" name="surface" class="form-control" value="<?= $_POST['surface'] ?? $logement['surface'] ?? '' ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="prix">Prix</label>
                    <input type="number" id="prix" name="prix" class="form-control" value="<?= $_POST['prix'] ?? $logement['prix'] ?? '' ?>">
                </div>
                <div class="form-group col-md-2">
                            <label for="type">Type</label>
                            <select id="type" name="type" class="form-control">
                                <option value="vente">Vente</option>
                                <option <?= (
                                            (isset($_POST['type']) && $_POST['type'] == 'location')
                                            || (isset($logement['type']) && $logement['type'] == 'location')) ? 'selected' : '' ?> value="location">Location</option>
                            </select>

                        </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="10" class="form-control"><?= $_POST['description'] ?? $logement['description'] ?? '' ?></textarea>
                </div>

            </div>
            <div class="float-right">
                
                <input type="submit" value="Enregistrer" class="btn btn-dark" class="confirm">
            </div>
        </form>

        
    </div>
</div>

<?php

require_once('inc/footer.php');
