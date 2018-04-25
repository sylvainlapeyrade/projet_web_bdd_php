<?php
    session_start();
    include_once(dirname(__FILE__).'/../functions/variables.php');
    include_once(dirname(__FILE__).'/../functions/base.php');
    include_once(dirname(__FILE__).'/../functions/compte.php');
    include_once(dirname(__FILE__).'/../database/connexion.php');

    $info['head']['subTitle'] = "Gestion utilisateur";
    $info['head']['stylesheets'] = ['adminGestion.css'];

    if(!is_connect() || !is_admin()) {leave();}

    /* Action supprimer */
    if ( isset($_GET['action']) && $_GET['action'] == 'supprimer' ) {
        $paramOk = check_param($_GET);
        if ( $paramOk ) {
            $identifiant = $_GET['idUtilisateur'];
            if ( $identifiant != $_SESSION['idUtilisateur'] ) {
                $actionOk = delete_user($db, $identifiant);
                if ( $actionOk ) {
                    header('Location: ./adminGestionUser.php?action=effectuer');
                } else {
                    $error = 'L\'action ne c\'est pas effectué.';
                }
            } else {
                $error = 'Vous ne pouvez pas supprimer votre compte.';
            }
        } else {
            $error = 'Les paramètres demandés ne sont pas valide.';
        }
    }

    /* Action devenir Administrateur ou Utilisateur */
    if ( isset($_GET['action']) && ($_GET['action'] == 'admin' || $_GET['action'] == 'user') ) {
        $paramOk = check_param($_GET);
        if ( $paramOk ) {
            $identifiant = $_GET['idUtilisateur'];
            if ( $identifiant != $_SESSION['idUtilisateur'] ) {
                if ( $_GET['action'] == 'admin' ) {
                    $statut = true;
                } else {
                    $statut = false;
                }
                $actionOk = modify_statut_user($db, $identifiant, $statut);
                if ( $actionOk ) {
                    header('Location: ./adminGestionUser.php?action=effectuer');
                } else {
                    $error = 'L\'action ne c\'est pas effectué.';
                }
            } else {
                $error = 'Vous ne pouvez pas devenir utilisateur.';
            }
        } else {
            $error = 'Les paramètres demandés ne sont pas valide.';
        }
    }

    $listUser = recuperer_utilisateur_tous($db);

    include_once(dirname(__FILE__).'/../head.php');
?>

<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
  <section>
    <?php include_once(dirname(__FILE__).'/adminHeader.php'); ?>
    <section class="text-center">
      <?php include_once(dirname(__FILE__).'/adminHeaderUser.php'); ?>
      <div>
        <table id="tableauGestion">
          <tr class="table-head">
            <th class="width-350">Nom d'utilisateur</th>
            <th class="width-350">Status utilisateur</th>
            <th class="width-100"></th>
            <th class="width-100"></th>
            <th class="width-100"></th>
          </tr>

          <?php foreach($listUser as $user) { ?>
          <tr class="table-lign">
            <td><?php echo $user['idutilisateur']; ?></td>
            <?php if ( $user['statut'] ) { ?>
            <td>Admin</td>
            <td class="button button-blue">
              <a href="?action=user&idUtilisateur=<?php echo $user['idutilisateur'] ?>">Devenir User</a>
            </td>
            <?php } else { ?>
            <td>User</td>
            <td class="button button-green">
              <a href="?action=admin&idUtilisateur=<?php echo $user['idutilisateur'] ?>">Devenir Admin</a>
            </td>
            <?php } ?>
            <td class="button button-blue">
              <a href="./adminFormModifyUser.php?idUtilisateur=<?php echo $user['idutilisateur'] ?>">Modifier mot de passe</a>
            </td>
            <td class="button button-red">
              <a href="?action=supprimer&idUtilisateur=<?php echo $user['idutilisateur'] ?>">Supprimer</a>
            </td>
          </tr>
          <?php } ?>

        </table>
      </div>
    </section>
  </section>
</main>
