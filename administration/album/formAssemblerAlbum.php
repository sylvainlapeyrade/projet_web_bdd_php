<?php

session_start();
include_once(dirname(__FILE__).'/../../fonctions/variables.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionArtiste.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionAlbum.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionGenre.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionMusique.php');
include_once(dirname(__FILE__).'/../../bdd/connexion.php');

$info['head']['subTitle'] = "Gestion album";
$info['head']['stylesheets'] = ['adminGestion.css'];

if(!is_connect() || !is_admin()) {leave();}

$idAlbum = $_GET['idAlbum'];
$idMusique = $_GET['idMusique'];

if ( !isset($idAlbum) || empty($idAlbum) ) {
    header('Location: ./gestionAlbum.php');
}

include_once(dirname(__FILE__).'/actionAssemblerAlbum.php');

if ( isset($db) ) {
    $album = recuperer_album($db, $idAlbum);
    if ( $album != null ) {
        $listeMusiqueArtiste = recuperer_musique_artiste($db, $album['idalbum']);
    }
}

include_once(dirname(__FILE__).'/../../head.php');

?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
    <section>
        <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
        <div>
            <?php include_once(dirname(__FILE__).'/headerAssemblerAlbum.php'); ?>
            <div class="text-center">
                <h1>Formulaire Assembler Album</h1>

                <!-- FORMULAIRE :
                    numeroPiste : number
                    listeIdMusique : multiple checkbox
                -->
                <form class="flex flex-center flex-column" action="./formMusique.php" method="get">
                    
                    <div class="flex flex-column">
                        <div class="margin-center">
                            <h4>Morceau de musique :</h4>
                            <div id="box-item-checkbox" class="width-500 liste-checkbox flex flex-center flex-wrap">
                                <?php foreach($listeMusiqueArtiste as $musique) { ?>
                                <div class="item-checkbox">
                                    <input type="checkbox"
                                           name="idMusique<?php echo $musique['idmusique']; ?>"
                                           value="<?php echo $musique['idMusique'] ?>"
                                           />
                                    <?php echo $musique['titremusique']; ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>

                        <label for="dureeMusique" class="text-center"> Numéro de piste :
                            <input type="number"
                                   class="input-number"
                                   name="numeroPiste"
                                   value="<?php echo $numeroPiste; ?>"
                                   placeholder="1"
                                   required
                                   />
                        </label>
                    </div>

                    <!-- BOUTON AJOUTER/MODIFIER AVEC CHAMPS CACHES -->
                    <?php  if ( isset($idMusique) && !empty($idMusique) ) { /** BOUTON POUR MODIFIER */ ?>
                    <input type="hidden" 
                           name="idAlbum" 
                           value="<?php echo $idAlbum ?>"
                           />
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