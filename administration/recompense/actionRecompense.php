<?php

/**
 * @file actionRecompense.php
 * @brief Fait le lien entre le formulaire recompense,
 * la gestion des recompenses et la BDD
 */

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $idRecompense = $_GET['idRecompense'];
    $nomRecompense = strtolower($_GET['nomRecompense']);
    $dateRecompense = format_date($_GET['dateRecompense']);
    $descriptionRecompense = $_GET['descriptionRecompense'];

    foreach($_GET as $key => $value) {
        if ( strstr($key, 'idArtiste') ) {
            $listeIdArtiste[] = (int) $value;
        }
    }
}

if ( isset($db, $action) && is_connect() && is_admin() ) {
    switch($action) {
        case "ajouterRecompense":
            /*
             * Champs présent : nomRecompense, dateRecompense, descriptionRecompense, listeIdArtiste
             * Champs obligatoire : nomRecompense, dateRecompense, idArtiste1
             */
            if ( !isset($nomRecompense, $dateRecompense, $descriptionRecompense) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($nomRecompense) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !date_valide($dateRecompense) ) {
                $erreur = $messages['formulaire']['dateInvalide'];
                break;
            }
            if ( !isset($listeIdArtiste[0]) || empty($listeIdArtiste[0]) ) {
                $erreur = $messages['minimum1Artiste'];
                break;
            }
            $idRecompense = ajouter_recompense($db, $nomRecompense, $dateRecompense, $descriptionRecompense);
            if ( $idRecompense == null ) {
                $erreur = $messages['operation']['ko']." (1)";
                break;
            }
            if ( isset($listeIdArtiste) && !empty($listeIdArtiste) ) {
                $indiceListe = 0;
                do {
                    $idArtisteOa = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_obtenir_recompense($db, $idRecompense, $idArtisteOa);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. "(2)";
                    break;
                }
            }
            header('Location: ./gestionRecompense.php?action=ajouterOk');
            break;

        case "modifierRecompense":
            /*
             * Champs présent : idRecompense, nomRecompense, dateRecompense, descriptionRecompense, listeIdArtiste
             * Champs obligatoire : idRecompense, nomRecompense, dateRecompense, idArtiste1
             */
            if ( !isset($idRecompense, $nomRecompense, $dateRecompense, $descriptionRecompense) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idRecompense) || empty($nomRecompense) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !date_valide($dateRecompense) ) {
                $erreur = $messages['formulaire']['dateInvalide'];
                break;
            }
            if ( !isset($listeIdArtiste[0]) || empty($listeIdArtiste[0]) ) {
                $erreur = $messages['minimum1Artiste'];
                break;
            }
            $operationOk = modifier_recompense($db, $idRecompense, $nomRecompense, $dateRecompense, $descriptionRecompense);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (1)";
                break;
            }
            $operationOk = supprimer_obtenir_recompense_tous($db, $idRecompense);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (2)";
                break;
            }
            $indiceListe = 0;
            do {
                $idArtiste = (int) $listeIdArtiste[$indiceListe];
                $operationOk = ajouter_obtenir_recompense($db, $idRecompense, $idArtiste);
                $indiceListe++;
            } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (3)";
                break;
            }
            header('Location: ./gestionRecompense.php?action=modifierOk');
            break;

        case "supprimerRecompense":
            /*
             * Champs présent : idRecompense
             * Champs obligatoire : idRecompense
             */
            if ( !isset($idRecompense) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idRecompense) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            $operationOk = supprimer_obtenir_recompense_tous($db, $idRecompense);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (1)";
                break;
            }
            $operationOk = supprimer_recompense($db, $idRecompense);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (2)";
                break;
            }
            header('Location: ./gestionRecompense.php?action=supprimerOk');
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