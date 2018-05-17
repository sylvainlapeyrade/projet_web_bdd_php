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
    <section id="page-accueil">
        <h1 class="white t35 text-center">Critiquez vos albums et musiques préférées</h1>
        
        <form class="flex flex-center" action="/recherche.php" method="get">
            <input id="input-recherche"
                   type="text"
                   class="width-500"
                   name="recherche"
                   placeholder="Artiste, groupe, album ou musique"
                   />
            <input class="bouton bouton-forme1 bouton-red1" type="submit" value="Rechercher" />
        </form>
        
    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
