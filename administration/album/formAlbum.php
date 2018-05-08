<?php
session_start();
include_once(dirname(__FILE__).'/../../fonctions/variables.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionArtiste.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionAlbum.php');
include_once(dirname(__FILE__).'/../../bdd/connexion.php');

$info['head']['subTitle'] = "Gestion groupe";
$info['head']['stylesheets'] = ['adminGestion.css'];

if(!is_connect() || !is_admin()) {leave();}

$idAlbum = $_GET['idAlbum'];
if ( isset($db, $idAlbum) && !empty($idAlbum) ) {
    $album = recuperer_album($db, $idAlbum);
    if ( $album != null ) {
        $nomAlbum = $album['nomalbum'];
        $dateAlbum = $album['datealbum'];
        $descriptionAlbum = $album['descriptionalbum'];
        $urlPochetteAlbum = $album['urlpochettealbum'];
        $constituerAlbum = recuperer_composer_album($db, $idAlbum);
        foreach($constituerAlbum as $idArtisteCoAl) {
            $listeArtisteAlbum[] = $idArtisteCoAl['idartistecoal'];
        }
    }
}

if ( isset($db) ) {
    /* Fichier de fonction exécuter suivant deux cas :
     * 1: ajouter un album avec action = ajouterAlbum
     * 2: modifier un album avec action = modifierAlbum
     */
    include_once(dirname(__FILE__).'/actionAlbum.php');
    
    $artistes = recuperer_artiste_tous($db);
}

include_once(dirname(__FILE__).'/../../head.php');

include_once(dirname(__FILE__).'/../../header.php');
?>

<main>
    <section>
        <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
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
                                   placeholder="Nom album"
                                   value="<?php echo $nomAlbum; ?>"
                            />

                            <label for="dateRecompense" class="text-center">
                                Date de création:
                                <input type="date"
                                       placeholder="<?php echo format_date(date("d-m-Y")); ?>"
                                       required pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}"
                                       class="input-date"
                                       name="dateAlbum"
                                       value="<?php echo format_date($dateAlbum); ?>"
                                />
                            </label>

                            <input type="text"
                                   class="input-text"
                                   name="urlPochetteAlbum"
                                   placeholder="Url album"
                                   value="<?php echo $urlPochetteAlbum; ?>"
                            />
                            <br><br>

                            <textarea class="input-area"
                                      name="descriptionAlbum"
                                      rows="5"
                                      placeholder="Description de l'album"><?php echo $descriptionAlbum; ?></textarea>
                        </div>

                        <div id="box-item-checkbox" class="width-800 liste-checkbox flex flex-center flex-wrap">
                            <?php
                            foreach($artistes as $artiste) {
                                ?>
                                <div class="item-checkbox">
                                    <input type="checkbox"
                                           title="idArtiste<?php echo $artiste['idartiste']; ?>"
                                           name="idArtiste<?php echo $artiste['idartiste']; ?>"
                                           value="<?php echo $artiste['idartiste'] ?>"
                                        <?php if ( isset($listeArtisteAlbum) && in_array($artiste['idartiste'], $listeArtisteAlbum) ) { echo "checked"; } ?>
                                    /><?php echo $artiste['nomartiste'].' '.$artiste['prenomartiste']; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- BOUTON AJOUTER/MODIFIER AVEC CHAMPS CACHES -->
                    <?php  if ( isset($idAlbum) && !empty($idAlbum) ) { /** BOUTON POUR MODIFIER */ ?>
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
                    <?php } else { /********************************* BOUTON POUR AJOUTER */ ?>
                        <input type="hidden"
                               name="action"
                               value="ajouterAlbum"
                        />
                        <input class="inputButton1"
                               type="submit"
                               value="ajouter"
                        />
                    <?php } ?>
                    <!-- FIN FORMULAIRE -->

            </div>
        </div>
    </section>
</main>
