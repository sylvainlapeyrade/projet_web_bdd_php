<?php

session_start();
include_once(dirname(__FILE__).'/../fonctions/variables.php');
include_once(dirname(__FILE__).'/../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../bdd/connexion.php');

$info['head']['subTitle'] = "Gestion compte";
$info['head']['stylesheets'] = ['compte.css'];

if(!is_connect()) {leave();}

include_once(dirname(__FILE__).'/../head.php');

include_once(dirname(__FILE__).'/actionCompte.php');

?>

<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
    <section>
        <div id="page-compte">

            <h1 class="t35 text-center">Gestion de votre compte</h1>
            
            <div class="margin-center text-center">
                
                <?php include_once(dirname(__FILE__).'/headerCompte.php'); ?>
                
                <p>
                    Nom d'utilisateur : <?php echo $_SESSION['idUtilisateur']; ?>
                </p>
                <br>
                <a class="bouton bouton-forme1 bouton-red1" href="./formMotDePasse.php">Modifier son mot de passe</a>
                <br>
                <br>
            </div>
        
        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
