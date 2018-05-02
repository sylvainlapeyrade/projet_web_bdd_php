<?php
  session_start();
  include_once(dirname(__FILE__) . '/../fonctions/variables.php');
  include_once(dirname(__FILE__) . '/../fonctions/base.php');
  include_once(dirname(__FILE__) . '/../bdd/connexion.php');
  include_once(dirname(__FILE__) . '/../fonctions/compte.php');

  $info['head']['subTitle'] = "Inscription";
  $info['head']['stylesheets'] = ['inscription.css'];

  if(is_connect()) {leave();}

  /* Gestion du formulaire d'inscription */
  if ( isset($_GET['inscription']) && $_GET['inscription'] == 'inscription' ) {
    $identify = $_GET['idUtilisateur'];
    $password = $_GET['motDePasse'];
    $verify = $_GET['verification'];
    if ( isset($identify) && isset($password) && isset($verify) ) {
      if ( !empty($identify) && !empty($password) && !empty($verify) ) {
        if ( $password == $verify ) {
          $actionOk = inscription($db, $identify, $password);
          if ( actionOk ) {
            header('Location: /compte/connexion.php?action=inscription');
          } else {
            $erreur = "Ce non d'utilisateur existe déjà";
          }
        } else {
          $erreur = "Les mots de passe ne sont pas identique.";
        }
      } else {
        $erreur = "Les champs ne doivent pas être vide";
      }
    } else {
      $erreur = "Le formulaire n'est pas valide.";
    }
  }
?>

<?php include_once(dirname(__FILE__).'/../head.php'); ?>
<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
  <section>
    <h1 class="t30 text-center">Inscription</h1>
    <? if ( isset($erreur) ) { ?>
    <!-- Message d'erreur du formulaire -->
    <p class="red"><?php echo $erreur; ?></p>
    <? } ?>
    <form class="flex flex-center flex-column" method="get">
      <input class="input-text" type="text" name="idUtilisateur" placeholder="Identifiant">
      <input class="input-text" type="password" name="motDePasse" placeholder="Mot de passe">
      <input class="input-text" type="password" name="verification" placeholder="Vérification">
      <input class="inputButton1" type="submit" name="inscription" value="inscription">
    </form>
  </section>
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
