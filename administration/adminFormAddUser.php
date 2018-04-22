<?php
  session_start();
  include_once(dirname(__FILE__).'/../functions/variables.php');
  include_once(dirname(__FILE__).'/../functions/base.php');
  include_once(dirname(__FILE__).'/../functions/compte.php');
  include_once(dirname(__FILE__).'/../database/connexion.php');

  $info['head']['subTitle'] = "Gestion utilisateur";
  $info['head']['stylesheets'] = ['adminGestion.css'];

  if(!is_connect() || !is_admin()) {leave();}

  /* Gestion du formulaire */
  if ( isset($_GET['action']) && $_GET['action'] == 'Ajouter' ) {
    $identify = $_GET['idUtilisateur'];
    $password = $_GET['motDePasse'];
    $verification = $_GET['verification'];
    $estAdmin = $_GET['estAdmin'];
    if ( $password == $verification ) {
      if ( $estAdmin == 'estAdmin' ) {
        $isAdmin = true;
      } else {
        $isAdmin = false;
      }
      if ( isset() ) {
        $userExist = getUser($db, $identify) != null;
        if ( !$userExiste ) {
          $actionOk =  add_user($db, $identify, $password, $isAdmin);
          if ( $actionOk ) {
            header('Location: ./adminGestionUser.php?action=effectuer');
          } else {
            $error = 'L\'utilisateur n\'a pas pu être enregistré.';
          }
        } else {
        $error = 'Un utilisateur portant ce nom existe déjà';
        }
      } else {
      $error = 'Le formulaire n\'est pas valide.';
      }
    } else {
    $error = 'Les deux mots de passe sont différents.';
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
      <div class="text-center">
        <h1>Formulaire Utilisateur</h1>
        <form class="flex flex-center flex-column " action="./adminFormAddUser.php" method="get">
          <input class="input-text" type="text" name="idUtilisateur" placeholder="Nom d'utilisateur">
          <input class="input-text" type="password" name="motDePasse" placeholder="Mot de passe">
          <input class="input-text" type="password" name="verification" placeholder="Vérification">
          <label for="admin" class="text-center">
            <input id="admin" type="checkbox" name="estAdmin" value="estAdmin">
            Adminstrateur
          </label>
          <input class="inputButton1" type="submit" name="action" value="Ajouter">
        </form>
      </div>
    </div>
  </section>
</main>
