<?php

session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionMusique.php');
include_once(dirname(__FILE__).'/fonctions/fonctionEvaluer.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Page musique";
$info['head']['stylesheets'] = ['barreRecherche.css', 'musique.css', 'evaluation.css'];

$idMusique = $_GET['idMusique'];

include_once(dirname(__FILE__).'/evaluation/actionEvaluation.php');

$action = $_GET['action'];

if ( isset($db, $idMusique) ) {
    $musique = recuperer_musique($db, $idMusique)[0];
    if ( empty($musique) ) {
        header('Location: /404.php');
    }
    $listeArtistesMusique = recuperer_artiste_musique($db, $idMusique);
    $listeGenresMusique = recuperer_genre_musique($db, $idMusique);
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
        <div id="page-musique">
            <div class="flex flex-between">
                <div id="description-album" class="flex-around">
                    <div>
                        
                        <h1 class="red1"><?php if(isset($musique)){echo ucwords($musique['titremusique']);} ?> - <?php if(isset($musique)){echo $musique['datemusique'];} ?></h1>
                        
                        <div>
                            <?php if ( !empty($listeArtistesMusique) ) { ?>
                                <?php if ( sizeof($listeArtistesMusique) > 1 ) { echo "Artistes : "; } else { echo "Artiste : "; } ?>
                                <?php foreach($listeArtistesMusique as $key => $artiste) { ?>
                                    <a class="souligner" href="/artiste.php?idArtiste=<?php echo $artiste['idartiste']; ?>">
                                        <!-- Affichage soit le nom de scène soit le nom/prénom -->
                                        <?php if ( !empty($artiste['nomscene']) ) {
                                            echo ucwords($artiste['nomscene']);
                                        } else {
                                            echo ucwords($artiste['nomartiste'].' '.$artiste['prenomartiste']);
                                        } ?>
                                    </a>
                                    <?php if ( sizeof($listeArtistesMusique) > 1 && sizeof($listeArtistesMusique)-1 > $key ) { echo '&nbsp-&nbsp'; } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>

                        <div>
                            <?php if ( !empty($listeGenresMusique) ) {
                                if ( sizeof($listeGenresMusique) > 1 ) { echo "Genres : "; } else { echo "Genre : "; }
                                foreach($listeGenresMusique as $key => $genre) {
                                    echo $genre['nomgenre'];
                                    if ( sizeof($listeGenresMusique) > 1 && sizeof($listeGenresMusique)-1 > $key ) { echo '&nbsp-&nbsp'; }
                                }
                            } ?>
                        </div>
                        <br>
                        <div>
                            <?php if ( !empty($musique['descriptionmusique']) ) {
                                    echo $musique['descriptionmusique'];
                                } else { ?>
                                <p>Cette musique ne contient pas de description...</p>
                                <?php } ?>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- FIN PRESENTATION -->

            <?php include_once(dirname(__FILE__).'/evaluation/evaluation.php'); ?>
            
        </div>
        
    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>

