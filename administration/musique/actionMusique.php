<?php

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $idMusique = $_GET['idMusique'];
    $titreMusique = $_GET['titreMusique'];
    $dureeMusique = $_GET['dureeMusique'];
    $dateMusique = $_GET['dateMusique'];
    $descriptionMusique = $_GET['descriptionMusique'];
    
    foreach($_GET as $key => $value) {
        if ( strstr($key, 'idArtiste') ) {
            $listeIdArtiste[] = (int) $value;
        } elseif ( strstr($key, 'nomGenre') ) {
            $listeNomGenre[] = $value;
        }
    }
}

if ( isset($db) ) {
    switch($action) {
        case "ajouterMusique":
            /*
             * Champs présent : titreMusique, dureeMusique, dateMusique, descriptionMusique
             * Champs obligatoire : titreMusique, dureeMusique, dateMusique, idArtiste1
             */
            if ( !isset($titreMusique, $dureeMusique, $dateMusique, $descriptionMusique) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($titreMusique) || empty($dureeMusique) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !isset($listeIdArtiste[0]) || empty($listeIdArtiste[0]) ) {
                $erreur = $messages['minimum1Artiste'];
                break;
            }
            if ( isset($db) ) {
                $idMusique = ajouter_musique($db, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique);
                if ( $idMusique == null ) {
                    $erreur = $messages['operation']['ko']. " (1)";
                    break;
                }
                $indiceListe = 0;
                do {
                    $idArtisteCoMu = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_composer_musique($db, $idMusique, $idArtisteCoMu);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (2)";
                    break;
                }
                if ( isset($listeNomGenre) && !empty($listeNomGenre) ) {
                    $indiceListe = 0;
                    do {
                        $nomGenre = $listeNomGenre[$indiceListe];
                        $operationGenreOk = ajouter_genre($db, $idMusique, $nomGenre);
                        $indiceListe++;
                    } while ( $operationGenreOk && $indiceListe < sizeof($listeNomGenre) );
                    if ( !$operationOk ) {
                        $erreur = $messages['operation']['ko']. " (3)";
                        break;
                    }
                }
                header('Location: ./gestionMusique.php?operation=ok');
            }
            break;

        case "modifierMusique":
            /*
             * Champs présent : idMusique, titreMusique, dureeMusique, dateMusique, descriptionMusique,
             * Champs obligatoire : idMusique, titreMusique, dureeMusique
             */
            if ( isset($idMusique, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( !empty($idMusique) && !empty($titreMusique) && !empty($dureeMusique) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( isset($db) ) {
                $operationOk = modifier_musique($db, $idMusique, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (1)";
                    break;
                }
                $operationOk = supprimer_genre_tous($db, $idMusique);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (2)";
                    break;
                }
                $operationOk = supprimer_composer_musique_tous($db, $idMusique);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (3)";
                    break;
                }
                $indiceListe = 0;
                do {
                    $idArtisteCoMu = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_composer_musique($db, $idMusique, $idArtisteCoMu);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (4)";
                    break;
                }
                if ( isset($listeNomGenre) && !empty($listeNomGenre) ) {
                    $indiceListe = 0;
                    do {
                        $nomGenre = $listeNomGenre[$indiceListe];
                        $operationOk = ajouter_genre($db, $idMusique, $nomGenre);
                        $indiceListe++;
                    } while ( $operationOk && $indiceListe < sizeof($listeNomGenre) );
                    if ( !$operationOk ) {
                        $erreur = $messages['operation']['ko']. " (5)";
                        break;
                    }
                }
                header('Location: ./gestionMusique.php?operation=ok');
            }
        break;

        case "supprimerMusique":
            /*
             * Champs présent : idMusique
             * Champs obligatoire : idMusique
             */
            if ( !isset($idMusique) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idMusique) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( isset($db) ) {
                $operationOk = supprimer_assembler_album_tous($db, $idMusique);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (1)";
                    break;
                }
                $operationOk = supprimer_composer_musique_tous($db, $idMusique);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (2)";
                    break;
                }
                $operationOk = supprimer_genre_tous($db, $idMusique);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (3)";
                    break;
                }
                $operationOk = supprimer_musique($db, $idMusique);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (4)";
                    break;
                }
                header('Location: ./gestionMusique.php?operation=ok');
            }
            break;
    }
}

?>