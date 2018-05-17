<?php

$action = $_GET['action'];
$note = $_GET['star'];
if ( !isset($note) || empty($note) || $note < 0 ||$note > 5 ) {
    $note = 0;
}
if ( isset($action) ) {
    $idUtilisateur = $_GET['idUtilisateur'];
    $note = $_GET['note'];
    $commentaire = $_GET['commentaire'];
}

if ( isset($db, $action) ) {
    switch($action) {
        case 'ajouterEvaluationAlbum':
            /*
             * Champs présent : idAlbum, note, commentaire
             * Champs obligatoire : idAlbum, note, commentaire
             */
            if ( !isset($idAlbum, $note, $commentaire) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idAlbum) || empty($commentaire) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( $note < 1 || $note > 5 ) {
                $erreur = $messages['formulaire']['noteIncorrect'];
                break;
            }
            $operationOk = ajouter_evaluation_album($db, $_SESSION['idUtilisateur'], $idAlbum, $note, $commentaire);
            if ( !$operationOk ) {
                $erreur = $messages['formulaire']['evaluationExistant'];
                break;
            }
            header('Location: /album.php?idAlbum='.$idAlbum.'&action=ajouterOk');
            break;
                
        case 'ajouterEvaluationMusique':
            /*
             * Champs présent : idMusique, note, commentaire
             * Champs obligatoire : idMusique, note, commentaire
             */
            if ( !isset($idMusique, $note, $commentaire) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idMusique) || empty($commentaire) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( $note < 1 || $note > 5 ) {
                $erreur = $messages['formulaire']['noteIncorrect'];
                break;
            }
            $operationOk = ajouter_evaluation_musique($db, $_SESSION['idUtilisateur'], $idMusique, $note, $commentaire);
            if ( !$operationOk ) {
                $erreur = $messages['formulaire']['evaluationExistant'];
                break;
            }
            header('Location: /musique.php?idMusique='.$idMusique.'&action=ajouterOk');
            break;
            
        case 'supprimerEvaluationAlbum':
            /*
             * Champs présent : idAlbum, $idUtilisateur
             * Champs obligatoire : idAlbum, $idUtilisateur
             */
            if ( !isset($idAlbum, $idUtilisateur) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idAlbum) || empty($idUtilisateur) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !is_admin() ) {
                if ($idUtilisateur != $_SESSION['idUtilisateur'] ) {
                    $erreur = $messages['formulaire']['nonAutoriser'];
                    break;
                }
            }
            $operationOk = supprimer_evaluation_album($db, $idUtilisateur, $idAlbum);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko'];
                break;
            }
            header('Location: /album.php?idAlbum='.$idAlbum.'&action=supprimerOk');
            break;
            
        case 'supprimerEvaluationMusique':
            /*
             * Champs présent : idMusique, $idUtilisateur
             * Champs obligatoire : idMusique, $idUtilisateur
             */
            if ( !isset($idMusique, $idUtilisateur) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idMusique) || empty($idUtilisateur) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !is_admin() ) {
                if ($idUtilisateur != $_SESSION['idUtilisateur'] ) {
                    $erreur = $messages['formulaire']['nonAutoriser'];
                    break;
                }
            }
            $operationOk = supprimer_evaluation_musique($db, $idUtilisateur, $idMusique);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko'];
                break;
            }
            header('Location: /musique.php?idMusique='.$idMusique.'&action=supprimerOk');
            break;
            
        case 'ajouterOk':
            $message = $messages['operation']['ok'];
            break;
            
        case 'supprimerOk':
            $message = $messages['operation']['ok'];
            break;
    }
}


?>