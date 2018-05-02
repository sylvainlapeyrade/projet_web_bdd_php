<?php
    session_start();
    include_once(dirname(__FILE__) . '/../fonctions/variables.php');
    include_once(dirname(__FILE__) . '/../fonctions/base.php');


    $info['head']['subTitle'] = "Administration";
    $info['head']['stylesheets'] = ['administration.css'];

    include_once(dirname(__FILE__).'/../head.php');
?>

<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
  <section>
    <h1>
      <a href="./index.php">Panneau d'adminsitration</a>
    </h1>
    <section class="">
        <a class="button button-blue" href="./utilisateur/adminGestionUser.php">
          Gestion des utilisateur
        </a><br><br>
        <a class="button button-blue" href="./artiste/adminGestionArtiste.php">
          Gestion des artistes
        </a>
    </section>
  </section>
</main>
