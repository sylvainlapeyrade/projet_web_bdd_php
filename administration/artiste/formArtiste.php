<?php
/**
 * Page formArtiste.php
 * Permet d'ajouter un artiste à la BBD
 */

session_start();
include_once(dirname(__FILE__).'/../../fonctions/variables.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionArtiste.php');
include_once(dirname(__FILE__).'/../../bdd/connexion.php');

$info['head']['subTitle'] = "Gestion artiste";
$info['head']['stylesheets'] = ['adminGestion.css'];

if(!is_connect() || !is_admin()) {leave();}

$idArtiste = $_GET['idArtiste'];
if ( isset($db, $idArtiste) ) {
    $artiste = recuperer_artiste($db, $idArtiste)[0];
    if ( empty($artiste) ) {
        header('Location: ./gestionArtiste.php');
    }
    $nomArtiste = $artiste['nomartiste'];
    $prenomArtiste = $artiste['prenomartiste'];
    $nomScene = $artiste['nomscene'];
    $dateNaissanceArtiste = $artiste['datenaissanceartiste'];
    $urlImageArtiste = $artiste['urlimageartiste'];
    $descriptionArtiste = $artiste['descriptionartiste'];
}

include_once(dirname(__FILE__).'/actionArtiste.php');

include_once(dirname(__FILE__).'/../../head.php');

?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
    <section>
    <?php include_once(dirname(__FILE__) . '/../headerAdmin.php'); ?>
        <div>
            <?php include_once(dirname(__FILE__).'/headerArtiste.php'); ?>
            <div class="text-center">
                <h1>Formulaire Artiste</h1>

                <!-- FORMULAIRE :
                    nomArtiste : text
                    prenomArtiste : text
                    nomScene : text
                    dateNaissanceArtiste : date
                    urlImageArtiste : text
                    descriptionArtiste : textarea
                -->
                <form class="flex flex-center flex-column" action="./formArtiste.php" method="get">
                    
                    <input type="text" 
                           class="input-text" 
                           name="nomArtiste" 
                           value="<?php if(isset($nomArtiste)){echo $nomArtiste;} ?>"
                           placeholder="Nom de l'artiste"
                           required
                           />

                    <input type="text" 
                           class="input-text" 
                           name="prenomArtiste" 
                           value="<?php if(isset($prenomArtiste)){echo $prenomArtiste;} ?>"
                           placeholder="Prénom de l'artiste"
                           required
                           />

                    <input type="text" 
                           class="input-text" 
                           name="nomScene" 
                           value="<?php if(isset($nomScene)){echo $nomScene;} ?>"
                           placeholder="Nom de scène"
                           />

                    <label for="dateArtiste" class="text-center">
                        Date de naissance :
                        <input type="date"
                               placeholder="<?php echo format_date(format_date(date("Y/m/d"))); ?>"
                               pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"
                               class="input-date"
                               name="dateNaissanceArtiste"
                               value="<?php if(isset($dateNaissanceArtiste)){echo format_date($dateNaissanceArtiste);} ?>"
                               required
                               />
                    </label>

                    <input type="text" 
                           class="input-text" 
                           name="urlImageArtiste" 
                           value="<?php if(isset($urlImageArtiste)){echo $urlImageArtiste;} ?>"
                           placeholder="URL de l'image de l'artiste"
                           />
                    <textarea class="input-area" 
                              name="descriptionArtiste" 
                              rows="5" 
                              placeholder="Description de l'artiste"><?php if(isset($descriptionArtiste)){echo $descriptionArtiste;} ?></textarea>

                    <!-- BOUTON MODIFIER/AJOUTER AVEC CHAMPS CACHES -->
                    <?php  if ( isset($idArtiste) ) { /* BOUTON POUR MODIFIER */ ?>
                    <input type="hidden" 
                           name="idArtiste" 
                           value="<?php echo $idArtiste ?>"
                           />
                    <input type="hidden"
                           name="action" 
                           value="modifierArtiste"
                           />
                    <input class="inputButton1" 
                           type="submit" 
                           value="modifier"
                           />
                    <?php } else { /* BOUTON POUR AJOUTER */ ?>
                    <input type="hidden" 
                           name="action" 
                           value="ajouterArtiste"
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