<?php

if ( isset($db) ) {
    if ( isset($idAlbum) ) {
        $listeEvaluations = recuperer_evaluation_album_tous($db, $idAlbum);
    } elseif ( isset($idMusique) ) {
        $listeEvaluations = recuperer_evaluation_musique_tous($db, $idMusique);
    }
}

?>

<!-- COMMENTAIRE -->
<div id="page-evaluation">
    <hr size="1" color=#e8491d>
    
    <?php include_once(dirname(__FILE__).'/headerEvaluation.php'); ?>

    <?php include_once(dirname(__FILE__).'/formEvaluation.php'); ?>

    <div class="evaluations">
        
        <h2> Evaluations : </h2>
        <hr size="1" color=#e8491d>
        
        <?php if ( !empty($listeEvaluations) ) { ?>
            <?php foreach($listeEvaluations as $evaluation) { ?>
                <div>
                    
                    <!-- BOUTON SUPPRIMER -->
                    <p>
                        <?php if ( isset($idAlbum) ) { ?>

                            <b><?php echo $evaluation['idutilisateureval']; ?></b>&nbsp; &nbsp;Note: <?php echo $evaluation['noteeval']; ?>/5

                            <?php if ( is_admin() || $_SESSION['idUtilisateur'] == $evaluation['idutilisateureval'] ) { ?> 
                                <a class="bouton bouton-forme2 bouton-red1" 
                                   href="/album.php?action=supprimerEvaluationAlbum&idAlbum=<?php echo $idAlbum; ?>&idUtilisateur=<?php echo $evaluation['idutilisateureval']; ?>"
                                   >Supprimer</a>
                            <?php } ?>
                        
                        <?php } elseif ( isset($idMusique) ) { ?>

                            <b><?php echo $evaluation['idutilisateurevmu']; ?></b>&nbsp; &nbsp;Note: <?php echo $evaluation['noteevmu']; ?>/5

                            <?php if ( is_admin() || $_SESSION['idUtilisateur'] == $evaluation['idutilisateurevmu'] ) { ?> 
                                <a class="bouton bouton-forme2 bouton-red1" 
                                   href="/musique.php?action=supprimerEvaluationMusique&idMusique=<?php echo $idMusique; ?>&idUtilisateur=<?php echo $evaluation['idutilisateurevmu']; ?>"
                                   >Supprimer</a>
                            <?php } ?>
                        
                        <?php } ?>
                    </p>
                    
                    <!-- COMMENTAIRE -->
                    <p>
                        <?php if ( isset($idAlbum) ) {
                            echo $evaluation['commentaireeval'];
                        } elseif ( isset($idMusique) ) {
                            echo $evaluation['commentaireevmu'];
                        } ?>
                    </p>
                    
                    <hr size="1" color=#e8491d>
                </div>
            <?php } ?>
        <?php } ?>
    
        <?php if ( empty($listeEvaluations) ) { ?>
            <h3>Il n'y a pas encore d'évaluation.</h3>
        <?php } ?>
    
    </div>
    
</div>
<!-- FIN COMMENTAIRE -->