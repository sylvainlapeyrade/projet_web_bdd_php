<?php

session_start();
include_once(dirname(__FILE__).'/../../fonctions/variables.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionRecompense.php');
include_once(dirname(__FILE__).'/../../bdd/connexion.php');

$info['head']['subTitle'] = "Gestion recompense";
$info['head']['stylesheets'] = ['adminGestion.css'];

if(!is_connect() || !is_admin()) {leave();}

include_once(dirname(__FILE__).'/actionRecompense.php');

if ( isset($db) ) {
    $listeRecompense = recuperer_recompense_tous($db);
}

include_once(dirname(__FILE__).'/../../head.php');

?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
    <section>
        <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
        <div>
            <?php include_once(dirname(__FILE__).'/headerRecompense.php'); ?>
            <div>
                
                <!-- TABLEAU
                    Nom Récompense - Date - Description
                -->
                <table id="tableauGestion">
                    
                <tr class="table-head">
                    <th class="width-350">Nom récompense</th>
                    <th class="width-250">Date récompense</th>
                    <th class="width-700">Description</th>
                </tr>

                <?php foreach($listeRecompense as $recompense) { ?>
                <tr class="table-lign">
                    <td> <?php echo $recompense['nomrecompense']; ?> </td>
                    <td> <?php echo format_date($recompense['daterecompense']); ?> </td>
                    <td> <?php echo $recompense['descriptionrecompense']; ?> </td>
                    <td class="button button-blue">
                        <a href="./formRecompense.php?idRecompense=<?php echo $recompense['idrecompense']; ?>">Modifier</a>
                    </td>
                    <td class="button button-red">
                        <a href="?action=supprimerRecompense&idRecompense=<?php echo $recompense['idrecompense']; ?>">Supprimer</a>
                    </td>
                </tr>
                <?php } ?>

                </table>
                <!-- FIN TABLEAU -->
                
            </div>
        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/../../footer.php'); ?>
