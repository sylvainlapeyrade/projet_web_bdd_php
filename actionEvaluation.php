<?php

$action = $_GET['action'];
if ( isset($action) ) {
    $idUtilisateur = $_GET['idUtilisateur'];
    $note = $_GET['note'];
    $commentaire = $_GET['commentaire'];
}
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

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
                header('Location: /album.php?idAlbum='.$idAlbum.'&operation=ok');
            } elseif ( isset($idMusique) ) {
                $operationOk = ajouter_evaluation_musique($db, $_SESSION['idUtilisateur'], $idMusique, $note, $commentaire);
                if ( !$operationOk ) {
                    $erreur = "Vous avez déjà évaluer cette musique.";
                    break;
                }
                header('Location: /musique.php?idMusique='.$idMusique.'&operation=ok');
            }
            break;
            
        case 'supprimerEvaluation':
            /*
             * Champs présent : idAlbum ou idMusique, $idUtilisateur
             * Champs obligatoire : idAlbum ou idMusique, $idUtilisateur
             */
            if ( !(isset($idAlbum) || isset($idMusique)) ) {
                $erreur = "Erreur...";
                break;
            }
            if ( (empty($idAlbum) && empty($idMusique)) ) {
                $erreur = "Erreur vide...";
                break;
            }
            if ( !is_admin() ) {
                if ($idUtilisateur != $_SESSION['idUtilisateur'] ) {
                    $erreur = "Vous n'avez pas l'autorisation de supprimer ce commentaire.";
                    break;
                }
            }
            if ( isset($idAlbum) ) {
                $operationOk = supprimer_evalution_album($db, $idUtilisateur, $idAlbum);
                if ( !$operationOk ) {
                    $erreur = "Une erreur c'est produite....";
                    break;
                }
                header('Location: /album.php?idAlbum='.$idAlbum.'&operation=ok');
            } elseif ( isset($idMusique) ) {
                $operationOk = supprimer_evaluation_musique($db, $idUtilisateur, $idMusique);
                if ( !$operationOk ) {
                    $erreur = "Une erreur c'est produite....";
                    break;
                }
                //header('Location: /musique.php?idMusique='.$idMusique.'&operation=ok');
            }
            break;
    }
}


?>