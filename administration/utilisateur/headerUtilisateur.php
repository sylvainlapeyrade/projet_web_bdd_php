<?php
/**
 * Page headerUtilisateur.php
 * Inclut les caractéristiques du bouton Gestion des utilisateurs et Ajouter une utilisateur
 */
?>

<div id="headerGestion" class="flex flex-row">

    <div class="t24">
        <a href="gestionUtilisateur.php" class="bouton">Gestion des utilisateurs</a>
    </div>

    <div>
        <a href="formUtilisateur.php" class="bouton bouton-forme1 bouton-red1 t12 bouton-header">Ajouter un utilisateur</a>
    </div>

    <?php include_once(dirname(__FILE__).'/../headerMessage.php'); ?>

</div>