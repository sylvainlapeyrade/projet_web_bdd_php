<?php
session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionArtiste.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Page artiste";
$info['head']['stylesheets'] = ['artiste.css'];

include_once(dirname(__FILE__).'/head.php');
?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>

<main>
    <section>
        <!-- Présentation de l'artiste -->
        <div class="flex">
            <div id="description-artiste" class="flex-around">
                <div>
                    <h1>Nom_Artiste</h1>
                    <p>
                        Ceci est la description de l'artiste<br>
                        Matthieu Tota dit M. Pokora ou Matt Pokora, né le 26 septembre 1985 à Strasbourg, est un chanteur français.<br>
                        En 2003, il remporte la saison 3 de l'émission Popstars avec le groupe Linkup. Après le premier album du groupe,
                        Notre étoile, il décide de mener une carrière solo, et dévoile en novembre 2004 son premier album. Il a depuis publié 7 autres albums ainsi qu'un album live, et remporté la première saison de l'émission Danse avec les stars sur TF1 en 2011.
                        En 2016, il devient juré dans la 3e saison, dans The Voice Kids qu'il gagnera en tant que coach de Manuella. En 2017, après un grand succès d'après les avis des
                        téléspectateurs il devient juré dans The Voice : La Plus Belle Voix, qu'il gagnera également en tant que coach de Lisandro Cuxi.
                    </p>
                    <p>
                        Il fait parti des groupes : <a>GroupeA</a>, <a>GroupeB</a>, <a>GroupeC</a>.
                    </p>
                </div>
                <!-- Récompense de l'artiste -->
                <div id="liste-recompense" class="text-center flex flex-column">
                    <h4>Récompenses de l'artiste</h4>
                    <table class="width-500 margin-center">
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
                            <td>2013</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div>
                <img id="imageArtiste" src="styles/mpokora.htm">
            </div>
        </div>

        <!-- Musiques de l'artiste -->
        <div>
            <hr>
            <div id="liste-musiques" class="text-center">
                <h4>Musiques de l'artiste</h4>
                <table class="text-center">
                    <tr>
                        <th class="table-head width-300">Titre</th>
                        <th class="table-head width-150">Durée</th>
                        <th class="table-head width-150">Date</th>
                        <th class="table-head width-200">Genre</th>
                        <th class="table-head width-300">Album</th>
                        <th class="table-head width-700">Descritpion</th>
                    </tr>
                    <tr class="table-lign">
                        <td class=""><a>Mon étoile</a></td>
                        <td>2 minutes 34</td>
                        <td>02/19/2003</td>
                        <td>RnB</td>
                        <td><a>Notre étoile</a></td>
                        <td>Premier single Mon étoile se classe premier du Top 50 en 2003</td>
                    </tr>
                    <tr class="table-lign">
                        <td class=""><a>Pas sans toi</a></td>
                        <td>2 minutes 45</td>
                        <td>02/04/2004</td>
                        <td>RnB</td>
                        <td><a>M. Pokora</a></td>
                        <td>Pas sans toi est le troisième single extrait de l'album M. Pokora du chanteur français M. Pokora.</td>
                    </tr>
                    <tr  class="table-lign">
                        <td class=""><a>Combien de temps</a></td>
                        <td>3 minutes 43</td>
                        <td>02/19/2004</td>
                        <td>RnB</td>
                        <td><a>Notre étoile</a></td>
                        <td></td>
                    </tr>
                    <tr  class="table-lign">
                        <td class=""><a>Beaucoup d'argent</a></td>
                        <td>3 minutes 20</td>
                        <td>02/19/2008</td>
                        <td></td>
                        <td><a></a></td>
                        <td>3ème single de matthieu.</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
