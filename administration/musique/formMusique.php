<?php
  session_start();
  include_once(dirname(__FILE__).'/../../fonctions/variables.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionArtiste.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionAlbum.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionMusique.php');
  include_once(dirname(__FILE__).'/../../bdd/connexion.php');

  $info['head']['subTitle'] = "Gestion musique";
  $info['head']['stylesheets'] = ['adminGestion.css'];

  if(!is_connect() || !is_admin()) {leave();}

  $idMusique = $_GET['idMusique'];
  if ( isset($db, $idMusique) && !empty($idMusique) ) {
    $musique = recuperer_musique($db, $idMusique);
    if ( $musique != null ) {
      $titreMusique = $musique['titremusique'];
      $dureeMusique = $musique['dureemusique'];
      $dateMusique = $musique['datemusique'];
      $descriptionMusique = $musique['descriptionmusique'];
    }
  }

  include_once(dirname(__FILE__).'/actionMusique.php');

  if (isset($db)){
      $artistes = recuperer_artiste_tous($db);
  }

  include_once(dirname(__FILE__).'/../../head.php');
?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
  <section>
    <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
    <div>
      <?php include_once(dirname(__FILE__).'/headerMusique.php'); ?>
      <div class="text-center">
        <h1>Formulaire Musique</h1>
        
        <!-- FORMULAIRE D'UN ALBUM -->
        <form class="flex flex-center flex-column" action="./formMusique.php" method="get">
          <div class="flex">
            <div class="flex flex-column width-800">
              <input type="text" 
                     class="input-text"
                     name="titreMusique"
                     placeholder="Titre musique"
                     value="<?php echo $titreMusique; ?>"
                     />
              
              <label for="dureeMusique" class="text-center">
                Durée (en secondes) :
                <input type="number"
                       class="input-number"
                       name="dureeMusique"
                       value="<?php echo $dureeMusique; ?>"
                       />
              </label>

              <label for="dateMusique" class="text-center">
                Date de création :
                <input type="date"
                       class="input-date"
                       name="dateMusique"
                       value="<?php echo $dateMusique; ?>"
                       />
              </label>

              <!-- DESRIPTION DE L'ALBUM -->
              <textarea class="input-area" 
                        name="descriptionMusique" 
                        rows="5"
                        placeholder="Description de la musique"><?php echo $descriptionMusique; ?></textarea>
            </div>
            
            <div>
              <!-- ICI POUR LES ARTISTES ET OU LES ALBUMS -->
              <div>
              </div>
              <div>
              </div>
            </div>
            
          </div>
        
          <!-- BOUTON AJOUTER/MODIFIER AVEC CHAMPS CACHES -->
          <?php  if ( isset($idMusique) && !empty($idMusique) ) { /** BOUTON POUR MODIFIER */ ?>
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
        <!-- FIN FORMULAIRE d'UN ALBUM -->
        
      </div>
    </div>
  </section>
</main>
