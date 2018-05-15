<div id="form-evaluation">
    
    <?php if ( is_connect() ) { ?>
        <!-- FORMULAIRE -->
        <form id="form" action="/musique.php" method="get">
            
            <div>
                <p id="stars"> Donnez une note à cette musique :
                    <a class="<?php if ($note>0) echo 'red' ?>" href="?idMusique=<?php echo $idMusique; ?>&star=1#stars">★</a>
                    <a class="<?php if ($note>1) echo 'red' ?>" href="?idMusique=<?php echo $idMusique; ?>&star=2#stars">★</a>
                    <a class="<?php if ($note>2) echo 'red' ?>" href="?idMusique=<?php echo $idMusique; ?>&star=3#stars">★</a>
                    <a class="<?php if ($note>3) echo 'red' ?>" href="?idMusique=<?php echo $idMusique; ?>&star=4#stars">★</a>
                    <a class="<?php if ($note>4) echo 'red' ?>" href="?idMusique=<?php echo $idMusique; ?>&star=5#stars">★</a>
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
                       value="ajouterEvaluationArtiste"
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
                      placeholder="Votre commentaire ici..."
                      required ><?php if(isset($commentaire)){echo $commentaire;} ?></textarea>
            
            <input class="bouton bouton-forme1 bouton-red1"
                   type="submit"
                   value="Envoyer"
                   />
            
        </form>
        <!-- FIN FORMULAIRE -->
    
    <?php } else { ?>
        <p>
            <a class="souligner red1" href="/compte/connexion.php">Connectez-vous</a> pour poster une évaluation.
        </p>
    <?php } ?>
    
</div>