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
        if ( isset($db, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique) ) {
            if ( !empty($titreMusique) && !empty($dureeMusique) ) {
                if ( isset($listeIdArtiste[0]) && !empty($listeIdArtiste[0]) ) {
                    $idMusique = ajouter_musique($db, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique);
                    if ( $idMusique != null ) {
                        $indiceListe = 0;
                        do {
                            $idArtisteCoMu = (int) $listeIdArtiste[$indiceListe];
                            $operationArtisteOk = ajouter_composer_musique($db, $idMusique, $idArtisteCoMu);
                            $indiceListe++;
                        } while ( $operationArtisteOk && $indiceListe < sizeof($listeIdArtiste) );
                        if ( $operationArtisteOk ) {
                            if ( isset($listeNomGenre) && !empty($listeNomGenre) ) {
                                $indiceListe = 0;
                                do {
                                    $nomGenre = $listeNomGenre[$indiceListe];
                                    $operationGenreOk = ajouter_genre($db, $idMusique, $nomGenre);
                                    $indiceListe++;
                                } while ( $operationGenreOk && $indiceListe < sizeof($listeNomGenre) );
                            }
                            header('Location: ./gestionMusique.php?operation=ok');
                        } else {
                            supprimer_musique($db, $idMusique);
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

        case "modifierMusique":
        /*
         * Champs présent : idMusique, titreMusique, dureeMusique, dateMusique, descriptionMusique,
         * Champs obligatoire : idMusique, titreMusique, dureeMusique
         */
        if ( isset($db, $idMusique, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique) ) {
            if ( !empty($idMusique) && !empty($titreMusique) && !empty($dureeMusique) ) {
                $operationOk = modifier_musique($db, $idMusique, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique);
                if ( $operationOk ) {
                    $operation2Ok = supprimer_genre_tous($db, $idMusique);
                    $operation3Ok = supprimer_composer_musique_tous($db, $idMusique);
                    if ( $operation2Ok && $operation3Ok ) {
                        $indiceListe = 0;
                        do {
                            $idArtisteCoMu = (int) $listeIdArtiste[$indiceListe];
                            $operationArtisteOk = ajouter_composer_musique($db, $idMusique, $idArtisteCoMu);
                            $indiceListe++;
                        } while ( $operationArtisteOk && $indiceListe < sizeof($listeIdArtiste) );
                        if ( $operationArtisteOk ) {
                            if ( isset($listeNomGenre) && !empty($listeNomGenre) ) {
                                $indiceListe = 0;
                                do {
                                    $nomGenre = $listeNomGenre[$indiceListe];
                                    $operationGenreOk = ajouter_genre($db, $idMusique, $nomGenre);
                                    $indiceListe++;
                                } while ( $operationGenreOk && $indiceListe < sizeof($listeNomGenre) );
                            }
                            header('Location: ./gestionMusique.php?operation=ok');
                        } else {
                            supprimer_musique($db, $idMusique);
                            $erreur = "L'opération 4 et 5 n'a pas pu être exécuté.";
                        }
                    } else {
                        $erreur = "L'opération 2 et 3 n'a pas pu être exécuté.";
                    }
                } else {
                    $erreur = "L'opération 1 n'a pas pu être exécuté.";
                }
            } else {
                $erreur = "Certains champs du formulaire sont vide.";
            }
        } else {
            $erreur = "Le formulaire n'est pas valide.";
        }
        break;

        case "supprimerMusique":
        /*
         * Champs présent : idMusique
         * Champs obligatoire : idMusique
         */
        if ( isset($db, $idMusique) ) {
            if ( !empty($idMusique) ) {
                $operation1Ok = supprimer_assembler_album_tous($db, $idMusique);
                $operation2Ok = supprimer_composer_musique_tous($db, $idMusique);
                $operation3Ok = supprimer_genre_tous($db, $idMusique);
                $operation4Ok = supprimer_musique($db, $idMusique);
                if ( $operation1Ok && $operation2Ok && $operation3Ok && $operation4Ok ) {
                    header('Location: ./gestionMusique.php?operation=ok');
                } else {
                    $erreur = "L'opération n'a pas pu être exécuté.";
                }
            } else {
                $erreur = "L'identifiant de de la musique doit être renseigné.";
            }
        } else {
            $erreur = "Le formulaire est incomplet.";
        }
        break;
    }
}

?>