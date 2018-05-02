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
   * ajouter un utilisateur avec action = ajouterUtilisateur
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
    <div>
      <?php include_once(dirname(__FILE__).'/headerUser.php'); ?>
      <div class="text-center">
        <h1>Formulaire Utilisateur</h1>
        <form class="flex flex-center flex-column " action="./adminFormAddUser.php" method="get">
          <input class="input-text" type="text" name="idUtilisateur" placeholder="Nom d'utilisateur">
          <input class="input-text" type="password" name="motDePasse" placeholder="Mot de passe">
          <input class="input-text" type="password" name="verification" placeholder="Vérification">
          <label for="admin" class="text-center">
            <input id="admin" type="checkbox" name="statut" value="1">
            Adminstrateur
          </label>
          <input type="hidden" name="action" value="ajouterUtilisateur">
          <input class="inputButton1" type="submit" value="Ajouter">
        </form>
      </div>
    </div>
  </section>
</main>
