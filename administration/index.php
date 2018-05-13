<?php
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
    <h1>
      <a href="./index.php">Panneau d'adminsitration</a>
    </h1>
    <section>
        <a class="bouton bouton-blue" href="utilisateur/gestionUtilisateur.php">
          Gestion des utilisateur
        </a><br><br>
        <a class="bouton bouton-blue" href="./artiste/gestionArtiste.php">
          Gestion des artistes
        </a><br><br>
        <a class="bouton bouton-blue" href="./recompense/gestionRecompense.php">
          Gestion des récompense
        </a><br><br>
        <a class="bouton bouton-blue" href="./groupe/gestionGroupe.php">
          Gestion des groupes
        </a><br><br>
        <a class="bouton bouton-blue" href="./album/gestionAlbum.php">
          Gestion des albums
        </a><br><br>
        <a class="bouton bouton-blue" href="./musique/gestionMusique.php">
          Gestion des musiques
        </a>
    </section>
  </section>
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
