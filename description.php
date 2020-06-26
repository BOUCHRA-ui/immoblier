        <?php
        require_once('inc/init.php');
        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            $resultat = executeRequete("SELECT * FROM logement WHERE id_logement = :id", array('id' => $_GET['id']));
            // si j'ai bien 1 ligne en retour
            if ($resultat->rowCount() == 1) {
                // je charge les infos de la table dans un tableau associatif $contact
                $logement = $resultat->fetch();
            }
        }
        
        require_once('inc/header.php');
        ?>
        <!-- ------------------- AFFICHAGE ----------------------- -->
        <h2 class="pt-5">Liste des logments</h2>

        <table class="table table-bordered table-striped table-responsive-sm">
            <tr>
                <th>Titre</th>
                <th>Adresse</th>
                <th>Ville</th>
                <th>Code postal</th>
                <th>Description</th>
                <th>Surface</th>
                <th>Prix</th>
                <th>Type</th>

                
            </tr>
            <?php

            $resultats = executeRequete("SELECT * FROM logement");
            if ($resultats->rowCount() > 0) :
                while ($logement = $resultats->fetch()) :
            ?>
                    <tr>
                        <td><?= $logement['titre'] ?></td>
                        <td><?= $logement['adresse'] ?></td>
                        <td><?= $logement['ville'] ?></td>
                        <td><?= $logement['cp'] ?></td>
                        <td><?= $logement['surface'] ?></td>
                        <td><?= $logement['prix'] ?></td>
                        <td><?= $logement['description'] ?></td>
                        <td><?= $logement['type'] ?></td>
                        
                    </tr>

                <?php
                endwhile;
            else :
                ?>
                <tr>
                    <td colspan="9">Pas encore de logements</td>
                </tr>
            <?php
            endif;
            ?>
        </table>

        <a href="logement.php">Retour</a>
<?php
        require_once('inc/footer.php');


/*Trouvez la requête SQL permettant d’afficher les logements ayant la plus grande superficie en premier
SELECT * FROM logement ORDER BY surface ASC
Trouvez la requête SQL permettant d’afficher les logements ayant le prix le moins cher en premier
SELECT * FROM logement ORDER BY prix DESC
Trouvez la requête SQL permettant d’afficher les logements ayant le code postal 75
SELECT * FROM logement WHERE cp = 75
Trouvez la requête SQL permettant d’afficher les logements proposés à la vente uniquement
SELECT * FROM logement WHERE type = 'vente'
Trouvez la requête SQL permettant d’afficher le nombre de logement à la vente et à la location 
SELECT * FROM logement WHERE type = 'location' && type = 'vente'
*/