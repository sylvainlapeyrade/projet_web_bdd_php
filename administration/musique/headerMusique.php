<?php

/**
 * @file headerMusique.php
 * @brief Inclut les caractéristiques du bouton Gestion des musique et Ajouter une musique
 */

?>

<div id="headerGestion" class="flex flex-row">

    <div class="t24">
        <a href="./gestionMusique.php" class="bouton">Gestion des musiques</a>
    </div>

    <div>
        <a href="formMusique.php" class="bouton bouton-forme1 bouton-red1 t12 bouton-header">Ajouter une musique</a>
    </div>

    <?php include_once(dirname(__FILE__).'/../headerMessage.php'); ?>

</div>