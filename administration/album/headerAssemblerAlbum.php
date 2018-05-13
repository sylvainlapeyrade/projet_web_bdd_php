<div id="headerGestion" class="flex flex-row">
    
    <div class="t24">
        <a href="./gestionAlbum.php" class="bouton">Gestion des albums</a>
    </div>
    
    <div>
        <a href="./gestionAssemblerAlbum.php?idAlbum=<?php echo $idAlbum ?>" class="bouton bouton-blue t12 bouton-header">Gérer l'album courant</a>
    </div>
    
    <div>
        <a href="./formAssemblerAlbum.php?idAlbum=<?php echo $idAlbum ?>" class="bouton bouton-blue t12 bouton-header">Ajouter une musique à l'album</a>
    </div>

    <?php include_once(dirname(__FILE__).'/../headerMessage.php'); ?>

</div>