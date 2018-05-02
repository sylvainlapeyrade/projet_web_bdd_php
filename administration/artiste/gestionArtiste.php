<?php
  session_start();
  include_once(dirname(__FILE__).'/../../functions/variables.php');
  include_once(dirname(__FILE__).'/../../functions/base.php');
  include_once(dirname(__FILE__).'/../../functions/artiste.php');
  include_once(dirname(__FILE__).'/../../database/connexion.php');

  $info['head']['subTitle'] = "Gestion artiste";
  $info['head']['stylesheets'] = ['adminGestion.css'];

  if(!is_connect() || !is_admin()) {leave();}

  /* Récupération des variables importantes pour le cas suivant :
   * cas supprimer
   */
  $idArtiste = $_GET['idArtiste'];

  /* Fichier de fonction exécuter suivant le cas suivant :
   * supprimer un artiste avec action = supprimerArtiste
   */
  include_once(dirname(__FILE__).'/actionArtiste.php');

  /* On récupère tout les artiste de la base de données. */
  $listArtiste = recuperer_artiste_tous($db);

  include_once(dirname(__FILE__).'/../../head.php');
?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
  <section>
    <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
    <div>
      <?php include_once(dirname(__FILE__).'/headerArtiste.php'); ?>
      <div>
        
        <!-- TABLEAU DES ARTISTES -->
        <table id="tableauGestion">
          <tr class="table-head">
            <th class="width-350">Nom de l'artiste</th>
            <th class="width-350">Prénom</th>
            <th class="width-350">Nom de scène</th>
            <th class="width-100"></th>
            <th class="width-100"></th>
          </tr>
        
          <?php foreach($listArtiste as $artiste) { /* INFORMATION POUR CHAQUE ARTISTES AVEC ACTION */ ?>
          <tr class="table-lign">
            <td>
              <?php echo $artiste['nomartiste']; ?>
            </td>
            <td>
              <?php echo $artiste['prenomartiste']; ?>
            </td>
            <td>
              <?php echo $artiste['nomscene']; ?>
            </td>
            <td class="button button-blue">
              <a href="./adminFormArtiste.php?idArtiste=<?php echo $artiste['idartiste'] ?>">Modifier</a>
            </td>
            <td class="button button-red">
              <a href="./adminGestionArtiste.php?action=supprimerArtiste&idArtiste=<?php echo $artiste['idartiste'] ?>">Supprimer</a>
            </td>
          </tr>
          <?php } ?>
          
        </table>
        <!-- FIN TABLEAU DES ARTISTES -->
        
      </div>
    </div>
  </section>
</main>
