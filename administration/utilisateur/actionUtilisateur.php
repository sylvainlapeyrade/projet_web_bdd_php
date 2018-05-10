<?php

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $idUtilisateur = $_GET['idUtilisateur'];
    $motDePasse = $_GET['motDePasse'];
    $verification = $_GET['verification'];
    $statut = $_GET['statut'];
}

if ( isset($db) ) {
    switch($action) {
        case 'ajouterUtilisateur':
        /*
         * Champs présent : idUtilisateur, motDePasse, statut
         * Champs obligatoire : idUtilisateur, motDePasse
         */
        if( isset($db, $idUtilisateur, $motDePasse) ) {
            if ( !empty($idUtilisateur) && !empty($motDePasse) ) {
                if ( $statut == 1 )
                    $estAdmin = true;
                else
                    $estAdmin = false;
                $operationOk = ajouter_utilisateur($db, $idUtilisateur, $motDePasse, $estAdmin);
                if ( $operationOk ) {
                    header('Location: ./gestionUtilisateur.php?operation=ok');
                } else { $erreur = $messages['operation']['ko']; }
            } else { $erreur = $messages['formulaire']['champs_vide']; }
        } else { $erreur = $messages['formulaire']['invalide']; }
        break;

        case 'modifierMotDePasseUtilisateur':
        /*
         * Champs présent : idUtilisateur, motDePasse, verification
         * Champs obligatoire : idUtilisateur, motDePasse, verification
         */
        if ( isset($db, $idUtilisateur, $motDePasse, $verification) ) {
            if ( !empty($idUtilisateur) && !empty($motDePasse) && !empty($verification) ) {
                if ( $motDePasse == $verification ) {
                    $operationOk = modifier_motdepasse_utilisateur($db, $idUtilisateur, $motDePasse);
                    if ( $operationOk ) {
                        header('Location: ./gestionUtilisateur.php?operation=ok');
                    } else { $erreur = $erreur = $messages['operation']['ko']; }
                } else { $erreur = $erreur = $messages['formulaire']['motDePasseDifferent']; }
            } else { $erreur = $messages['formulaire']['champs_vide']; }
        } else { $erreur = $messages['formulaire']['invalide']; }
        break;

        case 'modifierStatutUtilisateur':
        /*
         * Champs présent : idUtilisateur, statut
         * Champs obligatoire : idUtilisateur
         */
        if ( isset($db, $idUtilisateur, $statut) ) {
            if ( !empty($idUtilisateur) ) {
                if ( $statut == 1 )
                    $estAdmin = true;
                else
                    $estAdmin = false;
                if ( $idUtilisateur != $_SESSION['idUtilisateur'] ) {
                    $operationOk = modifier_statut_utilisateur($db, $idUtilisateur, $estAdmin);
                    if ( $operationOk ) {
                        header('Location: ./gestionUtilisateur.php?operation=ok');
                    } else { $erreur = $erreur = $messages['operation']['ko']; }
                } else { $erreur = $erreur = $messages['formulaire']['erreurDevenirUtilisateur']; }
            } else { $erreur = $messages['formulaire']['champs_vide']; }
        } else { $erreur = $messages['formulaire']['invalide']; }
        break;

        case 'supprimerUtilisateur':
        /*
         * Champs présent : idUtilisateur
         * Champs obligatoire : idUtilisateur
         */
        if ( isset($db, $idUtilisateur) ) {
            if ( !empty($idUtilisateur) ) {
                if ( $idUtilisateur != $_SESSION['idUtilisateur'] ) {
                    $operationOk = supprimer_utilisateur($db, $idUtilisateur);
                    if ( $operationOk ) {
                        header('Location: ./gestionUtilisateur.php?operation=ok');
                    } else {
                        $erreur = $erreur = $messages['operation']['ko'];
                    }
                } else {
                    $erreur = $erreur = $messages['formulaire']['erreurSupprimerSonCompte'];
                }
            } else {
                $erreur = $messages['formulaire']['champs_vide'];
            }
        } else {
            $erreur = $messages['formulaire']['invalide'];
        }
        break;
    }
}

?>