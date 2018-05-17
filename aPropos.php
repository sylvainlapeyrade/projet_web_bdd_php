<?php

session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "A propos";
$info['head']['stylesheets'] = ['accueil.css'];

include_once(dirname(__FILE__).'/head.php');

?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>

<main>
    <section id="page-apropos">

        <div>
            <h1 class="red1 t35 text-center">Le projet Web</h1>
            <h2 class="white  t20 flex flex-center">
                Ce site est le produit d'un projet de la filière Systèmes de Télécommunications, Réseaux et Informatique. Notre groupe composé de 5 étudiants
                avait comme but de réaliser un site fonctionnel de critiques sur des oeuvres musicales. Ainsi, le site internet sur lequel vous naviguez en ce moment même
                est le résultat de semaines de travail sur les langages HTML, CSS, PHP ainsi que sur l'utilisation d'une base de données.
            </h2>
        </div>
        
        <div>
            <h1 class="red1 t35 text-center"> L'équipe </h1>
            <h2 class="white  t20 flex flex-center">
                <ul>
                  <li> LABORDE Tonin </li>
                  <li> LAPEYRADE Sylvain </li>
                  <li> OLIVIER Thomas </li>
                  <li> ROBERT DE ST VINCENT Guillaume </li>
                  <li> WATHOJE Emmanuel </li>
                </ul>
              </h2>
        </div>
        
    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>