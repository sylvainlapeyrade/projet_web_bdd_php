<?php

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
    $nomArtiste = $_GET['nomArtiste'];
    $prenomArtiste = $_GET['prenomArtiste'];
    $nomScene = $_GET['nomScene'];
    $dateNaissanceArtiste = $_GET['dateNaissanceArtiste'];
    $urlImageArtiste = $_GET['urlImageArtiste'];
    $descriptionArtiste = $_GET['descriptionArtiste'];
}

if ( isset($db) ) {
    switch($_GET['action']) {
        case "ajouterArtiste":
        /*
         * Champs présent : nomArtiste, prenomArtiste, nomScene, dateNaissanceArtiste, urlImageArtiste, descriptionArtiste
         * Champs obligatoire : nomArtiste, prenomArtiste
         */
        if ( isset($nomArtiste, $prenomArtiste, $nomScene, $dateNaissanceArtiste, $urlImageArtiste, $descriptionArtiste) ) {
            if ( isset($db) && !empty($nomArtiste) && !empty($prenomArtiste) ) {
                $operationOk = ajouter_artiste($db, $nomArtiste, $prenomArtiste, $nomScene, $dateNaissanceArtiste,  $urlImageArtiste, $descriptionArtiste);
                if ( $operationOk ) {
                    header('Location: ./gestionArtiste.php?operation=ok');
                } else {
                    $erreur = "L'opération n'a pas pu être exécuté.";
                }
            } else {
                $erreur = "Le nom et le prénom de l'artiste est obligatoire.";
            }
        } else {
            $erreur = "Le formulaire est incomplet.";
        }
        break;

        case "modifierArtiste":
        /*
         * champs présent : idArtiste, nomArtiste, prenomArtiste, nomScene, dateNaissanceArtiste, urlImageArtiste, descriptionArtiste
         * Champs obligatoire : idArtiste, nomArtiste, prenomArtiste
         */
        if ( isset($idArtiste, $nomArtiste, $prenomArtiste, $nomScene, $dateNaissanceArtiste, $urlImageArtiste, $descriptionArtiste) ) {
            if ( isset($db) && !empty($idArtiste) && !empty($nomArtiste) && !empty($prenomArtiste) ) {
            $operationOk = modifier_artiste($db, $idArtiste, $nomArtiste, $prenomArtiste, $nomScene, $dateNaissanceArtiste,  $urlImageArtiste, $descriptionArtiste);
                if ( $operationOk ) {
                    header('Location: ./gestionArtiste.php?operation=ok');
                } else {
                    $erreur = "L'opération n'a pas pu être exécuté.";
                }
            } else {
                $erreur = "Le nom et le prénom de l'artiste est obligatoire.";
            }
        } else {
            $erreur = "Le formulaire est incomplet.";
        }
        break;

        case "supprimerArtiste":
        /*
         * Champs présent : idArtiste
         * Champs obligatoire : idArtiste
         */
        if ( isset($db) && isset($idArtiste) ) {
            if ( !empty($idArtiste) ) {
                $operationOk = supprimer_artiste($db, $idArtiste);
                if ( $operationOk ) {
                    header('Location: ./gestionArtiste.php?operation=ok');
                } else {
                    $erreur = "L'opération n'a pas pu être exécuté.";
                }
            } else {
                $erreur = "L'identifiant de l'artiste doit être renseigné.";
            }
        } else {
            $erreur = "Le formulaire est incomplet.";
        }
        break;
    }
}

?>