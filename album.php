<?php

session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionAlbum.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Page album";
$info['head']['stylesheets'] = ['album.css'];

$idAlbum = $_GET['idAlbum'];
if ( isset($db, $idAlbum) ) {
    $album = recuperer_album($db, $idAlbum)[0];
    if ( empty($album) ) {
        header('Location: /index.php');
    }
    $listeArtistesAlbum = recuperer_artiste_album($db, $idAlbum);
    $listeMusiquesAlbum = recuperer_musique_album($db, $idAlbum);
}

include_once(dirname(__FILE__).'/head.php');

?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>


<main>
    <section>
        <div id="barre-recherche">
            <form class="flex flex-center item-center">
                <span class="t20">Nouvelle recherche : </span>
                <input id="input-recherche"
                       type="text"
                       class="width-500"
                       name="recherche"
                       placeholder="Artiste, groupe, album ou musique"
                       />
                <input class="button" type="submit" value="Rechercher" />
            </form>
        </div>
        
        <!-- Présentation de l'album -->
        <div id="page-album">
            <div class="flex">
                <div id="description-album" class="flex-around">
                    
                    <div>
                        <h1 class="red1"><a><?php echo $album['nomalbum']; ?></a> - <a><?php echo $album['datealbum']; ?></a></h1>
                        <p>
                            <?php echo $album['descriptionalbum']; ?>
                            <br>
                        </p>
                        <p>
                            Il a été composé par:
                            <?php foreach($listeArtistesAlbum as $key => $artiste) { ?>
                            <a class="souligner" href="/artiste.php?idArtiste<?php echo $artiste['idartiste']; ?>">
                                <?php if ( !empty($artiste['nomscene']) ) {
                                    echo $artiste['nomscene'];
                                } else {
                                    echo $artiste['nomartiste'].' '.$artiste['prenomartiste'];
                                } ?>
                            </a>
                            <?php if ( $key != sizeof($listeArtistesAlbum)-1 ) { echo ' - '; } ?>
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
                                    <tr class="table-lign">
                                        <td>Piste n°1</td>
                                        <td><a>De retour</a></td>
                                        <td>3:30</td>
                                    </tr>
                                <?php } ?>
                            </table>
                            
                            <?php if ( empty($listeMusiquesAlbum) ) { ?>
                                <h3>Cette album ne contient pas encore de musique </h3>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
                
                <div>
                    <img id="imageAlbum" src="<?php echo $album['urlpochettealbum']; ?>">
                </div>
                
            </div>
            
            <?php include_once(dirname(__FILE__).'/commentaireAlbum.php'); ?>
            
        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>

