<?php
session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionGroupe.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Page groupe";
$info['head']['stylesheets'] = ['groupe.css'];

include_once(dirname(__FILE__).'/head.php');
?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>


<main>
    <section>
        <!-- Présentation du groupe -->
        <div class="flex">
            <div id="description-groupe" class="flex-around">
                <div>
                    <h1><a>Nom_Groupe</a>  - <a>Date_de_formation_init</h1>
                    <p>
                        Ceci est la description du groupe<br>
                        Linkup est un boys band français, aujourd'hui dissous, vainqueur de la troisième saison de Popstars (intitulée Popstars, le duel), une émission de télé-réalité musicale diffusée sur M6, en 2003. Il est composé de Matthieu Tota, Lionel Tim et Otis, qui succèdent ainsi aux L5 et aux Whatfor.<br>
                        L'un des trois membres, Matthieu Tota, poursuit aujourd'hui une carrière solo sous le nom de M. Pokora.<br>
                        <br>
                    </p>
                </div>
                <div id="liste-membre" class="text-center flex flex-arround">
                    <div>
                        <h4>Composition du groupe</h4>
                        <table class="text-center">
                            <tr>
                                <th class="table-head width-250">Artiste</th>
                            </tr>
                            <tr class="table-lign">
                                <td><a>M.Pokora</a></td>
                            </tr>
                            <tr class="table-lign">
                                <td><a>Lionel Tim</ a></td>
                            </tr>
                            <tr class="table-lign">
                                <td><a>Ostis</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div>
                <img id="imageGroupe" src="styles/mpokora.htm">
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

