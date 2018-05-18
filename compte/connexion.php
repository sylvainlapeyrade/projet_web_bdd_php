<?php

session_start();
include_once(dirname(__FILE__).'/../fonctions/variables.php');
include_once(dirname(__FILE__).'/../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../bdd/connexion.php');

$info['head']['subTitle'] = "Connexion";
$info['head']['stylesheets'] = ['compte.css'];

if(is_connect()) {leave();}

$redirect = $_GET['redirect'];

include_once(dirname(__FILE__).'/actionCompte.php');

?>

<?php include_once(dirname(__FILE__).'/../head.php'); ?>

<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
    <section>
        <div id="page-connexion" class="text-center margin-center">
                
            <!-- <h1 class="t30 souligner">Connexion</h1> -->

            <?php include_once(dirname(__FILE__).'/headerCompte.php'); ?>

            <!-- FORMULAIRE :
                 idUtilisateur : text
                 motDePasse : password
            -->
            <form class="flex flex-center flex-column" method="get">
                <input class="input-text"
                       type="text"
                       name="idUtilisateur" 
                       placeholder="Identifiant"
                       value="<?php if( isset($identifiant) ){ echo $identifiant; } ?>"
                       />

                <input class="input-text" 
                       type="password" 
                       name="motDePasse" 
                       placeholder="Mot de passe"
                       />

                <?php if ( isset($redirect) ) { ?>
                    <input type="hidden"
                           name="redirect"
                           value="<?php echo $redirect; ?>"
                           />
                <?php } ?>

                <input id="bouton" 
                       class="bouton bouton-forme1 bouton-red1 margin-center" 
                       type="submit" 
                       name="action" 
                       value="connexion"
                       />
            </form>
            <!-- FIN FORMULAIRE -->

            <br>
            <p class="message">Pas encore inscrit ? <br> Allez-y : <a class="souligner" href="/compte/inscription.php">s'inscrire</a></p>
        
        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
