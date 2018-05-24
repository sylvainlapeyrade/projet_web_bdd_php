<?php

/**
 * @file barreRecherche.php
 * @brief Inclut les caractéristiques de la barre de recherche
 */

?>

<div id="barre-recherche">
    <form class="flex flex-center item-center" action="/recherche.php" method="get">
        <span class="t20">Nouvelle recherche : </span>
        <input id="input-recherche"
               type="text"
               class="width-500"
               name="recherche"
               placeholder="Artiste, groupe, album ou musique"
               value="<?php echo $recherche; ?>"
               />
        <input class="bouton bouton-forme1 bouton-red1" type="submit" value="Rechercher" />
    </form>
</div>