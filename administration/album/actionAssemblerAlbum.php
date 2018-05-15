<?php

$action = $_GET['action'];
$idAlbum = $_GET['idAlbum'];
if ( isset($action) && !empty($action) ) {
    $idMusique = $_GET['idMusique'];
    foreach($_GET as $key => $value) {
        if ( strstr($key, 'idMusique') ) {
            $listeIdMusique[] = (int) $value;
        }
    }
    $numeroPiste = $_GET['numeroPiste'];
}

if ( isset($db, $action) ) {
    switch($action) {
        case 'ajouterAssemblerAlbum':
            /*
             * Champs présent : idAlbum, idMusique, numeroPiste
             * Champs obligatoire : idAlbum, idMusique, numeroPiste
             */
            if ( !isset($idAlbum, $numeroPiste) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idAlbum) || empty($numeroPiste) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !isset($listeIdMusique[0]) || empty($listeIdMusique[0]) || sizeof($listeIdMusique) != 1 ) {
                $erreur = $messages['1titreMusique'];
                break;
            }
            if ( $numeroPiste < 0 ) {
                $erreur = $messages['formulaire']['valeurNegative'];
                break;
            }
            $operationOk = ajouter_assembler_album($db, $idAlbum, $listeIdMusique[0], $numeroPiste);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (1)";
                break;
            }
            header('Location: ./gestionAssemblerAlbum.php?idAlbum='.$idAlbum.'&action=ajouterOk');
            break;

        case 'modifierAssemblerAlbum':
            /*
             * Champs présent : idAlbum, idMusique, numeroPiste
             * Champs obligatoire : idAlbum, idMusique, numeroPiste
             */
            if ( !isset($idAlbum, $idMusique, $numeroPiste) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idAlbum) || empty($idMusique) || empty($numeroPiste) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( $numeroPiste < 0 ) {
                $erreur = $messages['formulaire']['valeurNegative'];
                break;
            }
            $operationOk = modifier_assembler_album($db, $idAlbum, $idMusique, $numeroPiste);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (1)";
                break;
            }
            header('Location: ./gestionAssemblerAlbum.php?idAlbum='.$idAlbum.'&action=modifierOk');
            break;

        case 'supprimerAssemblerAlbum':
            /*
             * Champs présent : idAlbum, idMusique
             * Champs obligatoire : idAlbum, idMusique
             */
            if ( !isset($idAlbum, $idMusique) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idAlbum) || empty($idMusique) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            $operationOk = supprimer_assembler_album($db, $idAlbum, $idMusique);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (1)";
                break;
            }
            header('Location: ./gestionAssemblerAlbum.php?idAlbum='.$idAlbum.'&action=supprimerOk');
            break;
            
        case "ajouterOk":
            $messages['operation']['ok'];
            break;
        
        case "modifierOk":
            $messages['operation']['ok'];
            break;
        
        case "supprimerOk":
            $messages['operation']['ok'];
            break;
            
    }
}

?>