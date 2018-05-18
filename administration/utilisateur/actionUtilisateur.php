<?php

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $idUtilisateur = $_GET['idUtilisateur'];
    $motDePasse = $_GET['motDePasse'];
    $verification = $_GET['verification'];
    $statut = $_GET['statut'];
}

if ( isset($db, $action) ) {
    switch($action) {
        case 'ajouterUtilisateur':
            /*
             * Champs présent : idUtilisateur, motDePasse, statut
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
            if ( $statut == 1 ) {
                $estAdmin = true;
            } else {
                $estAdmin = false;
            }
            $operationOk = ajouter_utilisateur($db, $idUtilisateur, $motDePasse, $estAdmin);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko'];
                break;
            }
            header('Location: ./gestionUtilisateur.php?action=ajouterOk');
            break;

        case 'modifierMotDePasseUtilisateur':
            /*
             * Champs présent : idUtilisateur, motDePasse, verification
             * Champs obligatoire : idUtilisateur, motDePasse, verification
             */
            if ( !isset($idUtilisateur, $motDePasse, $verification) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idUtilisateur) || empty($motDePasse)  || empty($verification) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( $motDePasse != $verification ) {
                $erreur = $messages['formulaire']['motDePasseDifferent'];
                break;
            }
            $operationOk = modifier_motdepasse_utilisateur($db, $idUtilisateur, $motDePasse);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko'];
            }
            header('Location: ./gestionUtilisateur.php?action=modifierMdpOk');
            break;

        case 'modifierStatutUtilisateur':
            /*
             * Champs présent : idUtilisateur, statut
             * Champs obligatoire : idUtilisateur
             */
            if ( !isset($idUtilisateur, $statut) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;   
            }
            if ( empty($idUtilisateur) || empty($statut) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( $statut == 1 ) {
                $estAdmin = true;
            } else {
                $estAdmin = false;
            }
            if ( $idUtilisateur == $_SESSION['idUtilisateur'] ) {
                $erreur = $messages['formulaire']['erreurDevenirUtilisateur'];
                break;
            }
            $operationOk = modifier_statut_utilisateur($db, $idUtilisateur, $estAdmin);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko'];
                break;
            }
            header('Location: ./gestionUtilisateur.php?action=modifierStatutOk');
            break;

        case 'supprimerUtilisateur':
            /*
             * Champs présent : idUtilisateur
             * Champs obligatoire : idUtilisateur
             */
            if ( !isset($idUtilisateur) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idUtilisateur) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( $idUtilisateur == $_SESSION['idUtilisateur'] ) {
                $erreur = $messages['formualire']['erreurSupprimerSonCompte'];
                break;
            }
            $operationOk = supprimer_utilisateur($db, $idUtilisateur);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko'];
                break;
            }
            header('Location: ./gestionUtilisateur.php?action=supprimerOk');
            break;
            
        case 'ajouterOk':
            $message = $messages['operation']['ok'];
            break;
            
        case 'modifierMdpOk':
            $message = $messages['operation']['ok'];
            break;
        
        case 'modifierStatutOk':
            $message = $messages['operation']['ok'];
            break;
        
        case 'supprimerOk':
            $message = $messages['operation']['ok'];
            break;
    
    }
}

?>