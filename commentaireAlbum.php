<div id="liste-commentaire">

    <hr size="1" color=#e8491d>

    <?php
    if ( is_connect() ) {
    ?>

    <form method="post" action="http://">
        <div class="rating">
            <p> Donnez une note à cette musique : 
                <a href="#5" title="Give 5 stars">★</a>
                <a href="#4" title="Give 4 stars">★</a>
                <a href="#3" title="Give 3 stars">★</a>
                <a href="#2" title="Give 2 stars">★</a>
                <a href="#1" title="Give 1 star">★</a>
            </p>
        </div>
        <textarea class="input-area" name="comments" cols="50" rows="5" class="html-text-box" placeholder="Votre commentaire ici..."></textarea>
        <br><br>
        <input type="submit" value="Envoyer" class="html-text-box">
        <input type="reset" value="Réinitialiser" class="html-text-box">
    </form>

    <?php } ?>

    <div class="comment">
        <h2> Commentaires </h2>
        <hr size="1" color=#e8491d>

        <p><b>Identifiant</b>&nbsp; &nbsp;21 Mai 2017</p>
        <p>Ceci est un commentaire. Pour l'instant, ce n'est qu'un test. On revient automatiquement à la ligne si le commentaire est trop long...</p>

        <hr size="1" color=#e8491d>
        <p><b>Identifiant</b>&nbsp; &nbsp;25 Avril 2018</p>
        <p>Ceci est un commentaire. Pour l'instant, ce n'est qu'un test. On revient automatiquement à la ligne si le commentaire est trop long...</p>
        <hr size="1" color=#e8491d>
    </div>

</div>
