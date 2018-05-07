<?php
  session_start();
  include_once(dirname(__FILE__).'/../fonctions/variables.php');
  include_once(dirname(__FILE__).'/../fonctions/fonctionCompte.php');
  include_once(dirname(__FILE__).'/../bdd/connexion.php');

  $info['head']['subTitle'] = "Connexion";
  $info['head']['stylesheets'] = ['connexion.css'];

  if(is_connect()) {leave();}

  /* Gestion du formulaire connexion */
  if ( isset($_GET['connexion']) && $_GET['connexion'] == 'connexion' ) {
    $identify = $_GET['idUtilisateur'];
    $password = $_GET['motDePasse'];
    if ( isset($identify) && isset($password) ) {
      if ( !empty($identify) && !empty($password) ) {
        $actionOk = connexion_account($db, $identify, $password);
        if ( $actionOk ) {
          header('Location: /index.php');
        } else {
          $erreur = "Votre identifiant ou votre mot de passe est incorrect.";
        }
      } else {
        $erreur = "Les champs du formualaire ne doivent pas être vide.";
      }
    } else {
      $erreur = "Le formulaire n'est pas valide.";
    }
  }

?>

<?php include_once(dirname(__FILE__).'/../head.php'); ?>
<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
  <section class="text-center">
    <h1 class="t30">Connexion</h1>
    <? if ( isset($erreur) ) { ?>
    <!-- Message d'erreur du formulaire -->
    <p class="red"><?php echo $erreur; ?></p>
    <? } ?>
    <? if ( isset($_GET['action']) && $_GET['action'] == 'inscription' ) { ?>
    <!-- Message si l'utilisateur viens de s'inscrire -->
    <p class="green">Votre compte a été crée.<br>Connectez-vous à votre compte !</p>
    <? } ?>
    <form class="flex flex-center flex-column" method="get">
      <input class="input-text" type="text" name="idUtilisateur" placeholder="Identifiant"
             value="<?php if( isset($identify) ){ echo $identify; } ?>">
      <input class="input-text" type="password" name="motDePasse" placeholder="Mot de passe">
      <input class="inputButton1" type="submit" name="connexion" value="connexion">
    </form>
  </section>
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
