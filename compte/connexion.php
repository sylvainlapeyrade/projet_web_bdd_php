<?php

session_start();
include_once(dirname(__FILE__).'/../fonctions/variables.php');
include_once(dirname(__FILE__).'/../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../bdd/connexion.php');

$info['head']['subTitle'] = "Connexion";
$info['head']['stylesheets'] = ['compte.css'];

if(is_connect()) {leave();}

/* Gestion du formulaire connexion */
if ( isset($_GET['connexion']) && $_GET['connexion'] == 'connexion' ) {
    $identifiant = $_GET['idUtilisateur'];
    $motDePasse = $_GET['motDePasse'];
    if ( isset($db) && isset($identifiant) && isset($motDePasse) ) {
        if ( !empty($identifiant) && !empty($motDePasse) ) {
            $actionOk = connexion_account($db, $identifiant, $motDePasse);
            if ( $actionOk ) {
                header('Location: /index.php');
            } else { $erreur = $messages['connexion']['incorrect']; }
        } else { $erreur = $messages['formulaire']['champs_vide']; }
    } else { $erreur = $messages['formulaire']['invalide']; }
}

?>

<?php include_once(dirname(__FILE__).'/../head.php'); ?>
<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
    <section class="text-center">
        
        <h1 class="t30 souligner">Connexion</h1>
        
        <? if ( isset($erreur) ) { ?>
        <!-- Message d'erreur du formulaire -->
        <p class="red"><?php echo $erreur; ?></p>
        <? } ?>
        <? if ( isset($_GET['action']) && $_GET['action'] == 'inscription' ) { ?>
        <!-- Message si l'utilisateur viens de s'inscrire -->
        <p class="green">Votre compte a été crée.<br>Connectez-vous à votre compte !</p>
        <? } ?>
        
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
            
        <input id="button" 
               class="button button-red1 margin-center" 
               type="submit" 
               name="connexion" 
               value="connexion"
               />
        </form>
        <!-- FIN FORMULAIRE -->
        
        <br>
        <p class="message">Pas encore inscrit ? <br> Allez-y : <a class="souligner" href="/compte/inscription.php">s'inscrire</a></p>
        
    </section>
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
