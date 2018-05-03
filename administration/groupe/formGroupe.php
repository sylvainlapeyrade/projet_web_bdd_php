<?php
  session_start();
  include_once(dirname(__FILE__).'/../../fonctions/variables.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionArtiste.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionGroupe.php');
  include_once(dirname(__FILE__).'/../../bdd/connexion.php');

  $info['head']['subTitle'] = "Gestion groupe";
  $info['head']['stylesheets'] = ['adminGestion.css'];

  if(!is_connect() || !is_admin()) {leave();}

  $idGroupe = $_GET['idGroupe'];
  if ( isset($idGroupe) && !empty($idGroupe) ) {
    $groupe = recuperer_groupe($db, $idGroupe);
    if ( $groupe != null ) {
      $nomGroupe = $groupe['nomgroupe'];
      $dateGroupe = $groupe['dategroupe'];
      $descriptionGroupe = $groupe['descriptiongroupe'];
      $urlImageGroupe = $groupe['urlimagegroupe'];
      $constituerGroupe = recuperer_constituer_groupe($db, $idGroupe);
      foreach($constituerGroupe as $idArtisteCo) {
        $listeArtisteGroupe[] = $idArtisteCo['idartisteco'];
      }
    }
  }

  /* Fichier de fonction exécuter suivant deux cas :
   * 1: ajouter une récompense avec action = ajouterRecompense
   * 2: modifier une récompense avec action = modifierRecompense
   */
  include_once(dirname(__FILE__).'/actionGroupe.php');

  $artistes = recuperer_artiste_tous($db);
  
  include_once(dirname(__FILE__).'/../../head.php');
?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
  <section>
    <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
    <div>
      <?php include_once(dirname(__FILE__).'/headerGroupe.php'); ?>
      <div class="text-center">
        <h1>Formulaire Groupe</h1>
        
        <!-- FORMULAIRE D'UN ARTISTE -->
        <form class="flex flex-center flex-column" action="./formGroupe.php" method="get">
          <div class="flex">
            <div class="flex flex-column width-800">
              <input type="text" 
                     class="input-text"
                     name="nomGroupe"
                     placeholder="Nom groupe"
                     value="<?php echo $nomGroupe; ?>"
                     />

              <label for="dateRecompense" class="text-center">
                Date de la création du groupe :
                <input type="date"
                       class="input-date"
                       name="dateGroupe"
                       value="<?php echo $dateGroupe; ?>"
                       />
              </label>
              
              <input type="text" 
                     class="input-text"
                     name="urlImageGroupe"
                     placeholder="Url image"
                     value="<?php echo $urlImageGroupe; ?>"
                     />
              <br><br>

              <!-- DESRIPTION DE LA RECOMPENSE -->
              <textarea class="input-area" 
                        name="descriptionGroupe" 
                        rows="5"
                        placeholder="Description du groupe"><?php echo $descriptionGroupe; ?></textarea>
            </div>

            <div id="box-item-checkbox" class="width-800 liste-checkbox flex flex-center flex-wrap">
              <?php
              foreach($artistes as $artiste) {
              ?>
              <div class="item-checkbox">
                <input type="checkbox"
                       name="idArtiste<?php echo $artiste['idartiste']; ?>"
                       value="<?php echo $artiste['idartiste'] ?>"
                       <?php if ( isset($listeArtisteGroupe) && in_array($artiste['idartiste'], $listeArtisteGroupe) ) { echo "checked"; } ?>
                       /><?php echo $artiste['nomartiste'].' '.$artiste['prenomartiste']; ?>
              </div>
              <?php } ?>
            </div>
          </div>
        
          <!-- BOUTON AJOUTER/MODIFIER AVEC CHAMPS CACHES -->
          <?php  if ( isset($idGroupe) && !empty($idGroupe) ) { /** BOUTON POUR MODIFIER */ ?>
            <input type="hidden" 
                   name="idGroupe" 
                   value="<?php echo $idGroupe ?>"
                   />
            <input type="hidden"
                   name="action" 
                   value="modifierGroupe"
                   />
            <input class="inputButton1" 
                   type="submit" 
                   value="modifier"
                   />
          <?php } else { /********************************* BOUTON POUR AJOUTER */ ?>
            <input type="hidden" 
                   name="action" 
                   value="ajouterGroupe"
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
