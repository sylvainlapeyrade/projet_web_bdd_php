<?php
/**
 * Page headerGroupe.php
 * Inclut les caractéristiques du bouton Gestion des groupes et Ajouter un groupe
 */
?>

<div id="headerGestion" class="flex flex-row">
    
    <div class="t24">
        <a href="./gestionGroupe.php" class="bouton">Gestion des groupes</a>
    </div>
    
    <div>
        <a href="formGroupe.php" class="bouton bouton-forme1 bouton-red1 t12 bouton-header">Ajouter un groupe</a>
    </div>

    <?php include_once(dirname(__FILE__).'/../headerMessage.php'); ?>

</div>