<?php
session_start();
include_once(dirname(__FILE__).'/fonctions/variables.php');
include_once(dirname(__FILE__).'/fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/fonctions/fonctionMusique.php');
include_once(dirname(__FILE__).'/bdd/connexion.php');

$info['head']['subTitle'] = "Page musique";
$info['head']['stylesheets'] = ['musique.css'];

include_once(dirname(__FILE__).'/head.php');
?>

<?php include_once(dirname(__FILE__).'/header.php'); ?>


<main>
    <section>
        <!-- Présentation de la musique -->
        <div class="flex">
            <div id="description-album" class="flex-around">
                <div>
                    <h1><a>Titre_Musique</a> - <a>Date_sortie</a> - <a>Nom_Auteur</a></h1>
                    <p>
                        Ceci est la description de la musique<br>
                        Pas sans toi est le troisième single extrait de l'album M. Pokora du chanteur français M. Pokora.<br>
                    </p>
                    <p>
                        [Optionnel] Cette musique a été composé en collaboration avec <a>Nom_Artistes</a>
                    </p>
                    <p>
                        C'est la piste numero <a>Numero_Piste</a> de l'album <a>Nom_Album1</a><br>
                        C'est la piste numero <a>Numero_Piste</a> de l'album <a>Nom_Album2</a><br>
                        [Ou]<br>
                        Ce morceau est un single, il ne fait pas partie d'un album.
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>

