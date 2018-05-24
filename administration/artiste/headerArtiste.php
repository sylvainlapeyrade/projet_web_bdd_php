<?php

/**
 * @file headerArtiste.php
 * @brief Inclut les caractéristiques du bouton Gestion des artistes et Ajouter un artiste
 */

?>

<div id="headerGestion" class="flex flex-row">
    
    <div class="t24">
        <a href="./gestionArtiste.php" class="bouton">Gestion des artistes</a>
    </div>
    
    <div>
        <a href="./formArtiste.php" class="bouton bouton-forme1 bouton-red1 t12 bouton-header">Ajouter un artiste</a>
    </div>

    <?php include_once(dirname(__FILE__).'/../headerMessage.php'); ?>

</div>