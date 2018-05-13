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
        }
    }
}

if ( isset($db) ) {
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
            if ( !isset($listeIdArtiste[0]) || empty($listeIdArtiste[0]) ) {
                $erreur = $messages['minimum1Artiste'];
                break;
            }
            if ( isset($db) ) {
                $idAlbumCoAl = ajouter_album($db, $nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum);
                if ( $idAlbumCoAl == null ) {
                    $erreur = $messages['operation']['ko']." (1)";
                    break;
                }
                $indiceListe = 0;
                do {
                    $idArtisteCoAl = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_composer_album($db, $idAlbumCoAl, $idArtisteCoAl);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (2)";
                    break;
                }
                header('Location: ./gestionAlbum.php?operation=ok');
            }
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
            if ( !isset($listeIdArtiste[0]) || empty($listeIdArtiste[0]) ) {
                $erreur = $messages['minimum1Artiste'];
                break;
            }
            if ( isset($db) ) {
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
                $indiceListe = 0;
                do {
                    $idArtiste = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_composer_album($db, $idAlbum, $idArtiste);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (3)";
                    break;
                }
                header('Location: ./gestionAlbum.php?operation=ok');
            }
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
            if ( isset($db) ) {
                $operationOk = supprimer_composer_album_tous($db, $idAlbum);
                if ( !$operationOk ) {
                    $erreur = $erreur = $messages['operation']['ko']." (1)";
                    break;
                }
                $operationOk = supprimer_album($db, $idAlbum);
                if ( !$operationOk ) {
                    $erreur = $erreur = $messages['operation']['ko']." (2)";
                    break;
                }
                header('Location: ./gestionAlbum.php?operation=ok');
            }
            break;
    }
}

?>