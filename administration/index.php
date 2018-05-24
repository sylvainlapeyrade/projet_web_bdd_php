<?php

/**
 * @file admin/index.php
 * @brief Page d'acceuil de la partie administration du site,
 * présentant les différentes options de navigation dans la partie administration
 */

    session_start();
    include_once(dirname(__FILE__).'/../fonctions/variables.php');
    include_once(dirname(__FILE__).'/../fonctions/fonctionCompte.php');


    $info['head']['subTitle'] = "Administration";
    $info['head']['stylesheets'] = ['adminGestion.css'];

    include_once(dirname(__FILE__).'/../head.php');
?>

<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
  <section>
    <div>
        
        <h1>
          <a href="./index.php">Panneau d'adminsitration</a>
        </h1>
        
        <div>
            <p>
                <a class="bouton bouton-forme1 bouton-red1" href="utilisateur/gestionUtilisateur.php">
                  Gestion des utilisateurs
                </a>
            </p>
            <br>
            <p>
                <a class="bouton bouton-forme1 bouton-red1" href="./artiste/gestionArtiste.php">
                  Gestion des artistes
                </a>
                &nbsp
                <a class="bouton bouton-forme1 bouton-red1" href="./groupe/gestionGroupe.php">
                  Gestion des groupes
                </a>
            </p>
            <br>
            <p>
                <a class="bouton bouton-forme1 bouton-red1" href="./album/gestionAlbum.php">
                  Gestion des albums
                </a>
                &nbsp
                <a class="bouton bouton-forme1 bouton-red1" href="./musique/gestionMusique.php">
                  Gestion des musiques
                </a>
            </p>
            <br>
            <p>
                <a class="bouton bouton-forme1 bouton-red1" href="./recompense/gestionRecompense.php">
                  Gestion des récompenses
                </a>
            </p>
        </div>
        
    </div>
  </section>
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
