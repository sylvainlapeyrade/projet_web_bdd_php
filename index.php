<?php
    session_start();
    include_once(dirname(__FILE__).'/functions/variables.php');
    include_once(dirname(__FILE__).'/functions/base.php');
    include_once(dirname(__FILE__).'/database/connexion.php');

    $info['head']['subTitle'] = "Page d'accueil";
    $info['head']['stylesheets'] = ['accueil.css'];

    include_once(dirname(__FILE__).'/head.php');
?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>

    <main>
    </main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
