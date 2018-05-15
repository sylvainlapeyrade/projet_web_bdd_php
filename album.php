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

$action = $_GET['action'];

if ( isset($db, $idAlbum) ) {
    $album = recuperer_album($db, $idAlbum)[0];
    if ( empty($album) ) {
        header('Location: /index.php');
    }
    $listeArtistesAlbum = recuperer_artiste_album($db, $idAlbum);
    $listeMusiquesAlbum = recuperer_musique_album($db, $idAlbum);
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
                        <h1 class="red1"><a><?php if(isset($album)) {echo $album['nomalbum'];} ?></a> -
                            <a><?php if(isset($album)) {echo $album['datealbum'];} ?></a></h1>
                        <p>
                            <?php if(isset($album)) {echo $album['descriptionalbum'];} ?>
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
                    <img id="imageAlbum" src="<?php if(isset($album)) {echo $album['urlpochettealbum'];} ?>">
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
                                  required ><?php if(isset($commentaire)) {echo $commentaire;} ?></textarea>
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
                                    <b><?php echo $evaluation['idutilisateureval']; ?></b>&nbsp; &nbsp;Note : <?php echo $evaluation['noteeval']; ?>/5
                                    <?php if ( is_admin() || $_SESSION['idUtilisateur'] == $evaluation['idutilisateureval'] ) { ?>
                                        <a class="bouton bouton-forme2 bouton-red1" href="/album.php?action=supprimerEvaluation&idAlbum=<?php echo $idAlbum; ?>&idUtilisateur=<?php echo $evaluation['idutilisateureval']; ?>">Supprimer</a>
                                    <?php } ?>
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

