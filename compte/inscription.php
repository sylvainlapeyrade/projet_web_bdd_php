<?php

session_start();
include_once(dirname(__FILE__).'/../fonctions/variables.php');
include_once(dirname(__FILE__).'/../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../bdd/connexion.php');

$info['head']['subTitle'] = "Inscription";
$info['head']['stylesheets'] = ['compte.css'];

if(is_connect()) {leave();}

include_once(dirname(__FILE__).'/actionCompte.php');

?>

<?php include_once(dirname(__FILE__).'/../head.php'); ?>

<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
    <section class="text-center">
        <div id="page-inscription" class="text-center margin-center">
            
            <!-- <h1 class="t30 souligner">Inscription</h1> -->

            <?php include_once(dirname(__FILE__).'/headerCompte.php'); ?>

            <!-- FORMULAIRE :
                 idUtilisateur : text
                 motDePasse : password
                 verification : password
            -->
            <form class="flex flex-center flex-column" method="get">
                <input class="input-text"
                       type="text"
                       name="idUtilisateur"
                       value="<?php echo $idUtilisateur; ?>"
                       placeholder="Identifiant"
                       />

                <input class="input-text"
                       type="password"
                       name="motDePasse"
                       placeholder="Mot de passe"
                       />

                <input class="input-text"
                       type="password"
                       name="verification"
                       placeholder="Vérification"
                       />

                <input id="bouton" 
                       class="bouton bouton-forme1 bouton-red1 margin-center" 
                       type="submit" 
                       name="action" 
                       value="inscription"
                       />
            </form>
            <!-- FIN FORMULAIRE -->

            <br>
            <p class="message">Déjà inscrit ? <br> Connectez-vous : <a class="souligner" href="/compte/connexion.php">se connecter</a></p>
        
        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
