<?php

session_start();
include_once(dirname(__FILE__).'/../fonctions/variables.php');
include_once(dirname(__FILE__).'/../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../bdd/connexion.php');

$info['head']['subTitle'] = "Connexion";
$info['head']['stylesheets'] = ['compte.css'];

if(is_connect()) {leave();}

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $identifiant = $_GET['idUtilisateur'];
    $motDePasse = $_GET['motDePasse'];
}

if ( isset($db) ) {
    switch($action) {
        case 'connexion':
            /*
             * Champs présent : identifiant, motDePasse
             * Champs obligatoire : identifiant, motDePasse
             */
            if ( !isset($identifiant, $motDePasse) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($identifiant) || empty($motDePasse) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            $operationOk = connexion_compte($db, $identifiant, $motDePasse);
            if ( !$operationOk ) {
                $erreur = $messages['connexion']['incorrect'];
                break;
            }
            header('Location: /index.php');
            break;
    }
}

?>

<?php include_once(dirname(__FILE__).'/../head.php'); ?>

<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main>
    <section class="text-center">
        
       <!-- <h1 class="t30 souligner">Connexion</h1> -->
        
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
            
        <input id="bouton" 
               class="bouton bouton-red1 margin-center" 
               type="submit" 
               name="action" 
               value="connexion"
               />
        </form>
        <!-- FIN FORMULAIRE -->
        
        <br>
        <p class="message">Pas encore inscrit ? <br> Allez-y : <a class="souligner" href="/compte/inscription.php">s'inscrire</a></p>
        
    </section>
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
