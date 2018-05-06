<?php
  session_start();
  include_once(dirname(__FILE__).'/../../fonctions/variables.php');
  include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
  include_once(dirname(__FILE__).'/../../bdd/connexion.php');

  $info['head']['subTitle'] = "Gestion utilisateur";
  $info['head']['stylesheets'] = ['adminGestion.css'];

  if(!is_connect() || !is_admin()) {leave();}

  $action = $_GET['action'];
  $idUtilisateur = $_GET['idUtilisateur'];
  $motDePasse = $_GET['motDePasse'];
  $verification = $_GET['verification'];
  $statut = $_GET['statut'];

  /* Fichier de fonction exécuter suivant le cas suivant :
   * modifier le statut d'un utilisateur avec action = modifierStatutUtilisateur
   * supprimer un utilisateur avec action = supprimerUtilisateur
   */
  include_once(dirname(__FILE__).'/actionUser.php');

  /* Récupére dans un tableau toute la liste des utilsateur de la base de donnée. */
  $listUser = recuperer_utilisateur_tous($db);

  include_once(dirname(__FILE__).'/../../head.php');
?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
  <section>
    <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
    <section class="text-center">
      <?php include_once(dirname(__FILE__).'/headerUser.php'); ?>
      <div>
        <table id="tableauGestion">
          <tr class="table-head">
            <th class="width-350">Nom d'utilisateur</th>
            <th class="width-350">Status utilisateur</th>
          </tr>

          <?php foreach($listUser as $user) { ?>
          <tr class="table-lign">
            <td><?php echo $user['idutilisateur']; ?></td>
            <?php if ( $user['statut'] ) { ?>
            <td>Admin</td>
            <td class="button button-blue">
              <a href="?action=modifierStatutUtilisateur&idUtilisateur=<?php echo $user['idutilisateur'] ?>&statut=0">Devenir User</a>
            </td>
            <?php } else { ?>
            <td>User</td>
            <td class="button button-green">
              <a href="?action=modifierStatutUtilisateur&idUtilisateur=<?php echo $user['idutilisateur'] ?>&statut=1">Devenir Admin</a>
            </td>
            <?php } ?>
            <td class="button button-blue">
              <a href="./formModifyUser.php?idUtilisateur=<?php echo $user['idutilisateur'] ?>">Modifier mot de passe</a>
            </td>
            <td class="button button-red">
              <a href="?action=supprimerUtilisateur&idUtilisateur=<?php echo $user['idutilisateur'] ?>">Supprimer</a>
            </td>
          </tr>
          <?php } ?>

        </table>
      </div>
    </section>
  </section>
</main>
