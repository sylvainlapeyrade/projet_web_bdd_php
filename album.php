<?php

session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionAlbum.php');
include_once(dirname(__FILE__).'/fonctions/fonctionEvaluer.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Page album";
$info['head']['stylesheets'] = ['barreRecherche.css', 'album.css', 'evaluation.css'];

$idAlbum = $_GET['idAlbum'];

include_once(dirname(__FILE__).'/evaluation/actionEvaluation.php');

$action = $_GET['action'];

if ( isset($db, $idAlbum) ) {
    $album = recuperer_album($db, $idAlbum)[0];
    if ( empty($album) ) {
        header('Location: /404.php');
    }
    $listeArtistesAlbum = recuperer_artiste_album($db, $idAlbum);
    $listeMusiquesAlbum = recuperer_musique_album($db, $idAlbum);
} else {
    header('Location: /404.php');
}

include_once(dirname(__FILE__).'/head.php');

?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>


<main>
    <section>

        <?php include_once(dirname(__FILE__).'/barreRecherche.php'); ?>

        <!-- PRESENTATION -->
        <div id="page-album">
            <div class="flex flex-between">
                <div id="description-album" class="flex-around">

                    <div>
                        <h1 class="red1"><a><?php if(isset($album)) {echo $album['nomalbum'];} ?></a> - <a><?php if(isset($album)) {echo $album['datealbum'];} ?></a></h1>
                        
                        <p>
                            <?php if(isset($album)) {echo $album['descriptionalbum'];} ?>
                            <br>
                        </p>
                        
                        <p>
                            Il a été composé par:
                            <?php foreach($listeArtistesAlbum as $key => $artiste) { ?>
                                <a class="souligner" href="/artiste.php?idArtiste=<?php echo $artiste['idartiste']; ?>">
                                    <!-- Affichage soit le nom de scène soit le nom/prénom -->
                                    <?php if ( !empty($artiste['nomscene']) ) {
                                        echo $artiste['nomscene'];
                                    } else {
                                        echo $artiste['nomartiste'].' '.$artiste['prenomartiste'];
                                    } ?>
                                </a>
                                <?php if ( sizeof($listeArtistesAlbum) > 1 && sizeof($listeArtistesAlbum)-1 > $key ) { echo '&nbsp-&nbsp'; } ?>
                            <?php } ?>
                        </p>
                    </div>

                    <div id="liste-musiques" class="flex text-center flex-arround">
                        <div>
                            <h4>Morceaux de l'album:</h4>

                            <table class="text-center">
                                <tr>
                                    <th class="table-head width-200">Numéro de piste</th>
                                    <th class="table-head width-600">Titre</th>
                                    <th class="table-head width-150">Durée</th>
                                </tr>
                                <?php if ( !empty($listeMusiquesAlbum) ) { ?>
                                    <?php foreach($listeMusiquesAlbum as $musique) { ?>
                                        <tr class="table-lign">
                                            <td> Piste n°<?php echo $musique['numeropiste']; ?> </td>
                                            <td><a class="souligner" href="/musique.php?idMusique=<?php echo $musique['idmusique']; ?>"> <?php echo $musique['titremusique']; ?> </a></td>
                                            <td> <?php echo format_duree($musique['dureemusique']); ?> </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </table>

                            <?php if ( empty($listeMusiquesAlbum) ) { ?>
                                <h3>Cette album ne contient pas encore de musique </h3>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div>
                    <img id="imageAlbum" src="<?php if(isset($album)) {echo $album['urlpochettealbum'];} ?>">
                </div>

            </div>
            <!-- FIN PRESENTATION -->
            
            <?php include_once(dirname(__FILE__).'/evaluation/evaluation.php'); ?>

        </div>

    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>

