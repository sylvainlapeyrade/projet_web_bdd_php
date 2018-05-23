<?php
/**
* Page formEvaluation.php
* Permet d'ajouter une evaluation à la BBD
*/
?>

<div id="form-evaluation">
    
    <?php if ( is_connect() ) { ?>
        <!-- FORMULAIRE -->
        <form id="form" method="get">
            
            <div>
                <p id="stars"> Donnez une note :
                    <?php for($i = 1; $i < 6; $i++ ) { ?>
                        <?php if ( isset($idMusique) ) { ?>
                            <a class="<?php if ($note>=$i) echo 'red' ?>" href="?idMusique=<?php echo $idMusique; ?>&star=<?php echo $i ?>#stars">★</a>
                        <?php } elseif ( isset($idAlbum) ) { ?>
                            <a class="<?php if ($note>=$i) echo 'red' ?>" href="?idAlbum=<?php echo $idAlbum; ?>&star=<?php echo $i ?>#stars">★</a>
                        <?php } ?>
                    <?php } ?>
                </p>
            </div>
            
            <?php if ( isset($idAlbum) ) { ?>
                <input type="hidden"
                       name="idAlbum"
                       value="<?php echo $idAlbum; ?>"
                       />
            
                <input type="hidden"
                       name="action"
                       value="ajouterEvaluationAlbum"
                       />
            <?php } elseif ( isset($idMusique) ) { ?>
                <input type="hidden"
                       name="idMusique"
                       value="<?php echo $idMusique; ?>"
                       />
            
                <input type="hidden"
                       name="action"
                       value="ajouterEvaluationMusique"
                       />
            <?php } ?>
            
            <input type="hidden"
                   name="note"
                   value="<?php echo $note ?>"
                   />
            
            <textarea class="input-area"
                      name="commentaire"
                      cols="50"
                      rows="5"
                      <?php if ( !isset($note) || empty($note) ) { echo 'disabled'; } ?>
                      placeholder="Sélectionnez une note et entrez votre commentaire ici"
                      required ><?php if(isset($commentaire)){echo $commentaire;} ?></textarea>
            
            <input class="bouton bouton-forme1 bouton-red1"
                   type="submit"
                   value="Envoyer"
                   />
            
        </form>
        <!-- FIN FORMULAIRE -->
    
    <?php } else { ?>
        <p>
            <?php if ( isset($idAlbum) ) {
                $target = urlencode("/album.php?idAlbum=$idAlbum");
            } elseif ( isset($idMusique) ) {
                $target = urlencode("/musique.php?idMusique=$idMusique");
            } ?>
            <a class="souligner red1" href="/compte/connexion.php?redirect=<?php echo $target; ?>">Connectez-vous</a> pour poster une évaluation.
        </p>
    <?php } ?>
    
</div>
