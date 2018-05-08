<?php
  session_start();
  include_once(dirname(__FILE__).'/../../fonctions/variables.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionArtiste.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionAlbum.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionGenre.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionMusique.php');
  include_once(dirname(__FILE__).'/../../bdd/connexion.php');

  $info['head']['subTitle'] = "Gestion musique";
  $info['head']['stylesheets'] = ['adminGestion.css'];

  if(!is_connect() || !is_admin()) {leave();}

  /* Récupération des variables importantes pour le cas suivant :
   * cas supprimer
   */
  $idMusique = $_GET['idMusique'];

  /* Fichier de fonction exécuter suivant le cas suivant :
   * supprimer un artiste avec action = supprimerArtiste
   */
  include_once(dirname(__FILE__).'/actionMusique.php');

  if (isset($db)){
    $listeMusique = recuperer_musique_tous($db);
  }

  include_once(dirname(__FILE__).'/../../head.php');
?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
  <section>
    <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
    <div>
      <?php include_once(dirname(__FILE__).'/headerMusique.php'); ?>
      <div>
        
        <!-- TABLEAU DES MUSIQUES -->
        <table id="tableauGestion">
          <tr class="table-head">
            <th class="width-350">Tite musique</th>
            <th class="width-200">Durée</th>
            <th class="width-200">Date</th>
            <th class="width-600">Description</th>
          </tr>
        
          <?php foreach($listeMusique as $musique) { /* INFORMATION POUR CHAQUE MUSIQUE AVEC ACTION */ ?>
          <tr class="table-lign">
            <td>
              <?php echo $musique['titremusique']; ?>
            </td>
            <td>
              <?php echo $musique['dureemusique']; ?>
            </td>
            <td>
              <?php echo format_date($musique['datemusique']); ?>
            </td>
            <td>
              <?php echo $musique['descriptionmusique']; ?>
            </td>
            <td class="button button-blue">
              <a href="./formMusique.php?idMusique=<?php echo $musique['idmusique'] ?>">Modifier</a>
            </td>
            <td class="button button-red">
              <a href="./gestionMusique.php?action=supprimerMusique&idMusique=<?php echo $musique['idmusique'] ?>">Supprimer</a>
            </td>
          </tr>
          <?php } ?>
          
        </table>
        <!-- FIN TABLEAU DES MUSIQUES -->
        
      </div>
    </div>
  </section>
</main>
