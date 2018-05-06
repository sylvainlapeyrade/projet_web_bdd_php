<?php

$action = $_GET['action'];
if ( isset($action) && !empty($action) ) {
  $idMusique = $_GET['idMusique'];
  $titreMusique = $_GET['titreMusique'];
  $dureeMusique = $_GET['dureeMusique'];
  $dateMusique = $_GET['dateMusique'];
  $descriptionMusique = $_GET['descriptionMusique'];
}

$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

switch($action) {
  case "ajouterMusique":
    /*
     * Champs présent : titreMusique, dureeMusique, dateMusique, descriptionMusique
     * Champs obligatoire : titreMusique, dureeMusique, dateMusique
     * On vérifie tout les champs
     */
    if ( isset($titreMusique, $dureeMusique, $dateMusique, $descriptionMusique) ) {
      if ( !empty($titreMusique) && !empty($dureeMusique) ) {
        $operationOk = ajouter_musique($db, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique);
        if ( $operationOk ) {
          header('Location: ./gestionMusique.php?operation=ok');
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
    
  case "modifierMusique":
    /*
     * Champs présent : idMusique, titreMusique, dureeMusique, dateMusique, descriptionMusique,
     * Champs obligatoire : idMusique, titreMusique, dureeMusique
     */
    if ( isset($idMusique, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique) ) {
      if ( !empty($idMusique) && !empty($titreMusique) && !empty($dureeMusique) ) {
        $operationOk = modifier_musique($db, $idMusique, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique);
        if ( $operationOk ) {
          header('Location: ./gestionMusique.php?operation=ok');
        } else {
          $erreur = "L'opération 1  n'a pas pu être éxécuté.";
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
     * On vérifie tout les champs
     */
    if ( isset($idMusique) ) {
      if ( !empty($idMusique) ) {
        $operationOk = supprimer_musique($db, $idMusique);
        if ( operationOk ) {
            header('Location: ./gestionMusique.php?operation=ok');
        } else {
          $erreur = "L'opération 1 n'a pas pu être exécuté.";
        }
      } else {
        $erreur = "L'identifiant de de la musique doit être renseigné.";
      }
    } else {
      $erreur = "Le formulaire est incomplet.";
    }
    break;
}

?>