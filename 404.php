<?php

session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionArtiste.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Page 404";
$info['head']['stylesheets'] = ['barreRecherche.css', 'page404.css'];

include_once(dirname(__FILE__).'/head.php');

?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>

<main>
    <section>
        
        <?php include_once(dirname(__FILE__).'/barreRecherche.php'); ?>
        
        <div id="page-404" class="text-center">
            <h1 class="t35 red1">Page <span class="white">404</span> !</h1>
            <p>La page demandée est introuvable.</p>
            <p>Effectuer une autre recherche.</p>
        </div>
        
    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
