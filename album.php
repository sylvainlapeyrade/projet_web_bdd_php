<?php
    session_start();
    include_once(dirname(__FILE__) . '/fonctions/variables.php');
    include_once(dirname(__FILE__) . '/fonctions/fonction_compte.php');
    include_once(dirname(__FILE__) . '/fonctions/fonction_album.php');
    include_once(dirname(__FILE__) . '/bdd/connexion.php');

    $info['head']['subTitle'] = "Page album";
    $info['head']['stylesheets'] = ['album.css'];

    include_once(dirname(__FILE__).'/head.php');
?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>


<main>
    <section>
        <!-- Présentation de l'album -->
        <div class="flex">
            <div id="description-artiste" class="flex-around">
                <div>
                    <h1><a>Nom_Album</a>     <a>Date_sortie</h1>
                    <p>
                        Ceci est la description de l'album<br>
                        Player est le deuxième album du chanteur français M. Pokora sorti le 26 janvier 2006 en France. À sa sortie, l'album se classera à la première place du classement des ventes d'albums avec 31 000 exemplaires. <br>
                        <br>
                    </p>
                    <p>
                        Il a été composé par l'artiste : <a>Nom_Artiste</a>
                    </p>
                </div>
                <div id="liste-musique" class="flex flex-arround">
                    <div>
                        <h4>Morceaux de l'album:</h4>
                        <table>
                            <tr>
                                <th class="table-head width-250">Nom</th>
                                <th class="table-head width-250">Année</th>
                                <th class="table-head width-250">Durée</th>
                            </tr>
                            <tr class="table-lign">
                                <td>Piste n°1</td>
                                <td><a>De retour</a></td>
                                <td>3:30</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Piste n°2</td>
                                <td><a>Player</a></td>
                                <td>2:50</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Piste n°3</td>
                                <td><a>Oh la la la</a></td>
                                <td>3:01</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Piste n°4</td>
                                <td><a>Ce soir je lui dis tout</a></td>
                                <td>3:51</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Piste n°5</td>
                                <td><a>Mal de guerre</a></td>
                                <td>3:56</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Piste n°6</td>
                                <td><a>L'enfer du samedi soir</a></td>
                                <td>4:08</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Piste n°7</td>
                                <td><a>Interlude</a></td>
                                <td>1:01</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Piste n°8</td>
                                <td><a>Cynthia</a></td>
                                <td>2:51</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Piste n°9</td>
                                <td><a>STP</a></td>
                                <td>3:29</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Piste n°10</td>
                                <td><a>Cette Fille</a></td>
                                <td>3:14</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Piste n°11</td>
                                <td><a>Regarde maman / Je suis prêt pour la bataille</a></td>
                                <td>3:29</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div>
                <img id="imageArtiste" src="styles/mpokora.htm">
            </div>
        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>

