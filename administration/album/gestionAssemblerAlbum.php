<?php
session_start();
include_once(dirname(__FILE__).'/../../fonctions/variables.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionArtiste.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionAlbum.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionGenre.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionMusique.php');
include_once(dirname(__FILE__).'/../../bdd/connexion.php');

$info['head']['subTitle'] = "Gestion album";
$info['head']['stylesheets'] = ['adminGestion.css'];

if(!is_connect() || !is_admin()) {leave();}

include_once(dirname(__FILE__).'/actionAssemblerAlbum.php');

if ( !isset($idAlbum) || empty($idAlbum) ) {
    header('Location: ./gestionAlbum.php');
}


if ( isset($db) ) {
    $listeMusique = recuperer_musique_album($db, $idAlbum);
}

include_once(dirname(__FILE__).'/../../head.php');

?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
    <section>
        <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
        <div>
            <?php include_once(dirname(__FILE__).'/headerAssemblerAlbum.php'); ?>
            <div>

                <!-- TABLEAU
                    Numéro de piste - Titre musique - Durée
                -->
                <table id="tableauGestion">
                    
                    <tr class="table-head">
                        <th class="width-200">Numéro de piste</th>
                        <th class="width-350">Tite musique</th>
                        <th class="width-300">Durée</th>
                    </tr>

                    <?php foreach($listeMusique as $musique) { ?>
                    <tr class="table-lign">
                        <td> <?php echo $musique['numeropiste']; ?> </td>
                        <td> <?php echo $musique['titremusique']; ?> </td>
                        <td> <?php echo $musique['dureemusique']; ?> </td>
                        <td class="button button-blue">
                            <a href="./formAssemblerAlbum.php?idAlbum=<?php echo $idAlbum ?>&idMusique=<?php echo $musique['idmusique'] ?>">Modifier</a>
                        </td>
                        <td class="button button-red">
                            <a href="./gestionAssemblerAlbum.php?action=supprimerAssemblerAlbum&idAlbum=<?php echo $idAlbum ?>&idMusique=<?php echo $musique['idmusique'] ?>">Supprimer</a>
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