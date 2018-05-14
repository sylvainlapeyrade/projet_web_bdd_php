<?php

session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionMusique.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Page musique";
$info['head']['stylesheets'] = ['barreRecherche.css', 'musique.css'];

$idMusique = $_GET['idMusique'];

include_once(dirname(__FILE__).'/actionEvaluation.php');

$action = $_GET['action'];
$note = $_GET['star'];
if ( !isset($note) || empty($note) || $note < 0 ||$note > 5 ) {
    $note = 0;
}

if ( isset($db, $idMusique) ) {
    $musique = recuperer_musique($db, $idMusique)[0];
    if ( empty($musique) ) {
        header('Location: /index.php');
    }
    $listeArtistesMusique = recuperer_artiste_musique($db, $idMusique);
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
        <div id="page-musique">
            <div class="flex flex-between">
                <div id="description-album" class="flex-around">
                    <div>
                        <h1 class="red1"><?php echo $musique['titremusique']; ?> - <?php echo $musique['datemusique']; ?></h1>
                        <div>
                            <?php if ( !empty($musique['descriptionmusique']) ) {
                                    echo $musique['descriptionmusique'];
                                } else { ?>
                                <p>Cette musique ne contient pas de description...</p>
                                <?php } ?>
                        </div>
                        <div>
                            <?php if ( !empty($listeArtistesMusique) ) { ?>
                                <?php if ( sizeof($listeArtistesMusique) > 1 ) { echo "Artistes : "; } else { echo "Artiste : "; } ?>
                                <?php foreach($listeArtistesMusique as $key => $artiste) { ?>
                                    <a class="souligner" href="/artiste.php?idArtiste=<?php echo $artiste['idartiste']; ?>">
                                        <?php if ( !empty($artiste['nomscene']) ) {
                                            echo $artiste['nomscene'];
                                        } else {
                                            echo $artiste['nomartiste'].' '.$artiste['prenomartiste'];
                                        } ?>
                                    </a>
                                    <?php if ( sizeof($listeArtistesMusique) > 1 && sizeof($listeArtistesMusique)-1 > $key ) { echo '&nbsp-&nbsp'; } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <!--p>
                            [Optionnel] Cette musique a été composé en collaboration avec <a>Nom_Artistes</a>
                        </p>
                        <p>
                            C'est la piste numero <a>Numero_Piste</a> de l'album <a>Nom_Album1</a><br>
                            C'est la piste numero <a>Numero_Piste</a> de l'album <a>Nom_Album2</a><br>
                            [Ou]<br>
                            Ce morceau est un single, il ne fait pas partie d'un album.
                        </p-->
                    </div>
                </div>
            </div>
            <!-- FIN PRESENTATION -->

            <!-- COMMENTAIRE -->
            <div id="liste-commentaire">
                <hr size="1" color=#e8491d>
                
                <?php if ( isset($_GET['operation']) && $_GET['operation'] == 'ok' ) { ?>
                    <div class="green">L'opération a été effectué.</div>
                <?php } ?>
                
                <?php if ( isset($erreur) ) { ?>
                    <div class="red"><?php echo $erreur; ?></div>
                <?php } ?>

                <?php if ( is_connect() ) { ?>
                    <form id="form" action="/album.php" method="get">
                        <div>
                            <p id="stars"> Donnez une note à cette musique :
                                <a class="<?php if ($note>0) echo 'red' ?>" href="?idAlbum=<?php echo $idAlbum; ?>&star=1#stars">★</a>
                                <a class="<?php if ($note>1) echo 'red' ?>" href="?idAlbum=<?php echo $idAlbum; ?>&star=2#stars">★</a>
                                <a class="<?php if ($note>2) echo 'red' ?>" href="?idAlbum=<?php echo $idAlbum; ?>&star=3#stars">★</a>
                                <a class="<?php if ($note>3) echo 'red' ?>" href="?idAlbum=<?php echo $idAlbum; ?>&star=4#stars">★</a>
                                <a class="<?php if ($note>4) echo 'red' ?>" href="?idAlbum=<?php echo $idAlbum; ?>&star=5#stars">★</a>
                            </p>
                        </div>
                        <?php if ( isset($idAlbum) ) { ?>
                            <input type="hidden" name="idAlbum" value="<?php echo $idAlbum ?>" />
                        <?php } elseif ( isset($idMusique) ) { ?>
                            <input type="hidden" name="idMusique" value="<?php echo $idMusique ?>" />
                        <?php } ?>
                        <input type="hidden" name="action" value="ajouterEvaluation" />
                        <input type="hidden" name="note" value="<?php echo $note ?>" />
                        <textarea class="input-area"
                                  name="commentaire"
                                  cols="50"
                                  rows="5"
                                  <?php if ( !isset($note) || empty($note) ) { echo 'disabled'; } ?>
                                  placeholder="Votre commentaire ici..."
                                  required ><?php echo $commentaire ?></textarea>
                        <a class="bouton bouton-forme1 bouton-red1" href="album.php?idAlbum=<?php echo $idAlbum; ?>#form">Réinitialiser</a>
                        <input class="bouton bouton-forme1 bouton-red1" type="submit" value="Envoyer">
                    </form>
                <?php } else { ?>
                    <p><a class="souligner red1" href="/compte/connexion.php">Connectez-vous</a> pour poster un commentaire.</p>
                <?php } ?>

                <div class="comment">
                    <h2> Commentaires : </h2>
                    <hr size="1" color=#e8491d>
                    <?php if ( !empty($listeEvaluations) ) { ?>
                        <?php foreach($listeEvaluations as $evaluation) { ?>
                            <div>
                                <p>
                                    <b><?php echo $evaluation['idutilisateureval']; ?></b>&nbsp; &nbsp;Notes : <?php echo $evaluation['noteeval']; ?>
                                    <?php if ( is_admin() || $_SESSION['idUtilisateur'] == $evaluation['idutilisateureval'] ) { ?> <a class="bouton bouton-forme2 bouton-red1">Supprimer</a> <?php } ?>
                                </p>
                                <p><?php echo $evaluation['commentaireeval'] ?></p>
                                <hr size="1" color=#e8491d>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php if ( empty($listeEvaluations) ) { ?>
                        <h3>Il n'y a pas encore de commentaire.</h3>
                    <?php } ?>
                </div>
            </div>
            <!-- FIN COMMENTAIRE -->
        
        </div>
        
    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>

