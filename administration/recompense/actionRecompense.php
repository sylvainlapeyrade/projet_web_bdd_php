<?php

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $idRecompense = $_GET['idRecompense'];
    $nomRecompense = $_GET['nomRecompense'];
    $dateRecompense = $_GET['dateRecompense'];
    $descriptionRecompense = $_GET['descriptionRecompense'];

    foreach($_GET as $key => $value) {
        if ( strstr($key, 'idArtiste') ) {
            $listeIdArtiste[] = (int) $value;
        }
    }
}

if ( isset($db) ) {
    switch($action) {
        case "ajouterRecompense":
            /*
             * Champs présent : nomRecompense, dateRecompense, descriptionRecompense, listeIdArtiste
             * Champs obligatoire : nomRecompense, dateRecompense, idArtiste1
             */
            if ( !isset($nomRecompense, $dateRecompense, $descriptionRecompense) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($nomRecompense) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !isset($listeIdArtiste[0]) || empty($listeIdArtiste[0]) ) {
                $erreur = $messages['minimum1Artiste'];
                break;
            }
            if ( isset($db) ) {
                $idRecompenseOa = ajouter_recompense($db, $nomRecompense, $dateRecompense, $descriptionRecompense);
                if ( $idRecompenseOa == null ) {
                    $erreur = $messages['operation']['ko']." (1)";
                    break;
                }
                $indiceListe = 0;
                do {
                    $idArtisteOa = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_obtenir_recompense($db, $idRecompenseOa, $idArtisteOa);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']. "(2)";
                    break;
                }
                header('Location: ./gestionRecompense.php?operation=ok');
            }
            break;

        case "modifierRecompense":
            /*
             * Champs présent : idRecompense, nomRecompense, dateRecompense, descriptionRecompense, listeIdArtiste
             * Champs obligatoire : idRecompense, nomRecompense, dateRecompense, idArtiste1
             */
            if ( !isset($idRecompense, $nomRecompense, $dateRecompense, $descriptionRecompense) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idRecompense) || empty($nomRecompense) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( !isset($listeIdArtiste[0]) || empty($listeIdArtiste[0]) ) {
                $erreur = $messages['minimum1Artiste'];
                break;
            }
            if ( isset($db) ) {
                $operationOk = modifier_recompense($db, $idRecompense, $nomRecompense, $dateRecompense, $descriptionRecompense);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (1)";
                    break;
                }
                $operationOk = supprimer_obtenir_recompense_tous($db, $idRecompense);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (2)";
                    break;
                }
                $indiceListe = 0;
                do {
                    $idArtiste = (int) $listeIdArtiste[$indiceListe];
                    $operationOk = ajouter_obtenir_recompense($db, $idRecompense, $idArtiste);
                    $indiceListe++;
                } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (3)";
                    break;
                }
                header('Location: ./gestionRecompense.php?operation=ok');
            }
            break;

        case "supprimerRecompense":
            /*
             * Champs présent : idRecompense
             * Champs obligatoire : idRecompense
             */
            if ( !isset($idRecompense) ) {
                $erreur = $messages['formulaire']['invalide'];
                break;
            }
            if ( empty($idRecompense) ) {
                $erreur = $messages['formulaire']['champs_vide'];
                break;
            }
            if ( isset($db) ) {
                $operationOk = supprimer_obtenir_recompense_tous($db, $idRecompense);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (1)";
                    break;
                }
                $operationOk = supprimer_recompense($db, $idRecompense);
                if ( !$operationOk ) {
                    $erreur = $messages['operation']['ko']." (2)";
                    break;
                }
                header('Location: ./gestionRecompense.php?operation=ok');
            }
            break;
    }
}

?>