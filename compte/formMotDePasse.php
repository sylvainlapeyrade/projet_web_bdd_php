<?php
session_start();
include_once(dirname(__FILE__).'/../fonctions/variables.php');
include_once(dirname(__FILE__).'/../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../bdd/connexion.php');

$info['head']['subTitle'] = "Formulaire mot de passe";
$info['head']['stylesheets'] = ['compte.css'];

if(!is_connect()) {leave();}

$idUtilisateur = $_GET['idUtilisateur'];

include_once(dirname(__FILE__).'/actionCompte.php');

include_once(dirname(__FILE__).'/../head.php');

?>

<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
    <section>
        <div id="page-compte-form" class="text-center margin-center">
            
            <h1>Changer de mot de passe</h1>

            <?php include_once(dirname(__FILE__).'/headerCompte.php'); ?>
            
            <!-- FORMULAIRE :
                 motDePasse : password
                 verification : password
            -->
            <form class="flex flex-center flex-column" action="./formMotDePasse.php" method="get">

                <input class="input-text" 
                       type="password" 
                       name="motDePasse" 
                       placeholder="Mot de passe" 
                       required
                       />

                <input class="input-text" 
                       type="password" 
                       name="verification" 
                       placeholder="Vérification" 
                       required
                       />

                <input type="hidden"
                       name="action"
                       value="modifierMotDePasse"
                        />

                <input class="bouton bouton-forme1 bouton-red1 margin-center"
                       type="submit"
                       value="modifier"
                        />
            </form>
            <!-- FIN FORMULAIRE -->

        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
