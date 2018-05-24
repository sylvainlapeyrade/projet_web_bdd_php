<?php

/**
 * @file recherche.php
 * @brief Effectue un lien entre la barre de recherche et la BDD
 * pour afficher les résultats de recherches sur le site
 */

session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionRecherche.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Resultat de recherche";
$info['head']['stylesheets'] = ['barreRecherche.css', 'recherche.css'];

$recherche = strtolower($_GET['recherche']);
if ( isset($db, $recherche) ) {
    $listeArtistesRecherche = rechercher_artiste($db, $recherche);
    $listeGroupesRecherche = rechercher_groupe($db, $recherche);
    $listeAlbumsRecherche = rechercher_album($db, $recherche);
    $listeMusiquesRecherche = rechercher_musique($db, $recherche);
} else {
    header('Location: /404.php');
}

include_once(dirname(__FILE__).'/head.php');

?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>

<main>
    <section>
        
        <?php include_once(dirname(__FILE__).'/barreRecherche.php'); ?>
        
        <div id="page-resultat-recherche">
            <?php if ( !empty($listeArtistesRecherche) ) { ?>
                <div>
                    <hr class="red1" size="2">
                    <h3 class="text-center"><span class="red1">ARTISTES</span> correspondants à votre recherche "<?php echo $recherche ?>"</h3>
                    <hr class="red1" size="2">
                    <?php foreach($listeArtistesRecherche as $artiste) { ?>
                        <div class="flex">
                            <img class="image-recherche" src="<?php echo $artiste['urlimageartiste']; ?>" />
                            <div class="information-recherche">
                                <?php echo ucwords($artiste['nomartiste'].' '.$artiste['prenomartiste']); ?>
                                <?php if ( !empty($artiste['nomscene']) ) { echo '('.ucwords($artiste['nomscene']).')'; } ?>
                                <a id="bouton-voir-plus" class="bouton bouton-forme2 bouton-red1" href="/artiste.php?idArtiste=<?php echo $artiste['idartiste']; ?>">Voir les détails</a>
                            </div>
                        </div>
                        <hr color="white" size="1">
                    <?php } ?>
                </div>
            <?php } ?>
            
            <?php if ( !empty($listeGroupesRecherche) ) { ?>
                <div>
                    <hr class="red1" size="2">
                    <h3 class="text-center"><span class="red1">GROUPES</span> correspondants à votre recherche "<?php echo $recherche ?>"</h3>
                    <hr class="red1" size="2">
                    <?php foreach($listeGroupesRecherche as $groupe) { ?>
                        <div class="flex">
                            <img class="image-recherche" src="<?php echo $groupe['urlimagegroupe']; ?>" />
                            <div class="information-recherche">
                                <?php echo ucwords($groupe['nomgroupe']); ?>
                                <a id="bouton-voir-plus" class="bouton bouton-forme2 bouton-red1" href="/groupe.php?idGroupe=<?php echo $groupe['idgroupe']; ?>">Voir les détails</a>
                            </div>
                        </div>
                        <hr color="white" size="1">
                    <?php } ?>
                </div>
            <?php } ?>
            
            <?php if ( !empty($listeAlbumsRecherche) ) { ?>
                <div>
                    <hr class="red1" size="2">
                    <h3 class="text-center"><span class="red1">ALBUMS</span> correspondants à votre recherche "<?php echo $recherche ?>"</h3>
                    <hr class="red1" size="2">
                    <?php foreach($listeAlbumsRecherche as $album) { ?>
                        <div class="flex">
                            <img class="image-recherche" src="<?php echo $album['urlpochettealbum']; ?>" />
                            <div class="information-recherche">
                                "<?php echo ucwords($album['nomalbum']); ?>"
                                sorti le
                                <?php echo $album['datealbum']; ?>
                                <br>
                                <a id="bouton-voir-plus" class="bouton bouton-forme2 bouton-red1" href="/album.php?idAlbum=<?php echo $album['idalbum']; ?>">Voir les détails</a>
                            </div>
                        </div>
                        <hr color="white" size="1">
                    <?php } ?>
                </div>
            <?php } ?>
            
            <?php if ( !empty($listeMusiquesRecherche) ) { ?>
                <div>
                    <hr class="red1" size="2">
                    <h3 class="text-center"><span class="red1">MUSIQUES</span> correspondants à votre recherche "<?php echo $recherche ?>"</h3>
                    <hr class="red1" size="2">
                    <?php foreach($listeMusiquesRecherche as $musique) { ?>
                        <div class="information-recherche">
                            "<?php echo ucwords($musique['titremusique']); ?>"
                            interprété par  
                            <?php if ( !empty($musique['nomscene']) ) {
                                echo ucwords($musique['nomscene']);
                            } else {
                                echo ucwords($musique['nomartiste'].' '.$musique['prenomartiste']);
                            } ?>
                            <a id="bouton-voir-plus" class="bouton bouton-forme2 bouton-red1" href="/musique.php?idMusique=<?php echo $musique['idmusique']; ?>">Voir les détails</a>
                        </div>
                        <hr color="white" size="1">
                    <?php } ?>
                </div>
            <?php } ?>
            
            <?php if ( empty($listeArtistesRecherche) && empty($listeGroupesRecherche) && empty($listeAlbumsRecherche) && empty($listeMusiquesRecherche) ) { ?>
                <div class="text-center"><h3>Aucun résultat pour votre recherche.</h3></div>
            <?php } ?>
            
        </div>

    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
