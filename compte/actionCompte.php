<?php
/**
 * Page actionCompte.php
 * Répond dynamiquement selon l'action entreprise
 * (Connexion, inscription, modification mdp)
 */

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $idUtilisateur = $_GET['idUtilisateur'];
    $motDePasse = $_GET['motDePasse'];
    $verification = $_GET['verification'];
    $redirect = $_GET['redirect'];
}

if ( isset($db, $action) ) {
    switch($action) {
        case 'connexion':
            /*
             * Champs présent : idUtilisateur, motDePasse
             * Champs obligatoire : idUtilisateur, motDePasse
             */
            if ( !isset($idUtilisateur, $motDePasse) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idUtilisateur) || empty($motDePasse) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            $operationOk = connexion_compte($db, $idUtilisateur, $motDePasse);
            if ( !$operationOk ) {
                $erreur = $messages['connexion']['incorrect'];
                break;
            }
            
            header('Location: '.$redirect);
            break;
            
        case 'inscription':
            /*
             * Champs présent : idUtilisateur, motDePasse, verification
             * Champs obligatoire : idUtilisateur, motDePasse, verification
             */
            if ( !isset($idUtilisateur, $motDePasse, $verification) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idUtilisateur) || empty($motDePasse) || empty($verification) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( $motDePasse != $verification ) {
                $erreur = $messages['formulaire']['motDePasseDifferent'];
                break;
            }
            $operationOk = inscription($db, $idUtilisateur, $motDePasse);
            if ( !$operationOk ) {
                $erreur = $messages['inscription']['utilisateurExistant'];
                break;
            }
            header('Location: ./connexion.php?action=inscriptionOk');
            break;
            
        case 'modifierMotDePasse':
            /*
             * Champs présent : motDePasse, verification
             * Champs obligatoire : motDePasse, verification
             */
            if ( !isset($motDePasse, $verification) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( empty($motDePasse) || empty($verification) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !is_connect() ) {
                $erreur = $messages['operation']['ko'];
                break;
            }
            if ( $motDePasse != $verification ) {
                $erreur = $messages['formulaire']['motDePasseDifferent'];
                break;
            }
            $operationOk = modifier_motdepasse_utilisateur($db, $_SESSION['idUtilisateur'], $motDePasse);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko'];
                break;
            }
            header('Location: ./index.php?action=modifierMdpOk');
            break;
            
        case 'supprimerCompte':
            /*
             * Champs présent : motDePasse, verification
             * Champs obligatoire : motDePasse, verification
             */
            if ( !is_connect() ) {
                $erreur = $messages['operation']['ko'];
                break;
            }
            $operationOk = supprimer_utilisateur($db, $_SESSION['idUtilisateur']);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko'];
                break;
            }
            header('Location: ./deconnexion.php');
            break;
            
        case 'inscriptionOk':
            $message = $messages['inscription']['inscriptionOk'];
            break;
            
        case 'modifierMdpOk':
            $message = $messages['operation']['ok'];
            break;
            
        case 'supprimerOk':
            $message = "Votre compte a bien été supprimé.";
            break;
    }
}

?>