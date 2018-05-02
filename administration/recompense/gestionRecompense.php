<?php
  session_start();
  include_once(dirname(__FILE__).'/../../fonctions/variables.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonction_compte.php');
  include_once(dirname(__FILE__).'/../../bdd/connexion.php');

  $info['head']['subTitle'] = "Gestion recompense";
  $info['head']['stylesheets'] = ['adminGestion.css'];

  if(!is_connect() || !is_admin()) {leave();}

  include_once(dirname(__FILE__).'/../../head.php');
?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
  <section>
    <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
    <section class="text-center">
      <?php include_once(dirname(__FILE__).'/headerRecompense.php'); ?>
      <div>
        <table id="tableauGestion">
          <tr class="table-head">
            <th class="width-350">Nom récompense</th>
            <th class="width-350">Date récompense</th>
            <th class="width-600">Description</th>
          </tr>

          <tr class="table-lign">
            <td></td>
            <td></td>
            <td></td>
            <td class="button button-blue">
              <a href="./adminFormModifyUser.php?idUtilisateur=<?php echo $user['idutilisateur'] ?>">Modifier</a>
            </td>
            <td class="button button-red">
              <a href="?action=supprimerUtilisateur&idUtilisateur=<?php echo $user['idutilisateur'] ?>">Supprimer</a>
            </td>
          </tr>

        </table>
      </div>
    </section>
  </section>
</main>
