<?php

session_start();
include_once(dirname(__FILE__).'/../fonctions/variables.php');
include_once(dirname(__FILE__).'/../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../bdd/connexion.php');

$info['head']['subTitle'] = "Inscription";
$info['head']['stylesheets'] = ['compte.css'];

if(is_connect()) {leave();}

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $identifiant = $_GET['idUtilisateur'];
    $motDePasse = $_GET['motDePasse'];
    $verification = $_GET['verification'];
}

if ( isset($db) ) {
    switch($action) {
        case 'inscription':
            /*
             * Champs présent : identifiant, motDePasse, verification
             * Champs obligatoire : identifiant, motDePasse, verification
             */
            if ( !isset($identifiant, $motDePasse, $verification) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($identifiant) || empty($motDePasse) || empty($verification) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( $motDePasse != $verification ) {
                $erreur = $messages['formulaire']['motDePasseDifferent'];
                break;
            }
            $operationOk = inscription($db, $idUtilisateur, $motDePasse);
            if ( !$operationOk ) {
                $erreur = $messages['formulaire']['utilisateurExistant'];
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
        
        <!-- <h1 class="t30 souligner">Inscription</h1> -->
        
        <? if ( isset($erreur) ) { ?>
        <!-- Message d'erreur du formulaire -->
        <p class="red"><?php echo $erreur; ?></p>
        <? } ?>
        
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
                   class="bouton bouton-red1 margin-center" 
                   type="submit" 
                   name="inscription" 
                   value="inscription"
                   />
        </form>
        <!-- FIN FORMULAIRE -->
        
        <br>
        <p class="message">Déjà inscrit ? <br> Connectez-vous : <a class="souligner" href="/compte/connexion.php">se connecter</a></p>
    
    </section>
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
