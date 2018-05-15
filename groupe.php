<?php

session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionGroupe.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Page groupe";
$info['head']['stylesheets'] = ['barreRecherche.css', 'groupe.css'];

$idGroupe = $_GET['idGroupe'];
if ( isset($db, $idGroupe) ) {
    $groupe = recuperer_groupe($db, $idGroupe)[0];
    if ( empty($groupe) ) {
        header('Location: /index.php');
    }
    $listeArtistesGroupe = recuperer_artiste_groupe($db, $idGroupe);
    //$listeMusiqueGroupe = recuperer_musique_groupe($db, $idGroupe);
} else {
    header('Location: /index.php');
}

include_once(dirname(__FILE__).'/head.php');

?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>


<main>
    <section>

        <?php include_once(dirname(__FILE__).'/barreRecherche.php'); ?>

        <div id="page-groupe">
            <!-- Présentation du groupe -->
            <div class="flex flex-between">
                <div id="description-groupe" class="flex-around">
                    <div>
                        <h1 class="red1"><?php if(isset($groupe)){echo $groupe['nomgroupe'];} ?> -
                            <?php if(isset($groupe)){echo $groupe['dategroupe'];} ?></h1>
                        <p>
                            <?php if(isset($groupe)){echo $groupe['descriptiongroupe'];} ?>
                        </p>
                    </div>
                    <div id="liste-membre" class="text-center flex flex-arround">
                        Membres du groupe :
                        <?php foreach($listeArtistesGroupe as $key => $artiste) { ?>
                            <a class="souligner" href="/artiste.php?idArtiste=<?php echo $artiste['idartiste']; ?>">
                                <?php if ( !empty($artiste['nomscene']) ) {
                                    echo $artiste['nomscene'];
                                } else {
                                    echo $artiste['nomartiste'].' '.$artiste['prenomartiste'];
                                } ?>
                            </a>
                            <?php if ( sizeof($listeArtistesGroupe) > 1 && sizeof($listeArtistesGroupe)-1 > $key ) { echo '&nbsp-&nbsp'; } ?>
                        <?php } ?>
                    </div>
                </div>

                <?php if ( !empty($groupe['urlimagegroupe']) ) { ?>
                    <div>
                        <img id="imageGroupe" src="<?php echo $groupe['urlimagegroupe']; ?>">
                    </div>
                <?php } ?>

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

        </div>

    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>

