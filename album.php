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
        <!-- Présentation de l'artiste -->
        <div class="flex">
            <div id="description-artiste" class="flex-around">
                <div>
                    <h1>Artiste Blabla</h1>
                    <p>
                        Ceci est la description de l'artiste<br>
                        A peep at some distant orb has power to raise and purify our thoughts like a strain of sacred music, or a noble picture, or a passage from the grander poets. It always does one good.<br>
                    </p>
                    <p>
                        Il fait parti des groupes : <a>GroupeA</a>, <a>GroupeB</a>, <a>GroupeC</a>.
                    </p>
                </div>
                <div id="liste-album" class="flex flex-arround">
                    <div>
                        <h4>Albums de l'artiste</h4>
                        <table>
                            <tr>
                                <th class="table-head width-250">Nom</th>
                                <th class="table-head width-250">Année</th>
                            </tr>
                            <tr class="table-lign">
                                <td>Album 1</td>
                                <td>2010</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Album 2</td>
                                <td>2010</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Album 3</td>
                                <td>2010</td>
                            </tr>
                            <tr class="table-lign"><td>Album 3</td><td>2010</td></tr>
                        </table>
                    </div>
                    <div>
                        <h4>Récompense de l'artiste</h4>
                        <table>
                            <tr>
                                <th class="table-head width-250">Nom</th>
                                <th class="table-head width-250">Date</th>
                            </tr>
                            <tr class="table-lign">
                                <td>Récompense 1</td>
                                <td>2010</td>
                            </tr>
                            <tr class="table-lign">
                                <td>Récompense 2</td>
                                <td>2010</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div>
                <img id="imageArtiste" src="styles/mpokora.htm">
            </div>
        </div>

        <!-- Albums et Musique de l'artiste -->
        <div>

            <hr>
            <div id="liste-musique">
                <h4>Musique de l'artiste</h4>
                <table>
                    <tr>
                        <th class="table-head width-300">Titre</th>
                        <th class="table-head width-300">Durée</th>
                        <th class="table-head width-300">Date</th>
                        <th class="table-head width-600">Descritpion</th>
                    </tr>
                    <tr class="table-lign">
                        <td class="">Chanson 1</td>
                        <td>2 minutes 64</td>
                        <td>02/19/1978</td>
                        <td>Ceci est une description de la musique</td>
                    </tr>
                    <tr class="table-lign">
                        <td>Album1</td>
                        <td>30 sec</td>
                        <td>02/19/1978</td>
                        <td>Ceci est une description de la musique</td>
                    </tr>
                    <tr  class="table-lign">
                        <td>Album1</td>
                        <td>1 heures</td>
                        <td>02/19/1978</td>
                        <td>Ceci est une description de la musique</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</main>




<?php include_once(dirname(__FILE__).'/footer.php'); ?>

