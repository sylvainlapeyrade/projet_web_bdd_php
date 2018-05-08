<?php

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $idAlbum = $_GET['idAlbum'];
    $nomAlbum = $_GET['nomAlbum'];
    $dateAlbum = $_GET['dateAlbum'];
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
            if ( isset($nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum) ) {
                if ( !empty($nomAlbum) ) {
                    if ( isset($listeIdArtiste[0]) && !empty($listeIdArtiste[0]) ) {
                        $idAlbumCoAl = ajouter_album($db, $nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum);
                        if ( $idAlbumCoAl != null ) {
                            $indiceListe = 0;
                            do {
                                $idArtisteCoAl = (int) $listeIdArtiste[$indiceListe];
                                $operationOk = ajouter_composer_album($db, $idAlbumCoAl, $idArtisteCoAl);
                                $indiceListe++;
                            } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                            if ( $operationOk ) {
                                header('Location: ./gestionAlbum.php?operation=ok');
                            } else {
                                supprimer_album($db, $idAlbumCoAl);
                                $erreur = "L'opération 2 n'a pas pu être exécuté.";
                            }
                        } else {
                            $erreur = "L'opération 1 n'a pas pu être exécuté.";
                        }
                    } else {
                        $erreur = "Il faut au minimum un artiste sélectionné.";
                    }
                } else {
                    $erreur = "Certains champs du formulaire sont vide.";
                }
            } else {
                $erreur = "Le formulaire n'est pas valide.";
            }
            break;

        case "modifierAlbum":
            /*
             * Champs présent : idAlbum, nomAlbum, dateAlbum, descriptionAlbum, urlImageAlbum, listeIdArtiste
             * Champs obligatoire : idAlbum, nomAlbum, dateAlbum, idArtiste1
             */
            if ( isset($idAlbum, $nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum) ) {
                if ( !empty($idAlbum) && !empty($nomAlbum) ) {
                    if ( isset($listeIdArtiste[0]) && !empty($listeIdArtiste[0]) ) {
                        $operationOk = modifier_album($db, $idAlbum, $nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum);
                        if ( $operationOk ) {
                            $operationOk = supprimer_composer_album_tous($db, $idAlbum);
                            if ( $operationOk ) {
                                $indiceListe = 0;
                                do {
                                    $idArtiste = (int) $listeIdArtiste[$indiceListe];
                                    $operationOk = ajouter_composer_album($db, $idAlbum, $idArtiste);
                                    $indiceListe++;
                                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                                if ( $operationOk ) {
                                    header('Location: ./gestionAlbum.php?operation=ok');
                                } else {
                                    supprimer_album($db, $idAlbum);
                                    $erreur = "L'opération 3 n'a pas pu être exécuté.";
                                }
                            } else {
                                $erreur = "L'opération 2 n'a pas pu être exécuté.";
                            }
                        } else {
                            $erreur = "L'opération 1  n'a pas pu être éxécuté.";
                        }
                    } else {
                        $erreur = "Il faut au minimum un artiste sélectionné.";
                    }
                } else {
                    $erreur = "Certains champs du formulaire sont vide.";
                }
            } else {
                $erreur = "Le formulaire n'est pas valide.";
            }
            break;

        case "supprimerAlbum":
            /*
             * Champs présent : idAlbum
             * Champs obligatoire : idAlbum
             */
            if ( isset($idAlbum) ) {
                if ( !empty($idAlbum) ) {
                    $operationOk = supprimer_composer_album_tous($db, $idAlbum);
                    if ( $operationOk ) {
                        $operationOk = supprimer_album($db, $idAlbum);
                        if ( $operationOk ) {
                            header('Location: ./gestionAlbum.php?operation=ok');
                        } else {
                            $erreur = "L'opération 2 n'a pas pu être exécuté.";
                        }
                    } else {
                        $erreur = "L'opération 1 n'a pas pu être exécuté.";
                    }
                } else {
                    $erreur = "L'identifiant de l'album doit être renseigné.";
                }
            } else {
                $erreur = "Le formulaire est incomplet.";
            }
            break;
    }
}

?>