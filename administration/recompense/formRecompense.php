<?php
  session_start();
  include_once(dirname(__FILE__) . '/../../fonctions/variables.php');
  include_once(dirname(__FILE__) . '/../../fonctions/fonction_compte.php');
  include_once(dirname(__FILE__) . '/../../fonctions/fonction_artiste.php');
  include_once(dirname(__FILE__) . '/../../fonctions/fonction_recompense.php');
  include_once(dirname(__FILE__) . '/../../bdd/connexion.php');

  $info['head']['subTitle'] = "Gestion récompense";
  $info['head']['stylesheets'] = ['adminGestion.css'];

  if(!is_connect() || !is_admin()) {leave();}

  $idRecompense = $_GET['idRecompense'];
  if ( isset($idRecompense) && !empty($idRecompense) ) {
    $recompense = recupere_recompense($db, $idRecompense);
    if ( $recompense != null ) {
      $nomRecompense = $recompense['nomrecompense'];
      $dateRecompense = $recompense['daterecompense'];
      $descriptionRecompense = $recompense['descriptionrecompense'];
      $optenirRecompense = recuperer_obtenir_recompense($db, $idRecompense);
      foreach($optenirRecompense as $idArtisteOa) {
        $listeArtisteRecompense[] = $idArtisteOa['idartisteoa'];
      }
    }
  }

  /* Fichier de fonction exécuter suivant deux cas :
   * 1: ajouter une récompense avec action = ajouterRecompense
   * 2: modifier une récompense avec action = modifierRecompense
   */
  include_once(dirname(__FILE__).'/actionRecompense.php');

  $artistes = recuperer_artiste_tous($db);
  
  include_once(dirname(__FILE__).'/../../head.php');
?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
  <section>
    <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
    <div>
      <?php include_once(dirname(__FILE__).'/headerRecompense.php'); ?>
      <div class="text-center">
        <h1>Formulaire Récompense</h1>
        
        <!-- FORMULAIRE D'UN ARTISTE -->
        <form class="flex flex-center flex-column" action="./formRecompense.php" method="get">
          <div class="flex">
            <div class="flex flex-column width-800">
              <input type="text" 
                     class="input-text"
                     name="nomRecompense"
                     placeholder="Nom récompense"
                     value="<?php echo $nomRecompense; ?>"
                     />

              <label for="dateRecompense" class="text-center">
                Date de la récompense :
                <input type="date"
                       class="input-date"
                       name="dateRecompense"
                       value="<?php echo $dateRecompense; ?>"
                       />
              </label>
              <br><br>

              <!-- DESRIPTION DE LA RECOMPENSE -->
              <textarea class="input-area" 
                        name="descriptionRecompense" 
                        rows="5"
                        placeholder="Description de la récompense"><?php echo $descriptionRecompense; ?></textarea>
            </div>

            <div class="width-800 liste-checkbox flex flex-center flex-wrap">
              <?php
              foreach($artistes as $artiste) {
              ?>
              <div class="item-checkbox">
                <input type="checkbox"
                       name="idArtiste<?php echo $artiste['idartiste']; ?>"
                       value="<?php echo $artiste['idartiste'] ?>"
                       <?php if ( isset($listeArtisteRecompense) && in_array($artiste['idartiste'], $listeArtisteRecompense) ) { echo "checked"; } ?>
                       /><?php echo $artiste['nomartiste'].' '.$artiste['prenomartiste']; ?>
              </div>
              <?php } ?>
            </div>
          </div>
        
          <!-- BOUTON AJOUTER/MODIFIER AVEC CHAMPS CACHES -->
          <?php  if ( isset($idRecompense) && !empty($idRecompense) ) { /** BOUTON POUR MODIFIER */ ?>
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
          <?php } else { /********************************* BOUTON POUR AJOUTER */ ?>
            <input type="hidden" 
                   name="action" 
                   value="ajouterRecompense"
                   />
            <input class="inputButton1" 
                   type="submit" 
                   value="ajouter"
                   />
          <?php } ?>
        <!-- FIN FORMULAIRE d'UN ARTISTE -->
        
      </div>
    </div>
  </section>
</main>
