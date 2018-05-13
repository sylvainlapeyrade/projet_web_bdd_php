<?php

session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionArtiste.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Page artiste";
$info['head']['stylesheets'] = ['artiste.css'];

$idArtiste = $_GET['idArtiste'];
if ( isset($db, $idArtiste) ) {
    $artiste = recuperer_artiste($db, $idArtiste)[0];
    if ( empty($artiste) ) {
        header('Location: /index.php');
    }
    $listeGroupesArtiste = recuperer_groupe_artiste($db, $idArtiste);
    $listeRecompensesArtiste = recuperer_recompense_artiste($db, $idArtiste);
    $listeMusiquesArtiste = recuperer_musique_album_artiste($db, $idArtiste);
} else {
    header('Location: /index.php');
}

include_once(dirname(__FILE__).'/head.php');

?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>

<main>
    <section>
        
        <div id="barre-recherche">
            <form class="flex flex-center item-center" action="/recherche.php" method="get">
                <span class="t20">Nouvelle recherche : </span>
                <input id="input-recherche"
                       type="text"
                       class="width-500"
                       name="recherche"
                       placeholder="Artiste, groupe, album ou musique"
                       />
                <input class="bouton" type="submit" value="Rechercher" />
            </form>
        </div>
        
        <div id="page-artiste">
            <!-- Présentation de l'artiste -->
            <div class="flex flex-between">
                <div id="description-artiste" class="flex-around">
                    <div>
                        <h1 class="red1">
                            <?php
                                echo $artiste['nomartiste'].' '.$artiste['prenomartiste'];
                                if ( !empty($artiste['nomscene']) )
                                    echo ' - '.$artiste['nomscene'];
                            ?>
                        </h1>
                        <p>
                            <?php echo $artiste['descriptionartiste']; ?>
                        </p>
                        <p>
                            <?php if ( !empty($listeGroupesArtiste) ) {
    
                                    if ( sizeof($listeGroupesArtiste) > 1 ) {
                                        echo 'Il fait parti des groupes : ';
                                    } else {
                                        echo 'Il fait parti du groupe : ';
                                    }
                                ?>
                                <?php foreach($listeGroupesArtiste as $key => $groupe) { ?>
                                    <a class="souligner" href="/groupe.php?idGroupe=<?php echo $groupe['idgroupe']; ?>">
                                        <?php echo $groupe['nomgroupe']; ?>
                                    </a>
                                    <?php if ( sizeof($listeGroupesArtiste) > 1 && sizeof($listeGroupesArtiste)-1 > $key ) { echo '&nbsp-&nbsp'; } ?>
                                <?php } ?>
                            <?php } ?>
                        </p>
                    </div>
                    
                    <!-- Récompense de l'artiste -->
                    <div id="liste-recompense" class="text-center flex flex-column">
                        <h4>Récompenses de l'artiste</h4>
                        <table class="width-500 margin-center">
                            <tr>
                                <th class="table-head width-250">Nom</th>
                                <th class="table-head width-250">Date</th>
                            </tr>
                            <?php if ( !empty($listeRecompensesArtiste) ) { ?>
                                <?php foreach($listeRecompensesArtiste as $recompense) { ?>
                                    <tr class="table-lign">
                                        <td> <?php echo $recompense['nomrecompense']; ?> </td>
                                        <td> <?php echo $recompense['daterecompense']; ?> </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </table>
                            
                        <?php if ( empty($listeRecompensesArtiste) ) { ?>
                            <h3>Cette artiste n'a pas reçu de récompense.</h3>
                        <?php } ?>
                    </div>
                </div>
                
                <div>
                    <img id="imageArtiste" src="<?php echo $artiste['urlimageartiste']; ?>">
                </div>
            </div>

            <!-- Musiques de l'artiste -->
            <div>
                <hr>
                <div id="liste-musiques" class="text-center">
                    <h4>Musiques de l'artiste</h4>
                    <table class="text-center">
                        <tr>
                            <th class="table-head width-300">Titre</th>
                            <th class="table-head width-150">Durée</th>
                            <th class="table-head width-150">Date</th>
                            <th class="table-head width-200">Genre</th>
                            <th class="table-head width-300">Album</th>
                            <th class="table-head width-700">Descritpion</th>
                        </tr>
                        <?php if ( !empty($listeMusiquesArtiste) ) { ?>
                            <?php foreach($listeMusiquesArtiste as $musique) { ?>
                                <tr class="table-lign">
                                    <td><a class="souligner" href="/musique.php?idMusique=<?php echo $musique['idmusique']; ?>"> <?php echo $musique['titremusique']; ?> </a></td>
                                    <td> <?php echo format_duree($musique['dureemusique']); ?> </td>
                                    <td> <?php echo $musique['datemusique']; ?></td>
                                    <td> - </td>
                                    <td><a class="souligner" href="/album.php?idAlbum=<?php echo $musique['idalbum']; ?>"> <?php echo $musique['nomalbum']; ?> </a></td>
                                    <td> <?php echo $musique['descriptionmusique']; ?> </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </table>
                            
                    <?php if ( empty($listeMusiquesArtiste) ) { ?>
                        <h3>Cette artiste n'a pas de musique.</h3>
                    <?php } ?>
                    
                </div>
            </div>
            
        </div>
        
    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
