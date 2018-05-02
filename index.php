<?php
    session_start();
    include_once(dirname(__FILE__) . '/fonctions/variables.php');
    include_once(dirname(__FILE__) . '/fonctions/fonction_compte.php');
    include_once(dirname(__FILE__) . '/bdd/connexion.php');

    $info['head']['subTitle'] = "Page d'accueil";
    $info['head']['stylesheets'] = ['accueil.css'];

    include_once(dirname(__FILE__).'/head.php');
?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>

    <main>
      <section>
      </section>
    </main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
