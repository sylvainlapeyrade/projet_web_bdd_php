<?php

session_start();
include_once(dirname(__FILE__).'/../../fonctions/variables.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionArtiste.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionGroupe.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionAlbum.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionGenre.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionMusique.php');
include_once(dirname(__FILE__).'/../../bdd/connexion.php');

$info['head']['subTitle'] = "Gestion musique";
$info['head']['stylesheets'] = ['adminGestion.css'];

if(!is_connect() || !is_admin()) {leave();}

$idMusique = $_GET['idMusique'];
if ( isset($db, $idMusique) ) {
    $musique = recuperer_musique($db, $idMusique)[0];
    if ( empty($musique) ) {
        header('Location: ./gestionMusique.php');
    }
    $titreMusique = $musique['titremusique'];
    $dureeMusique = $musique['dureemusique'];
    $dateMusique = $musique['datemusique'];
    $descriptionMusique = $musique['descriptionmusique'];
    $composerMusique = recuperer_composer_musique($db, $idMusique);
    foreach($composerMusique as $idArtisteCoMu) {
        $listeArtisteMusique[] = $idArtisteCoMu['idartistecomu'];
    }
    $composerMusiqueGr = recuperer_composer_musiqueGr($db, $idMusique);
    foreach($composerMusiqueGr as $idGroupeCoMr) {
        $listeGroupeMusique[] = $idGroupeCoMr['idgroupecomr'];
    }
    $definirMusique = recuperer_genre($db, $idMusique);
    foreach($definirMusique as $nomGenre) {
        $listeGenreMusique[] = $nomGenre['nomgenre'];
    }
}

include_once(dirname(__FILE__).'/actionMusique.php');

if ( isset($db) ) {
    $artistes = recuperer_artiste_tous($db);
    $groupes = recuperer_groupe_tous($db);
    $albums = recuperer_album_tous($db);
    $genres = ['Jazz', 'Hip-Hop', 'Rock', 'Dance', 'Dark-Métal', 'Pop', 'Electro', 'House', 'Mambo'];
}

include_once(dirname(__FILE__).'/../../head.php');

?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
    <section>
        <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
        <div>
            <?php include_once(dirname(__FILE__).'/headerMusique.php'); ?>
            <div class="text-center">
                <h1>Formulaire Musique</h1>

                <!-- FORMULAIRE :
                    titreMusique : text
                    dureeMusique : number
                    dateMusique : date
                    descriptionMusique : textarea
                    listeGenreMusique : multiple checkbox
                    listeIdArtiste : multiple checkbox
                -->
                <form class="flex flex-center flex-column" action="./formMusique.php" method="get">
                    
                    <div class="flex">
                        <div class="width-700 margin-center flex flex-column">
                            <input type="text" 
                                   class="input-text"
                                   name="titreMusique"
                                   placeholder="Titre musique"
                                   value="<?php if(isset($titreMusique)){echo $titreMusique;} ?>"
                                   required
                                   />

                            <label for="dureeMusique" class="text-center"> Durée (en secondes) :
                                <input type="number"
                                       class="input-number"
                                       name="dureeMusique"
                                       value="<?php if(isset($dureeMusique)){echo $dureeMusique;} ?>"
                                       placeholder="0"
                                       required
                                       />
                            </label>

                            <label for="dateRecompense" class="text-center"> Date de création :
                            <input type="date"
                                   placeholder="<?php echo format_date(format_date(date("Y/m/d"))); ?>"
                                   pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"
                                   class="input-date"
                                   name="dateMusique"
                                   value="<?php if(isset($dateMusique)){echo format_date($dateMusique);} ?>"
                                   required
                                   />
                            </label>

                            <textarea class="input-area" 
                                      name="descriptionMusique" 
                                      rows="5"
                                      placeholder="Description de la musique"><?php if(isset($descriptionMusique)){echo $descriptionMusique;} ?></textarea>
                        </div>

                        <div class="width-800">
                            
                            <!-- Liste des genres disponible -->
                            <h4>Genres :</h4>
                            <div id="box-item-checkbox" class="liste-checkbox flex flex-center flex-wrap">
                                <?php foreach($genres as $genre) { ?>
                                    <label class="item-checkbox">
                                        <input type="checkbox"
                                               name="nomGenre<?php echo $genre ?>"
                                               value="<?php echo $genre ?>"
                                               <?php if ( isset($listeGenreMusique) && in_array($genre, $listeGenreMusique) ) { echo "checked"; } ?>
                                               />
                                        <?php echo $genre ?>
                                    </label>
                                <?php } ?>
                            </div>

                            <!-- Liste de tous les artistes -->
                            <h4>Artistes :</h4>
                            <div id="box-item-checkbox" class="liste-checkbox flex flex-center flex-wrap">
                                <?php foreach($artistes as $artiste) { ?>
                                    <label class="item-checkbox">
                                        <input type="checkbox"
                                               name="idArtiste<?php echo $artiste['idartiste']; ?>"
                                               value="<?php echo $artiste['idartiste'] ?>"
                                               <?php if ( isset($listeArtisteMusique) && in_array($artiste['idartiste'], $listeArtisteMusique) ) { echo "checked"; } ?>
                                               />
                                        <!-- Affichage soit le nom de scène soit le nom/prénom -->
                                        <?php if ( !empty($artiste['nomscene']) ) {
                                            echo $artiste['nomscene'];
                                        } else {
                                            echo $artiste['nomartiste'].' '.$artiste['prenomartiste'];
                                        } ?>
                                    </label>
                                <?php } ?>
                            </div>

                            <!-- Liste de tous les groupes -->
                            <h4>Groupes :</h4>
                            <div id="box-item-checkbox" class="liste-checkbox flex flex-center flex-wrap">
                                <?php foreach($groupes as $groupe) { ?>
                                    <label class="item-checkbox">
                                        <input type="checkbox"
                                               name="idGroupe<?php echo $groupe['idgroupe']; ?>"
                                               value="<?php echo $groupe['idgroupe'] ?>"
                                               <?php if ( isset($listeGroupeMusique) && in_array($groupe['idgroupe'], $listeGroupeMusique) ) { echo "checked"; } ?>
                                               />
                                        <?php echo $groupe['nomgroupe']; ?>
                                    </label>
                                <?php } ?>
                            </div>
                            
                        </div>

                    </div>

                    <!-- BOUTON AJOUTER/MODIFIER AVEC CHAMPS CACHES -->
                    <?php  if ( isset($idMusique) && !empty($idMusique) ) { /** BOUTON POUR MODIFIER */ ?>
                    <input type="hidden" 
                           name="idMusique" 
                           value="<?php echo $idMusique ?>"
                           />
                    <input type="hidden"
                           name="action" 
                           value="modifierMusique"
                           />
                    <input class="inputButton1" 
                           type="submit" 
                           value="modifier"
                           />
                    <?php } else { /********************************* BOUTON POUR AJOUTER */ ?>
                    <input type="hidden" 
                           name="action" 
                           value="ajouterMusique"
                           />
                    <input class="inputButton1" 
                           type="submit" 
                           value="ajouter"
                           />
                    <?php } ?>
                    
                </form>
                <!-- FIN FORMULAIRE -->

            </div>
        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/../../footer.php'); ?>