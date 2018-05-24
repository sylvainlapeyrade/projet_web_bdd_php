<?php

/**
 * @file actionArtiste.php
 * @brief Fait le lien entre le formulaire artiste,
 * la gestion des artistes et la BDD
 */

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $idArtiste = $_GET['idArtiste'];
    $nomArtiste = strtolower($_GET['nomArtiste']);
    $prenomArtiste = strtolower($_GET['prenomArtiste']);
    $nomScene = strtolower($_GET['nomScene']);
    $dateNaissanceArtiste = format_date($_GET['dateNaissanceArtiste']);
    $urlImageArtiste = $_GET['urlImageArtiste'];
    $descriptionArtiste = $_GET['descriptionArtiste'];
}

if ( isset($db, $action) && is_connect() && is_admin() ) {
    switch($action) {
        case "ajouterArtiste":
            /*
             * Champs présent : nomArtiste, prenomArtiste, nomScene, dateNaissanceArtiste, urlImageArtiste, descriptionArtiste
             * Champs obligatoire : nomArtiste, prenomArtiste
             */
            if ( !isset($nomArtiste, $prenomArtiste, $nomScene, $dateNaissanceArtiste, $urlImageArtiste, $descriptionArtiste) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($nomArtiste) || empty($prenomArtiste) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !date_valide($dateNaissanceArtiste) ) {
                $erreur = $messages['formulaire']['dateInvalide'];
                break;
            }
            $operationOk = ajouter_artiste($db, $nomArtiste, $prenomArtiste, $nomScene, $dateNaissanceArtiste,  $urlImageArtiste, $descriptionArtiste);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (1)";
                break;
            }
            header('Location: ./gestionArtiste.php?action=ajouterOk');
            break;

        case "modifierArtiste":
            /*
             * champs présent : idArtiste, nomArtiste, prenomArtiste, nomScene, dateNaissanceArtiste, urlImageArtiste, descriptionArtiste
             * Champs obligatoire : idArtiste, nomArtiste, prenomArtiste
             */
            if ( !isset($idArtiste, $nomArtiste, $prenomArtiste, $nomScene, $dateNaissanceArtiste, $urlImageArtiste, $descriptionArtiste) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if (  empty($idArtiste) || empty($nomArtiste) || empty($prenomArtiste) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !date_valide($dateNaissanceArtiste) ) {
                $erreur = $messages['formulaire']['dateInvalide'];
                break;
            }
            $operationOk = modifier_artiste($db, $idArtiste, $nomArtiste, $prenomArtiste, $nomScene, $dateNaissanceArtiste,  $urlImageArtiste, $descriptionArtiste);
            if ( !$operationOk ) {
                $erreur = $erreur = $messages['operation']['ko']." (1)";
                break;
            }
            header('Location: ./gestionArtiste.php?action=modifierOk');
            break;

        case "supprimerArtiste":
            /*
             * Champs présent : idArtiste
             * Champs obligatoire : idArtiste
             */
            if ( !isset($idArtiste) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idArtiste) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            $operationOk = supprimer_artiste($db, $idArtiste);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (1)";
                break;
            }
            header('Location: ./gestionArtiste.php?action=supprimerOk');
            break;
            
        case "ajouterOk":
            $message = $messages['operation']['ok'];
            break;
            
        case "modifierOk":
            $message = $messages['operation']['ok'];
            break;
            
        case "supprimerOk":
            $message = $messages['operation']['ok'];
            break;
    }
}

?>