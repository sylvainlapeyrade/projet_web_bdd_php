<?php

session_start();
include_once(dirname(__FILE__).'/../../fonctions/variables.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionArtiste.php');
include_once(dirname(__FILE__).'/../../bdd/connexion.php');

$info['head']['subTitle'] = "Gestion artiste";
$info['head']['stylesheets'] = ['adminGestion.css'];

if(!is_connect() || !is_admin()) {leave();}

include_once(dirname(__FILE__).'/actionArtiste.php');

if ( isset($db) ) {
    $listArtiste = recuperer_artiste_tous($db);
}

include_once(dirname(__FILE__).'/../../head.php');

?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
    <section>
        <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
        <div>
            <?php include_once(dirname(__FILE__).'/headerArtiste.php'); ?>
            <div>

                <!-- TABLEAU
                    Nom Artiste - Prénom - Nom de scène - Date naissance
                -->
                <table id="tableauGestion">

                    <tr class="table-head">
                        <th class="width-350">Nom de l'artiste</th>
                        <th class="width-350">Prénom</th>
                        <th class="width-350">Nom de scène</th>
                        <th class="width-350">Date naissance</th>
                    </tr>

                    <!-- Liste Artiste -->
                    <?php foreach($listArtiste as $artiste) { ?>
                    <tr class="table-lign">
                        <td> <?php echo $artiste['nomartiste']; ?> </td>
                        <td> <?php echo $artiste['prenomartiste']; ?> </td>
                        <td> <?php echo $artiste['nomscene']; ?> </td>
                        <td> <?php echo format_date($artiste['datenaissanceartiste']); ?> </td>
                        <td class="bouton bouton-blue">
                            <a href="./formArtiste.php?idArtiste=<?php echo $artiste['idartiste'] ?>">Modifier</a>
                        </td>
                        <td class="bouton bouton-red">
                            <a href="./gestionArtiste.php?action=supprimerArtiste&idArtiste=<?php echo $artiste['idartiste'] ?>">Supprimer</a>
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