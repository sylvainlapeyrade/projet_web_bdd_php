<?php

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $idAlbum = $_GET['idAlbum'];
    $nomAlbum = $_GET['nomAlbum'];
    $dateAlbum = format_date($_GET['dateAlbum']);
    $descriptionAlbum = $_GET['descriptionAlbum'];
    $urlPochetteAlbum = $_GET['urlPochetteAlbum'];

    foreach($_GET as $key => $value) {
        if ( strstr($key, 'idArtiste') ) {
            $listeIdArtiste[] = (int) $value;
        } elseif ( strstr($key, 'idGroupe') ) {
            $listeIdGroupe[] = (int) $value;
        }
    }
}

if ( isset($db, $action) ) {
    switch($action) {
        case "ajouterAlbum":
            /*
             * Champs présent : nomAlbum, dateAlbum, descriptionAlbum, urlPochetteAlbum ,listeIdAlbum
             * Champs obligatoire : nomAlbum, dateAlbum, idArtiste1
             */
            if ( !isset($nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($nomAlbum) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !date_valide($dateAlbum) ) {
                $erreur = $messages['formulaire']['dateInvalide'];
                break;
            }
            /* Il faut au minimum 1 artiste ou 1 groupe */
            if ( (!isset($listeIdArtiste[0]) || empty($listeIdArtiste[0])) && (!isset($listeIdGroupe[0]) || empty($listeIdGroupe[0])) ) {
                $erreur = $messages['minimum1ArtisteOuGroupe'];
                break;
            }
            $idAlbumCoAl = ajouter_album($db, $nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum);
            if ( $idAlbumCoAl == null ) {
                $erreur = $messages['operation']['ko']." (1)";
                break;
            }
            /* Ajout des artistes associés */
            if ( isset($listeIdArtiste) && !empty($listeIdArtiste) ) {
                $indiceListe = 0;
                do {
                    $idArtisteCoAl = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_composer_album($db, $idAlbum, $idArtisteCoAl);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (2)";
                    break;
                }
            }
            /* Ajout des groupes associés */
            if ( isset($listeIdGroupe) && !empty($listeIdGroupe) ) {
                $indiceListe = 0;
                do {
                    $idGroupeCoAr = (int) $listeIdGroupe[$indiceListe];
                    $operationOk = ajouter_composer_albumGr($db, $idAlbum, $idGroupeCoAr);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdGroupe) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (3)";
                    break;
                }
            }
            header('Location: ./gestionAlbum.php?action=ajouterOk');
            break;

        case "modifierAlbum":
            /*
             * Champs présent : idAlbum, nomAlbum, dateAlbum, descriptionAlbum, urlImageAlbum, listeIdArtiste
             * Champs obligatoire : idAlbum, nomAlbum, dateAlbum, idArtiste1
             */
            if ( !isset($idAlbum, $nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idAlbum) || empty($nomAlbum) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !date_valide($dateAlbum) ) {
                $erreur = $messages['formulaire']['dateInvalide'];
                break;
            }
            if ( (!isset($listeIdArtiste[0]) || empty($listeIdArtiste[0])) && (!isset($listeIdGroupe[0]) || empty($listeIdGroupe[0])) ) {
                $erreur = $messages['minimum1ArtisteOuGroupe'];
                break;
            }
            $operationOk = modifier_album($db, $idAlbum, $nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (1)";
                break;
            }
            $operationOk = supprimer_composer_album_tous($db, $idAlbum);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (2)";
                break;
            }
            $operationOk = supprimer_composer_albumGr_tous($db, $idAlbum);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']." (3)";
                break;
            }
            /* Ajout des artistes associés */
            if ( isset($listeIdArtiste) && !empty($listeIdArtiste) ) {
                $indiceListe = 0;
                do {
                    $idArtisteCoAl = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_composer_album($db, $idAlbum, $idArtisteCoAl);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (4)";
                    break;
                }
            }
            /* Ajout des groupes associés */
            if ( isset($listeIdGroupe) && !empty($listeIdGroupe) ) {
                $indiceListe = 0;
                do {
                    $idGroupeCoAr = (int) $listeIdGroupe[$indiceListe];
                    $operationOk = ajouter_composer_albumGr($db, $idAlbum, $idGroupeCoAr);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdGroupe) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (5)";
                    break;
                }
            }
            header('Location: ./gestionAlbum.php?action=modifierOk');
            break;

        case "supprimerAlbum":
            /*
             * Champs présent : idAlbum
             * Champs obligatoire : idAlbum
             */
            if ( !isset($idAlbum) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idAlbum) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            $operationOk = supprimer_album($db, $idAlbum);
            if ( !$operationOk ) {
                $erreur = $erreur = $messages['operation']['ko']." (1)";
                break;
            }
            header('Location: ./gestionAlbum.php?action=supprimerOk');
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