<?php

session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionAlbum.php');
include_once(dirname(__FILE__).'/fonctions/fonctionEvaluer.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Page album";
$info['head']['stylesheets'] = ['barreRecherche.css', 'album.css'];

$idAlbum = $_GET['idAlbum'];
$action = $_GET['action'];
$star = $_GET['star'];
if ( !isset($star) || empty($star) ) {
    $star = 0;
}

if ( isset($db, $idAlbum) ) {
    $album = recuperer_album($db, $idAlbum)[0];
    if ( empty($album) ) {
        header('Location: /index.php');
    }
    $listeArtistesAlbum = recuperer_artiste_album($db, $idAlbum);
    $listeMusiquesAlbum = recuperer_musique_album($db, $idAlbum);
    $listeEvaluations = recuperer_evaluation_album_tous($db, $idAlbum);
} else {
    header('Location: /index.php');
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
                        <h1 class="red1"><a><?php echo $album['nomalbum']; ?></a> - <a><?php echo $album['datealbum']; ?></a></h1>
                        <p>
                            <?php echo $album['descriptionalbum']; ?>
                            <br>
                        </p>
                        <p>
                            Il a été composé par:
                            <?php foreach($listeArtistesAlbum as $key => $artiste) { ?>
                                <a class="souligner" href="/artiste.php?idArtiste=<?php echo $artiste['idartiste']; ?>">
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
                    <img id="imageAlbum" src="<?php echo $album['urlpochettealbum']; ?>">
                </div>
                
            </div>
            <!-- FIN PRESENTATION -->
            
            <div id="liste-commentaire">
                <hr size="1" color=#e8491d>

                <? if ( isset($erreur) ) { ?>
                    <div class="red"><?php echo $erreurCommentaire; ?></div>
                <? } ?>

                <?php if ( is_connect() ) { ?>
                    <form action="/album.php" method="get">
                        <div class="rating">
                            <p id="stars"> Donnez une note à cette musique :
                                <a class="<?php if ($star>0) echo 'red' ?>" href="?idAlbum=<?php echo $idAlbum; ?>&star=1#stars">★</a>
                                <a class="<?php if ($star>1) echo 'red' ?>" href="?idAlbum=<?php echo $idAlbum; ?>&star=2#stars">★</a>
                                <a class="<?php if ($star>2) echo 'red' ?>" href="?idAlbum=<?php echo $idAlbum; ?>&star=3#stars">★</a>
                                <a class="<?php if ($star>3) echo 'red' ?>" href="?idAlbum=<?php echo $idAlbum; ?>&star=4#stars">★</a>
                                <a class="<?php if ($star>4) echo 'red' ?>" href="?idAlbum=<?php echo $idAlbum; ?>&star=5#stars">★</a>
                            </p>
                        </div>
                        <input type="hidden" name="idAlbum" value="<?php echo $idAlbum ?>" />
                        <input type="hidden" name="action" value="ajouterEvaluation" />
                        <textarea class="input-area" name="comments" cols="50" rows="5" placeholder="Votre commentaire ici..."></textarea>
                        <input class="bouton bouton-forme1 bouton-red1" type="reset" value="Réinitialiser">
                        <input class="bouton bouton-forme1 bouton-red1" type="submit" value="Envoyer">
                    </form>
                <?php } ?>

                <div class="comment">
                    <h2> Commentaires </h2>
                    <hr size="1" color=#e8491d>

                    <div>
                        <p>
                            <b>Identifiant</b>&nbsp; &nbsp;21 Mai 2017
                            <?php if ( is_admin() ) { ?> <a class="bouton bouton-forme2 bouton-red1">Supprimer</a> <?php } ?>
                        </p>
                        <p>Ceci est un commentaire. Pour l'instant, ce n'est qu'un test. On revient automatiquement à la ligne si le commentaire est trop long...</p>
                        <hr size="1" color=#e8491d>
                    </div>

                    <div>
                        <p>
                        <b>Identifiant</b>&nbsp; &nbsp;25 Avril 2018
                            <?php if ( is_admin() ) { ?> <a class="bouton bouton-forme2 bouton-red1">Supprimer</a> <?php } ?>
                        </p>
                        <p>Ceci est un commentaire. Pour l'instant, ce n'est qu'un test. On revient automatiquement à la ligne si le commentaire est trop long...</p>
                        <hr size="1" color=#e8491d>
                    </div>
                </div>
            </div>
            <!-- FIN COMMENTAIRE -->
            
        </div>
        
    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>

