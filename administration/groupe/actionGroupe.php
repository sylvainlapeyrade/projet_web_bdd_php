<?php

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $idGroupe = $_GET['idGroupe'];
    $nomGroupe = $_GET['nomGroupe'];
    $dateGroupe = $_GET['dateGroupe'];
    $descriptionGroupe = $_GET['descriptionGroupe'];
    $urlImageGroupe = $_GET['urlImageGroupe'];

    foreach($_GET as $key => $value) {
        if ( strstr($key, 'idArtiste') ) {
            $listeIdArtiste[] = (int) $value;
        }
    }
}

if ( isset($db) ) {
    switch($action) {
        case "ajouterGroupe":
            /*
             * Champs présent : nomGroupe, dateGroupe, descriptionGroupe, urlPochetteGroupe ,listeIdArtiste
             * Champs obligatoire : nomGroupe, dateGroupe, idArtiste1, idArtist2
             */
            if ( !isset($nomGroupe, $dateGroupe, $descriptionGroupe, $urlImageGroupe) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($nomGroupe) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !isset($listeIdArtiste[0], $listeIdArtiste[1]) || empty($listeIdArtiste[0]) || empty($listeIdArtiste[1]) ) {
                $erreur = $messages['minimum2Artiste'];
                break;
            }
            if ( isset($db) ) {
                $idGroupeCo = ajouter_groupe($db, $nomGroupe, $dateGroupe, $descriptionGroupe, $urlImageGroupe);
                if ( $idGroupeCo == null ) {
                    $erreur = $messages['operation']['ko']." (1)";
                    break;
                }
                $indiceListe = 0;
                do {
                    $idArtisteCo = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_constituer_groupe($db, $idGroupeCo, $idArtisteCo);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (2)";
                    break;
                }
                header('Location: ./gestionGroupe.php?operation=ok');
            }
            break;

        case "modifierGroupe":
            /*
             * Champs présent : idGroupe, nomGroupe, dateGroupe, descriptionGroupe, urlImageGroupe, listeIdArtiste
             * Champs obligatoire : idGroupe, nomGroupe, dateGroupe, idArtiste1
             */
            if ( !isset($idGroupe, $nomGroupe, $dateGroupe, $descriptionGroupe, $urlImageGroupe) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idGroupe) || empty($nomGroupe) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !isset($listeIdArtiste[0], $listeIdArtiste[1]) || empty($listeIdArtiste[0]) || empty($listeIdArtiste[1]) ) {
                $erreur = $messages['minimum2Artiste'];
                break;
            }
            if ( isset($db) ) {
                $operationOk = modifier_groupe($db, $idGroupe, $nomGroupe, $dateGroupe, $descriptionGroupe, $urlImageGroupe);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (1)";
                    break;
                }
                $operationOk = supprimer_constituer_groupe_tous($db, $idGroupe);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (2)";
                    break;
                }
                $indiceListe = 0;
                do {
                    $idArtiste = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_constituer_groupe($db, $idGroupe, $idArtiste);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (3)";
                    break;
                }
                header('Location: ./gestionGroupe.php?operation=ok');
            }
            break;

        case "supprimerGroupe":
            /*
             * Champs présent : idGroupe
             * Champs obligatoire : idGroupe
             */
            if ( !isset($db, $idGroupe) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idGroupe) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( isset($db) ) {
                $operationOk = supprimer_constituer_groupe_tous($db, $idGroupe);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (1)";
                }
                $operationOk = supprimer_groupe($db, $idGroupe);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (2)";
                }
                header('Location: ./gestionGroupe.php?operation=ok');
            }
    }
}

?>