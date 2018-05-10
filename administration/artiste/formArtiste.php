<?php
  session_start();
  include_once(dirname(__FILE__).'/../../fonctions/variables.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionArtiste.php');
  include_once(dirname(__FILE__).'/../../bdd/connexion.php');

  $info['head']['subTitle'] = "Gestion artiste";
  $info['head']['stylesheets'] = ['adminGestion.css'];

  if(!is_connect() || !is_admin()) {leave();}

  /* Récupération des variables importantes selon deux cas :
   * 1: cas modifier
   * 2: cas ajouter
   */
  if ( isset($db) && isset($_GET['idArtiste']) ) {
    $idArtiste = $_GET['idArtiste'];
    $artiste = recupere_artiste($db, $idArtiste);
    if ( $artiste != null ) {
      $nomArtiste = $artiste['nomartiste'];
      $prenomArtiste = $artiste['prenomartiste'];
      $nomScene = $artiste['nomscene'];
      $dateNaissanceArtiste = $artiste['datenaissanceartiste'];
      $urlImageArtiste = $artiste['urlimageartiste'];
      $descriptionArtiste = $artiste['descriptionartiste'];
    }
  }

  /* Fichier de fonction exécuter suivant deux cas :
   * 1: ajouter un artiste avec action = ajouterArtiste
   * 2: modifier un artiste avec action = modifierArtiste
   */
  include_once(dirname(__FILE__).'/actionArtiste.php');

  include_once(dirname(__FILE__).'/../../head.php');
?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
  <section>
    <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
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
                 value="<?php echo $nomArtiste ?>" 
                 placeholder="Nom de l'artiste"
                 />
          
          <input type="text" 
                 class="input-text" 
                 name="prenomArtiste" 
                 value="<?php echo $prenomArtiste ?>" 
                 placeholder="Prénom de l'artiste"
                 />
          
          <input type="text" 
                 class="input-text" 
                 name="nomScene" 
                 value="<?php echo $nomScene ?>" 
                 placeholder="Nom de scène"
                 />

          <label for="dateRecompense" class="text-center">
            Date de naissance :
            <input type="date"
                   placeholder="<?php echo format_date(date("d-m-Y")); ?>"
                   required pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}"
                   class="input-date"
                   name="dateNaissanceArtiste"
                   value="<?php echo format_date($dateNaissanceArtiste); ?>"
             />
          </label>
        
          <input type="text" 
                 class="input-text" 
                 name="urlImageArtiste" 
                 value="<?php echo $urlImageArtiste ?>" 
                 placeholder="URL de l'image de l'artiste"
                 />
          <textarea class="input-area" 
                    name="descriptionArtiste" 
                    rows="5" 
                    placeholder="Description de l'artiste"><?php echo $descriptionArtiste ?></textarea>
          
          <!-- BOUTON AJOUTER/MODIFIER AVEC CHAMPS CACHES -->
          <?php  if ( isset($idArtiste) ) { /************** BOUTON POUR MODIFIER */ ?>
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
          <?php } else { /********************************* BOUTON POUR AJOUTER */ ?>
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