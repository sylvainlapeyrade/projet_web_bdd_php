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
    if ( empty($album) ) {
        header('Location: ./gestionAssemblerAlbum.php?idAlbum='.$idAlbum);
    }
    if ( isset($idMusique) ) {
        $assemblerAlbum = recuperer_assembler_album($db, $idAlbum, $idMusique)[0];
        if ( empty($assemblerAlbum) ) {
            header('Location: ./formAssemblerAlbum.php?idAlbum='.$idAlbum);
        }
        $numeroPiste = $assemblerAlbum['numeropiste'];
    }
    $listeArtisteAlbum = recuperer_artiste_album($db, $idAlbum);
    foreach($listeArtisteAlbum as $artiste) {
        $listeMusiqueArtiste = recuperer_musique_artiste($db, $artiste['idartiste']);
        foreach($listeMusiqueArtiste as $musiquesArtiste) {
            $musiques[] = $musiqueArtiste;
        }
    }
    $listeGroupeAlbum = recuperer_groupe_album($db, $idAlbum);
    foreach($listeGroupeAlbum as $groupe) {
        $listeMusiqueGroupe = recuperer_musique_groupe($db, $groupe['idgroupe']);
        foreach($listeMusiqueGroupe as $musiquesGroupe) {
            $musiques[] = $musiquesGroupe;
        }
    }
    $listeMusiqueAlbum = recuperer_musique_album($db, $idAlbum);
    foreach($listeMusiqueAlbum as $musiqueAlbum) {
        $musiquesAssemblee[] = $musiqueAlbum['idmusique'];
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
                <form class="flex flex-center flex-column" action="./formAssemblerAlbum.php" method="get">
                    
                    <div class="flex flex-column">
                        <?php if ( !isset($idMusique) ) { ?>
                        <div class="width-800 margin-center">
                            <h4>Morceau de musique :</h4>
                            <div id="box-item-checkbox" class="liste-checkbox flex flex-center flex-wrap">
                                <?php if( !empty($musiques) ) { ?>
                                    <?php foreach($musiques as $musique) { ?>
                                        <?php if ( empty($musiquesAssemblee) || ( !empty($musiquesAssemblee) && !in_array($musique['idmusique'], $musiquesAssemblee) ) ) { ?>
                                            <label class="item-checkbox">
                                                <input type="checkbox"
                                                       name="idMusique<?php echo $musique['idmusique']; ?>"
                                                       value="<?php echo $musique['idmusique'] ?>"
                                                       />
                                                <?php echo $musique['titremusique']; ?>
                                            </label>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <?php }?>

                        <label for="dureeMusique" class="text-center"> Numéro de piste :
                            <input type="number"
                                   class="input-number"
                                   name="numeroPiste"
                                   value="<?php if(isset($numeroPiste)) {echo $numeroPiste;} ?>"
                                   placeholder="1"
                                   required
                                   />
                        </label>
                    </div>
                    
                    <input type="hidden" 
                           name="idAlbum" 
                           value="<?php echo $idAlbum ?>"
                           />

                    <!-- BOUTON AJOUTER/MODIFIER AVEC CHAMPS CACHES -->
                    <?php  if ( isset($idMusique) && !empty($idMusique) ) { /** BOUTON POUR MODIFIER */ ?>
                    <input type="hidden" 
                           name="idMusique" 
                           value="<?php echo $idMusique ?>"
                           />
                    <input type="hidden"
                           name="action" 
                           value="modifierAssemblerAlbum"
                           />
                    <input class="inputButton1" 
                           type="submit" 
                           value="modifier"
                           />
                    <?php } else { /********************************* BOUTON POUR AJOUTER */ ?>
                    <input type="hidden" 
                           name="action" 
                           value="ajouterAssemblerAlbum"
                           />
                    <input class="inputButton1" 
                           type="submit" 
                           value="Ajouter"
                           />
                    <?php } ?>
                    
                </form>
                <!-- FIN FORMULAIRE -->

            </div>
        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/../../footer.php'); ?>