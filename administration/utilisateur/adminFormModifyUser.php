<?php
  session_start();
  include_once(dirname(__FILE__).'/../../functions/variables.php');
  include_once(dirname(__FILE__).'/../../functions/base.php');
  include_once(dirname(__FILE__).'/../../functions/compte.php');
  include_once(dirname(__FILE__).'/../../database/connexion.php');

  $info['head']['subTitle'] = "Gestion utilisateur";
  $info['head']['stylesheets'] = ['adminGestion.css'];

  if(!is_connect() || !is_admin()) {leave();}

  $action = $_GET['action'];
  $idUtilisateur = $_GET['idUtilisateur'];
  $motDePasse = $_GET['motDePasse'];
  $verification = $_GET['verification'];
  $statut = $_GET['statut'];

  /* Fichier de fonction exécuter suivant le cas suivant :
   * modifier le mot de passe d'un utilisateur avec action = modifierMotDePasseUtilisateur
   */
  include_once(dirname(__FILE__).'/adminActionUser.php');

  $utilisateur = recuperer_utilisateur($db, $idUtilisateur);

  include_once(dirname(__FILE__).'/../../head.php');
?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
  <section>
    <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
    <div>
      <?php include_once(dirname(__FILE__).'/adminHeaderUser.php'); ?>
      <div class="text-center">
        
        <h1>Modification mot de passe</h1>
        <form class="flex flex-center flex-column " action="./adminFormModifyUser.php" method="get">
          <input class="input-text" type="text" value="<?php echo $utilisateur['idutilisateur'] ?>" disabled>
          <input class="input-text" type="hidden" name="idUtilisateur" value="<?php echo $utilisateur['idutilisateur'] ?>">
          <input class="input-text" type="password" name="motDePasse" placeholder="Mot de passe" required>
          <input class="input-text" type="password" name="verification" placeholder="Vérification" required>
          <input type="hidden" name="action" value="modifierMotDePasseUtilisateur">
          <input class="inputButton1" type="submit" value="Modifier mot de passe">
        </form>
        
      </div>
    </div>
  </section>
</main>
