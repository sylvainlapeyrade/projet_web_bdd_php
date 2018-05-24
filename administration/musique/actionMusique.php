<?php

/**
 * @file actionMusique.php
 * @brief Fait le lien entre le formulaire musique,
 * la gestion des musiques et la BDD
 */

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $idMusique = $_GET['idMusique'];
    $titreMusique = strtolower($_GET['titreMusique']);
    $dureeMusique = $_GET['dureeMusique'];
    $dateMusique = format_date($_GET['dateMusique']);
    $descriptionMusique = $_GET['descriptionMusique'];

    foreach($_GET as $key => $value) {
        if ( strstr($key, 'idArtiste') ) {
            $listeIdArtiste[] = (int) $value;
        } elseif ( strstr($key, 'idGroupe') ) {
            $listeIdGroupe[] = (int) $value;
        } elseif ( strstr($key, 'nomGenre') ) {
            $listeNomGenre[] = $value;
        }
    }
}

if ( isset($db, $action) && is_connect() && is_admin() ) {
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
            if ( !date_valide($dateMusique) ) {
                $erreur = $messages['formulaire']['dateInvalide'];
                break;
            }
            /* Il faut au minimum 1 artiste ou 1 groupe */
            if ( (!isset($listeIdArtiste[0]) || empty($listeIdArtiste[0])) && (!isset($listeIdGroupe[0]) || empty($listeIdGroupe[0])) ) {
                $erreur = $messages['minimum1ArtisteOuGroupe'];
                break;
            }
            $idMusique = ajouter_musique($db, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique);
            if ( $idMusique == null ) {
                supprimer_musique($db, $idMusique);
                $erreur = $messages['operation']['ko']. " (1)";
                break;
            }
            /* Ajout des artistes associés */
            if ( isset($listeIdArtiste) && !empty($listeIdArtiste) ) {
                $indiceListe = 0;
                do {
                    $idArtisteCoMu = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_composer_musique($db, $idMusique, $idArtisteCoMu);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    supprimer_musique($db, $idMusique);
                    $erreur = $messages['operation']['ko']. " (2)";
                    break;
                }
            }
            /* Ajout des groupes associés */
            if ( isset($listeIdGroupe) && !empty($listeIdGroupe) ) {
                $indiceListe = 0;
                do {
                    $idGroupeCoMr = (int) $listeIdGroupe[$indiceListe];
                    $operationOk = ajouter_composer_musiqueGr($db, $idMusique, $idGroupeCoMr);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdGroupe) );
                if ( !$operationOk ) {
                    supprimer_musique($db, $idMusique);
                    $erreur = $messages['operation']['ko']. " (3)";
                    break;
                }
            }
            /* Ajout des genres associés */
            if ( isset($listeNomGenre) && !empty($listeNomGenre) ) {
                $indiceListe = 0;
                do {
                    $nomGenre = $listeNomGenre[$indiceListe];
                    $operationGenreOk = ajouter_genre($db, $idMusique, $nomGenre);
                    $indiceListe++;
                } while ( $operationGenreOk && $indiceListe < sizeof($listeNomGenre) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (4)";
                    break;
                }
            }
            header('Location: ./gestionMusique.php?action=ajouterOk');
            break;

        case "modifierMusique":
            /*
             * Champs présent : idMusique, titreMusique, dureeMusique, dateMusique, descriptionMusique,
             * Champs obligatoire : idMusique, titreMusique, dureeMusique
             */
            if ( !isset($idMusique, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idMusique) || empty($titreMusique) || empty($dureeMusique) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !date_valide($dateMusique) ) {
                $erreur = $messages['formulaire']['dateInvalide'];
                break;
            }
            /* Il faut au minimum 1 artiste ou 1 groupe */
            if ( (!isset($listeIdArtiste[0]) || empty($listeIdArtiste[0])) && (!isset($listeIdGroupe[0]) || empty($listeIdGroupe[0])) ) {
                $erreur = $messages['minimum1ArtisteOuGroupe'];
                break;
            }
            $operationOk = modifier_musique($db, $idMusique, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko'] . " (1)";
                break;
            }
            $operationOk = supprimer_genre_tous($db, $idMusique);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko'] . " (2)";
                break;
            }
            $operationOk = supprimer_composer_musique_tous($db, $idMusique);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko'] . " (3)";
                break;
            }
            $operationOk = supprimer_composer_musiqueGr_tous($db, $idMusique);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko'] . " (4)";
                break;
            }
            /* Ajout des artistes associés */
            if ( isset($listeIdArtiste) && !empty($listeIdArtiste) ) {
                $indiceListe = 0;
                do {
                    $idArtisteCoMu = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_composer_musique($db, $idMusique, $idArtisteCoMu);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (5)";
                    break;
                }
            }
            /* Ajout des groupes associés */
            if ( isset($listeIdGroupe) && !empty($listeIdGroupe) ) {
                $indiceListe = 0;
                do {
                    $idGroupeCoMr = (int) $listeIdGroupe[$indiceListe];
                    $operationOk = ajouter_composer_musiqueGr($db, $idMusique, $idGroupeCoMr);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdGroupe) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (6)";
                    break;
                }
            }
            /* Ajout des genres associés */
            if ( isset($listeNomGenre) && !empty($listeNomGenre) ) {
                $indiceListe = 0;
                do {
                    $nomGenre = $listeNomGenre[$indiceListe];
                    $operationOk = ajouter_genre($db, $idMusique, $nomGenre);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeNomGenre) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. " (7)";
                    break;
                }
            }
            header('Location: ./gestionMusique.php?action=modifierOk');
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
            $operationOk = supprimer_musique($db, $idMusique);
            if ( !$operationOk ) {
                $erreur = $messages['operation']['ko']. " (1)";
                break;
            }
            header('Location: ./gestionMusique.php?action=supprimerOk');
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