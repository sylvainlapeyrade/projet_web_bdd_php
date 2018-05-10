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
        if ( isset($db, $nomRecompense, $dateRecompense, $descriptionRecompense) ) {
            if ( !empty($nomRecompense) ) {
                if ( isset($listeIdArtiste[0]) && !empty($listeIdArtiste[0]) ) {
                    $idRecompenseOa = ajouter_recompense($db, $nomRecompense, $dateRecompense, $descriptionRecompense);
                    if ( $idRecompenseOa != null ) {
                        $indiceListe = 0;
                        do {
                            $idArtisteOa = (int) $listeIdArtiste[$indiceListe];
                            $operationOk = ajouter_obtenir_recompense($db, $idRecompenseOa, $idArtisteOa);
                            $indiceListe++;
                        } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                        if ( $operationOk ) {
                            header('Location: ./gestionRecompense.php?operation=ok');
                        } else {
                            supprimer_recompense($db, $idRecompenseOa);
                            $erreur = $messages['operation']['ko'];
                        }
                    } else { $erreur = $messages['operation']['ko']; }
                } else { $erreur = $messages['minimum1Artiste']; }
            } else { $erreur = $messages['formulaire']['champs_vide']; }
        } else { $erreur = $messages['formulaire']['invalide']; }
        break;

        case "modifierRecompense":
        /*
         * Champs présent : idRecompense, nomRecompense, dateRecompense, descriptionRecompense, listeIdArtiste
         * Champs obligatoire : idRecompense, nomRecompense, dateRecompense, idArtiste1
         */
        if ( isset($db, $idRecompense, $nomRecompense, $dateRecompense, $descriptionRecompense) ) {
            if ( !empty($idRecompense) && !empty($nomRecompense) ) {
                if ( isset($listeIdArtiste[0]) && !empty($listeIdArtiste[0]) ) {
                    $operationOk = modifier_recompense($db, $idRecompense, $nomRecompense, $dateRecompense, $descriptionRecompense);
                    if ( $operationOk ) {
                        $operationOk = supprimer_obtenir_recompense_tous($db, $idRecompense);
                        if ( $operationOk ) {
                            $indiceListe = 0;
                            do {
                                $idArtiste = (int) $listeIdArtiste[$indiceListe];
                                $operationOk = ajouter_obtenir_recompense($db, $idRecompense, $idArtiste);
                                $indiceListe++;
                            } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
                            if ( $operationOk ) {
                                header('Location: ./gestionRecompense.php?operation=ok');
                            } else {
                                supprimer_recompense($db, $idRecompense);
                                $erreur = $messages['operation']['ko'];
                            }
                        } else { $erreur = $messages['operation']['ko']; }
                    } else { $erreur = $messages['operation']['ko']; }
                } else { $erreur = $messages['minimum1Artiste']; }
            } else { $erreur = $messages['formulaire']['champs_vide']; }
        } else { $erreur = $messages['formulaire']['invalide']; }
        break;

        case "supprimerRecompense":
        /*
        * Champs présent : idRecompense
        * Champs obligatoire : idRecompense
        */
        if ( isset($db, $idRecompense) ) {
            if ( !empty($idRecompense) ) {
                $operationOk = supprimer_obtenir_recompense_tous($db, $idRecompense);
                if ( $operationOk ) {
                    $operationOk = supprimer_recompense($db, $idRecompense);
                    if ( $operationOk ) {
                        header('Location: ./gestionRecompense.php?operation=ok');
                    } else { $erreur = $erreur = $messages['operation']['ko']; }
                } else { $erreur = $erreur = $messages['operation']['ko']; }
            } else { $erreur = $messages['formulaire']['champs_vide']; }
        } else { $erreur = $messages['formulaire']['invalide']; }
        break;
    }
}

?>