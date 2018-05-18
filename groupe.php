<?php

session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionGroupe.php');
include_once(dirname(__FILE__).'/fonctions/fonctionMusique.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Page groupe";
$info['head']['stylesheets'] = ['barreRecherche.css', 'groupe.css'];

$idGroupe = $_GET['idGroupe'];
if ( isset($db, $idGroupe) ) {
    $groupe = recuperer_groupe($db, $idGroupe)[0];
    if ( empty($groupe) ) {
        header('Location: /404.php');
    }
    $listeArtistesGroupe = recuperer_artiste_groupe($db, $idGroupe);
    $listeMusiquesGroupe = recuperer_musique_album_groupe($db, $idGroupe);
} else {
    header('Location: /404.php');
}

include_once(dirname(__FILE__).'/head.php');

?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>


<main>
    <section>

        <?php include_once(dirname(__FILE__).'/barreRecherche.php'); ?>

        <div id="page-groupe">
            <!-- Présentation du groupe -->
            <div class="flex flex-between">
                <div id="description-groupe" class="flex-around">
                    
                    <h1 class="red1"><?php if(isset($groupe)){echo ucwords($groupe['nomgroupe']);} ?> - <?php if(isset($groupe)){echo $groupe['dategroupe'];} ?></h1>
                    
                    <div id="liste-membre" class="text-center flex flex-arround">
                        <?php if ( sizeof($listeArtistesGroupe) > 1 ) { echo "Membres "; } else { echo "Membre "; } ?> du groupe : 
                        <?php foreach($listeArtistesGroupe as $key => $artiste) { ?>
                            <a class="souligner" href="/artiste.php?idArtiste=<?php echo $artiste['idartiste']; ?>">
                                <?php if ( !empty($artiste['nomscene']) ) {
                                    echo ucwords($artiste['nomscene']);
                                } else {
                                    echo ucwords($artiste['nomartiste'].' '.$artiste['prenomartiste']);
                                } ?>
                            </a>
                            <?php if ( sizeof($listeArtistesGroupe) > 1 && sizeof($listeArtistesGroupe)-1 > $key ) { echo '&nbsp-&nbsp'; } ?>
                        <?php } ?>
                    </div>
                    
                    <div>
                        <?php if(isset($groupe)){echo $groupe['descriptiongroupe'];} ?>
                    </div>
                    
                </div>

                <?php if ( !empty($groupe['urlimagegroupe']) ) { ?>
                    <div>
                        <img id="imageGroupe" src="<?php echo $groupe['urlimagegroupe']; ?>">
                    </div>
                <?php } ?>

            </div>

            <!-- Musiques du groupe -->
            <div>
                <hr>
                <div id="liste-musiques" class="text-center">
                    <h4>Musiques du groupe</h4>
                    <table class="text-center">
                        
                        <tr>
                            <th class="table-head width-300">Titre</th>
                            <th class="table-head width-150">Durée</th>
                            <th class="table-head width-150">Date</th>
                            <th class="table-head width-200">Genre</th>
                            <th class="table-head width-300">Album</th>
                            <th class="table-head width-700">Descritpion</th>
                        </tr>
                        <?php if ( !empty($listeMusiquesGroupe) ) { ?>
                            <?php foreach($listeMusiquesGroupe as $musique) { ?>
                            <?php } ?>
                        <?php } ?>
                        
                        <?php if ( !empty($listeMusiquesGroupe) ) { ?>
                            <?php foreach($listeMusiquesGroupe as $musique) { ?>
                                <?php /* Recherche des genres de la musique */
                                    if ( isset($db) ) { $listeGenresMusique = recuperer_genre_musique($db, $musique['idmusique']); }
                                ?>
                                <tr class="table-lign">
                                    <td><a class="souligner" href="/musique.php?idMusique=<?php echo $musique['idmusique']; ?>"> <?php echo ucwords($musique['titremusique']); ?> </a></td>
                                    <td> <?php echo format_duree($musique['dureemusique']); ?> </td>
                                    <td> <?php echo $musique['datemusique']; ?></td>
                                    <td>
                                        <?php if ( !empty($listeGenresMusique) ) {
                                            foreach($listeGenresMusique as $key => $genre) {
                                                echo $genre['nomgenre'];
                                                if ( sizeof($listeGenresMusique) > 1 && sizeof($listeGenresMusique)-1 > $key ) { echo '&nbsp-&nbsp'; }
                                            }
                                        } ?>
                                    </td>
                                    <td><a class="souligner" href="/album.php?idAlbum=<?php echo $musique['idalbum']; ?>"> <?php echo ucwords($musique['nomalbum']); ?> </a></td>
                                    <td> <?php echo $musique['descriptionmusique']; ?> </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        
                    </table>
                            
                    <?php if ( empty($listeMusiquesGroupe) ) { ?>
                        <h3>Ce groupe n'a pas de musique.</h3>
                    <?php } ?>
                </div>
                
            </div>

        </div>

    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>

