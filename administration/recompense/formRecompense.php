<?php
/**
 * Page formRecompense.php
 * Permet d'ajouter une recompense à la BBD
 */

session_start();
include_once(dirname(__FILE__).'/../../fonctions/variables.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionArtiste.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionRecompense.php');
include_once(dirname(__FILE__).'/../../bdd/connexion.php');

$info['head']['subTitle'] = "Gestion récompense";
$info['head']['stylesheets'] = ['adminGestion.css'];

if(!is_connect() || !is_admin()) {leave();}

$idRecompense = $_GET['idRecompense'];
if ( isset($db, $idRecompense) ) {
    $recompense = recupere_recompense($db, $idRecompense)[0];
    if ( empty($recompense) ) {
        header('Location: ./gestionRecompense.php');
    }
    $nomRecompense = $recompense['nomrecompense'];
    $dateRecompense = $recompense['daterecompense'];
    $descriptionRecompense = $recompense['descriptionrecompense'];
    $optenirRecompense = recuperer_obtenir_recompense($db, $idRecompense);
    foreach($optenirRecompense as $idArtisteOa) {
        $listeArtisteRecompense[] = $idArtisteOa['idartisteoa'];
    }
}

include_once(dirname(__FILE__).'/actionRecompense.php');

if (isset($db)){
    $artistes = recuperer_artiste_tous($db);
}

include_once(dirname(__FILE__).'/../../head.php');
?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
    <section>
        <?php include_once(dirname(__FILE__) . '/../headerAdmin.php'); ?>
        <div>
            <?php include_once(dirname(__FILE__).'/headerRecompense.php'); ?>
            <div class="text-center">
                <h1>Formulaire Récompense</h1>

                <!-- FORMULAIRE :
                     nomRecompense : text
                     dateRecompenese : date
                     descriptionRecompense : textearea
                     listeIdArtiste : multiple checkbox
                -->
                <form class="flex flex-center flex-column" action="./formRecompense.php" method="get">
                    <div class="flex">
                        <div class="width-500 margin-center flex flex-column">
                            <input type="text"
                                   class="input-text"
                                   name="nomRecompense"
                                   placeholder="Nom récompense"
                                   value="<?php if(isset($nomRecompense)){echo $nomRecompense;} ?>"
                                   required
                            />

                            <label for="dateRecompense" class="text-center">
                                Date de la récompense :
                                <input type="date"
                                       placeholder="<?php echo format_date(format_date(date("Y/m/d"))); ?>"
                                       pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"
                                       class="input-date"
                                       name="dateRecompense"
                                       value="<?php if(isset($dateRecompense)){echo format_date($dateRecompense);} ?>"
                                       required
                                />
                            </label>

                            <textarea class="input-area"
                                      name="descriptionRecompense"
                                      rows="5"
                                      placeholder="Description de la récompense"><?php if(isset($descriptionRecompense)){echo $descriptionRecompense;} ?></textarea>
                        </div>

                        <div class="width-800">
                            <!-- Liste de tous les artistes -->
                            <h4>Artistes :</h4>
                            <div id="box-item-checkbox" class="liste-checkbox flex flex-center flex-wrap">
                                <?php foreach($artistes as $artiste) { ?>
                                    <div class="item-checkbox">
                                        <input type="checkbox"
                                               title="idArtiste<?php echo $artiste['idartiste']; ?>"
                                               name="idArtiste<?php echo $artiste['idartiste']; ?>"
                                               value="<?php echo $artiste['idartiste'] ?>"
                                               <?php if ( isset($listeArtisteRecompense) && in_array($artiste['idartiste'], $listeArtisteRecompense) ) { echo "checked"; } ?>
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
                        </div>
                    </div>

                    <!-- BOUTON MODIFIER/AJOUTER AVEC CHAMPS CACHES -->
                    <?php  if ( isset($idRecompense) && !empty($idRecompense) ) { /* BOUTON POUR MODIFIER */ ?>
                        <input type="hidden"
                               name="idRecompense"
                               value="<?php echo $idRecompense ?>"
                        />
                        <input type="hidden"
                               name="action"
                               value="modifierRecompense"
                        />
                        <input class="inputButton1"
                               type="submit"
                               value="modifier"
                        />
                    <?php } else { /* BOUTON POUR AJOUTER */ ?>
                        <input type="hidden"
                               name="action"
                               value="ajouterRecompense"
                        />
                        <input class="inputButton1"
                               type="submit"
                               value="ajouter"
                        />
                    <?php } ?>

                    <!-- FIN FORMULAIRE -->
                </form>
                
            </div>
        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/../../footer.php'); ?>