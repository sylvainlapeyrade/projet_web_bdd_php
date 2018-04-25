<?php
    session_start();
    include_once(dirname(__FILE__).'/../functions/variables.php');
    include_once(dirname(__FILE__).'/../functions/base.php');
    include_once(dirname(__FILE__).'/../functions/compte.php');
    include_once(dirname(__FILE__).'/../database/connexion.php');

    $info['head']['subTitle'] = "Gestion utilisateur";
    $info['head']['stylesheets'] = ['adminGestion.css'];

    if(!is_connect() || !is_admin()) {leave();}

    $identify = $_GET['idUtilisateur'];

    if ( isset($_GET['action']) && $_GET['action'] == 'Modifier mot de passe' ) {
        $paramOk = check_param($_GET);
        if ( $paramOk ) {
            $password = $_GET['motDePasse'];
            $verification = $_GET['verification'];
            if ( $password == $verification ) {
                $actionOk = modifier_motdepasse_utilisateur($db, $identify, $password);
                if ( $actionOk ) {
                    header('Location: ./adminGestionUser.php?action=effectuer');
                } else {
                    $error = 'L\'action n\'a pas pu être exécuter';
                }
            } else {
                $error = 'Les deux mot de passe ne correspondent pas.';
            }
        } else {
            $error = 'Le formulaire n\'est pas valide';
        }
    }

    include_once(dirname(__FILE__).'/../head.php');
?>

<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
  <section>
    <?php include_once(dirname(__FILE__).'/adminHeader.php'); ?>
    <div>
      <?php include_once(dirname(__FILE__).'/adminHeaderUser.php'); ?>
      <div>
        <form class="flex flex-center flex-column " action="./adminFormModifyUser.php" method="get">
          <input class="input-text" type="hidden" name="idUtilisateur" value="<?php echo $identify; ?>">
          <input class="input-text" type="password" name="motDePasse" placeholder="Mot de passe">
          <input class="input-text" type="password" name="verification" placeholder="Vérification">
          <input class="inputButton1" type="submit" name="action" value="Modifier mot de passe">
        </form>
      </div>
    </div>
  </section>
</main>
