<?php
    session_start();
    include_once(dirname(__FILE__).'/../functions/variables.php');
    include_once(dirname(__FILE__).'/../functions/base.php');


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
    <section class="flex flex-center">
      <a class="button button-blue" href="./adminGestionUser.php">
        Gestion des utilisateur
      </a>
      <a class="button button-blue" href="./adminGestionArtiste.php">
        Gestion des artistes
      </a>
    </section>
  </section>
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
