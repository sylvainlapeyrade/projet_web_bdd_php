<?php

/**
 * @file headerAssemblerAlbum.php
 * @brief Inclut les caractéristiques du bouton Gestion des albums
 */

?>

<div id="headerGestion" class="flex flex-row">
    
    <div class="t24">
        <a href="./gestionAlbum.php" class="bouton">Gestion des albums</a>
    </div>
    
    <div>
        <a href="./gestionAssemblerAlbum.php?idAlbum=<?php echo $idAlbum ?>" class="bouton bouton-forme1 bouton-red1 t12 bouton-header">Gérer l'album courant</a>
    </div>
    
    <div>
        <a href="./formAssemblerAlbum.php?idAlbum=<?php echo $idAlbum ?>" class="bouton bouton-forme1 bouton-red1 t12 bouton-header">Ajouter une musique à l'album</a>
    </div>

    <?php include_once(dirname(__FILE__).'/../headerMessage.php'); ?>

</div>