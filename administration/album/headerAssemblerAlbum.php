<div id="headerGestion" class="flex flex-row">
    
    <div class="t24">
        <a href="./gestionAlbum.php" class="button">Gestion des albums</a>
    </div>
    
    <div>
        <a href="./gestionAssemblerAlbum.php?idAlbum=<?php echo $idAlbum ?>" class="button button-blue t12 button-header">Gérer l'album courant</a>
    </div>
    
    <div>
        <a href="./formAssemblerAlbum.php?idAlbum=<?php echo $idAlbum ?>" class="button button-blue t12 button-header">Ajouter une musique à l'album</a>
    </div>

    <?php include_once(dirname(__FILE__).'/../headerMessage.php'); ?>

</div>