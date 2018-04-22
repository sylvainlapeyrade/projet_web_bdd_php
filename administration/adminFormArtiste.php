<?php
  /*
   * FICHIER AdminFormArtite.php
   * Formulaire d'un artiste
   * Date modification : 22/04/2018
   */
  session_start();
  include_once(dirname(__FILE__).'/../functions/variables.php');
  include_once(dirname(__FILE__).'/../functions/base.php');
  include_once(dirname(__FILE__).'/../functions/artiste.php');
  include_once(dirname(__FILE__).'/../database/connexion.php');

  $info['head']['subTitle'] = "Gestion artiste";
  $info['head']['stylesheets'] = ['adminGestion.css'];

  if(!is_connect() || !is_admin()) {leave();}

  /* Récupération des variables importantes selon deux cas :
   * 1: cas modifier
   * 2: cas ajouter
   */

  if ( isset($_GET['idArtiste']) ) {
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

  if ( isset($_GET['nomArtiste']) )
    $nomArtiste = $_GET['nomArtiste'];
  if ( isset($_GET['prenomArtiste']) )
    $prenomArtiste = $_GET['prenomArtiste'];
  if ( isset($_GET['nomScene']) )
    $nomScene = $_GET['nomScene'];
  if ( isset($_GET['dateNaissanceArtiste']) )
    $dateNaissanceArtiste = $_GET['dateNaissanceArtiste'];
  if ( isset($_GET['urlImageArtiste']) )
    $urlImageArtiste = $_GET['urlImageArtiste'];
  if ( isset($_GET['descriptionArtiste']) )
    $descriptionArtiste = $_GET['descriptionArtiste'];

  /* Fichier de fonction exécuter suivant deux cas :
   * 1: ajouter un artiste avec action = ajouterArtiste
   * 2: modifier un artiste avec action = modifierArtiste
   */
  include_once(dirname(__FILE__).'/adminActionArtiste.php');

  include_once(dirname(__FILE__).'/../head.php');
?>

<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
  <section>
    <?php include_once(dirname(__FILE__).'/adminHeader.php'); ?>
    <div>
      <?php include_once(dirname(__FILE__).'/adminHeaderArtiste.php'); ?>
      <div class="text-center">
        <h1>Formulaire Artiste</h1>
        
        <!-- FORMULAIRE D'UN ARTISTE -->
        <form class="flex flex-center flex-column " action="./adminFormArtiste.php" method="get">
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
          
          <label for="dateNaissanceArtiste" class="text-center">
            Date de naissance artiste :
            <input id="dateNaissanceArtiste" type="date" class="input-date" name="dateNaissanceArtiste" value="<?php echo $dateNaissanceArtiste ?>">
          </label>
        
          <input type="text" 
                 class="input-text" 
                 name="urlImageArtiste" 
                 value="<?php echo $urlImageArtiste ?>" 
                 placeholder="URL de l'image de l'artiste"
                 />
          <!-- DESRIPTION DE L'ARTISTE -->
          <textarea class="input-area" 
                    name="descriptionArtiste" 
                    rows="5" 
                    placeholder="Description de l'artiste">
            <?php echo $descriptionArtiste ?>
          </textarea>
          
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
        <!-- FIN FORMULAIRE d'UN ARTISTE -->
        
      </div>
    </div>
  </section>
</main>
