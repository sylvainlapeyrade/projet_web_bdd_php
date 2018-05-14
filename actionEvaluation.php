<?php

$action = $_GET['action'];
if ( isset($action) ) {
    $note = $_GET['note'];
    $commentaire = $_GET['commentaire'];
}

if ( isset($db, $action) ) {
    switch($action) {
        case 'ajouterEvaluation':
            /*
             * Champs présent : idAlbum ou idMusique, note, commentaire
             * Champs obligatoire : idAlbum ou idMusique, note, commentaire
             */
            if ( !(isset($idAlbum) || isset($idMusique)) || !isset($note, $commentaire) ) {
                $erreur = "Erreur...";
                break;
            }
            if ( (empty($idAlbum) && empty($idMusique)) || empty($commentaire) ) {
                $erreur = "Erreur vide...";
                break;
            }
            if ( $note < 1 || $note > 5 ) {
                $erreur = "La note doit être compris entre 1 et 5";
                break;
            }
            if ( isset($idAlbum) ) {
                $operationOk = ajouter_evaluation_album($db, $_SESSION['idUtilisateur'], $idAlbum, $note, $commentaire);
                if ( !$operationOk ) {
                    $erreur = "Vous avez déjà évaluer cette album.";
                    break;
                }
                header('Location: /album.php?idAlbum='.$idAlbum.'&operation=Ok');
            } elseif ( isset($idMusique) ) {
                $operationOk = ajouter_evaluation_musique($db, $_SESSION['idUtilisateur'], $idMusique, $note, $commentaire);
                if ( !$operationOk ) {
                    $erreur = "Vous avez déjà évaluer cette musique.";
                    break;
                }
                header('Location: /musique.php?idMusique='.$idMusique.'&operation=Ok');
            }
            break;
            
        case 'supprimerEvaluation':
            break;
    }
}


?>