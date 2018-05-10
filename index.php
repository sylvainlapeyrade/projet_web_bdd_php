<?php
    session_start();
    include_once(dirname(__FILE__).'/fonctions/variables.php');
    include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
    include_once(dirname(__FILE__).'/bdd/connexion.php');

    $info['head']['subTitle'] = "Page d'accueil";
    $info['head']['stylesheets'] = ['accueil.css'];

    include_once(dirname(__FILE__).'/head.php');
?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>

    <main>
      <section id="content-recherche">
          <h1 class="white t35 text-center">Critiquez vos albums et musiques préférées</h1>
          <?php include_once(dirname(__FILE__).'/formRecherche.php'); ?>
      </section>
    </main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
