<?php
/**
 * Page formAlbum.php
 * Permet d'ajouter un album à la BBD
 */

session_start();
include_once(dirname(__FILE__).'/../../fonctions/variables.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionArtiste.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionGroupe.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionAlbum.php');
include_once(dirname(__FILE__).'/../../bdd/connexion.php');

$info['head']['subTitle'] = "Gestion groupe";
$info['head']['stylesheets'] = ['adminGestion.css'];

if(!is_connect() || !is_admin()) {leave();}
if(isset($db)){
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
}

$idAlbum = $_GET['idAlbum'];
if ( isset($db, $idAlbum) ) {
    $album = recuperer_album($db, $idAlbum)[0];
    if ( empty($album) ) {
        header('Location: ./gestionAlbum.php');
    }
    $nomAlbum = $album['nomalbum'];
    $dateAlbum = $album['datealbum'];
    $descriptionAlbum = $album['descriptionalbum'];
    $urlPochetteAlbum = $album['urlpochettealbum'];
    $constituerAlbum = recuperer_composer_album($db, $idAlbum);
    foreach($constituerAlbum as $idArtisteCoAl) {
        $listeArtisteAlbum[] = $idArtisteCoAl['idartistecoal'];
    }
    $composerAlbumGr = recuperer_composer_albumGr($db, $idAlbum);
    foreach($composerAlbumGr as $idGroupeCoAr) {
        $listeGroupeAlbum[] = $idGroupeCoAr['idgroupecoar'];
    }
}

include_once(dirname(__FILE__).'/actionAlbum.php');

if ( isset($db) ) {
    $artistes = recuperer_artiste_tous($db);
    $groupes = recuperer_groupe_tous($db);
}

include_once(dirname(__FILE__).'/../../head.php');

include_once(dirname(__FILE__).'/../../header.php');

?>

<main>
    <section>
        <?php include_once(dirname(__FILE__) . '/../headerAdmin.php'); ?>
        <div>
            <?php include_once(dirname(__FILE__).'/headerAlbum.php'); ?>
            <div class="text-center">
                <h1>Formulaire Album</h1>

                <!-- FORMULAIRE :
                     nomAlbum : text
                     dateAlbum : date
                     urlPochetteAlbum : text
                     descriptionAlbum : textarea
                     listeIdArtiste : multiple checkbox
                -->
                <form class="flex flex-center flex-column" action="./formAlbum.php" method="get">
                    
                    <div class="flex">
                        <div class="flex flex-column width-800">
                            <input type="text"
                                   class="input-text"
                                   name="nomAlbum"
                                   placeholder="Titre album"
                                   value="<?php if(isset($nomAlbum)){echo $nomAlbum;} ?>"
                                   required
                            />

                            <label for="dateAlbum" class="text-center">
                                Date de création:
                                <input type="date"
                                       placeholder="<?php echo format_date(format_date(date("Y/m/d"))); ?>"
                                       pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"
                                       class="input-date"
                                       name="dateAlbum"
                                       value="<?php if(isset($dateAlbum)){echo format_date($dateAlbum);} ?>"
                                       required
                                />
                            </label>

                            <input type="text"
                                   class="input-text"
                                   name="urlPochetteAlbum"
                                   placeholder="Url pochette album"
                                   value="<?php if(isset($urlPochetteAlbum)){echo $urlPochetteAlbum;} ?>"
                            />
                            <br><br>

                            <textarea class="input-area"
                                      name="descriptionAlbum"
                                      rows="5"
                                      placeholder="Description de l'album"><?php if(isset($descriptionAlbum)){echo $descriptionAlbum;} ?></textarea>
                        </div>
                        
                        <div class="width-800">
                            
                            <!-- Liste de tous les artistes -->
                            <h4>Artistes : </h4>
                            <div id="box-item-checkbox" class="liste-checkbox flex flex-center flex-wrap">
                                <?php foreach($artistes as $artiste) { ?>
                                    <div class="item-checkbox">
                                        <input type="checkbox"
                                               title="idArtiste<?php echo $artiste['idartiste']; ?>"
                                               name="idArtiste<?php echo $artiste['idartiste']; ?>"
                                               value="<?php echo $artiste['idartiste'] ?>"
                                               <?php if ( isset($listeArtisteAlbum) && in_array($artiste['idartiste'], $listeArtisteAlbum) ) { echo "checked"; } ?>
                                               />
                                        <!-- Affichage soit le nom de scène soit le nom/prénom -->
                                        <?php if ( !empty($artiste['nomscene']) ) {
                                            echo $artiste['nomscene'];
                                        } else {
                                            echo $artiste['nomartiste'].' '.$artiste['prenomartiste'];
                                        } ?>
                                    </div>
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
                                               <?php if ( isset($listeGroupeAlbum) && in_array($groupe['idgroupe'], $listeGroupeAlbum) ) { echo "checked"; } ?>
                                               />
                                        <?php echo $groupe['nomgroupe']; ?>
                                    </label>
                                <?php } ?>
                            </div>
                            
                        </div>
                    </div>

                    <!-- BOUTON MODIFIER/AJOUTER AVEC CHAMPS CACHES -->
                    <?php  if ( isset($idAlbum) && !empty($idAlbum) ) { /* BOUTON POUR MODIFIER */ ?>
                        <input type="hidden"
                               name="idAlbum"
                               value="<?php echo $idAlbum ?>"
                        />
                        <input type="hidden"
                               name="action"
                               value="modifierAlbum"
                        />
                        <input class="inputButton1"
                               type="submit"
                               value="modifier"
                        />
                    <?php } else { /* BOUTON POUR AJOUTER */ ?>
                        <input type="hidden"
                               name="action"
                               value="ajouterAlbum"
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