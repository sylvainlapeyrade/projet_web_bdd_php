<?php
    session_start();
    include_once(dirname(__FILE__) . '/../fonctions/variables.php');
    include_once(dirname(__FILE__) . '/../fonctions/fonction_compte.php');


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
    <section>
        <a class="button button-blue" href="./utilisateur/gestionUser.php">
          Gestion des utilisateur
        </a><br><br>
        <a class="button button-blue" href="./artiste/gestionArtiste.php">
          Gestion des artistes
        </a><br><br>
        <a class="button button-blue" href="./recompense/gestionRecompense.php">
          Gestion des récompense
        </a>
    </section>
  </section>
</main>
