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

$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

switch($action) {
  case "ajouterGroupe":
    /*
     * Champs présent : nomGroupe, dateGroupe, descriptionGroupe, urlPochetteGroupe ,listeIdArtiste
     * Champs obligatoire : nomGroupe, dateGroupe, idArtiste1, idArtist2
     * On vérifie tout les champs
     */
    if ( isset($nomGroupe, $dateGroupe, $descriptionGroupe, $urlImageGroupe) ) {
      if ( !empty($nomGroupe) ) {
        if ( isset($listeIdArtiste[0], $listeIdArtiste[1]) && !empty($listeIdArtiste[0]) && !empty($listeIdArtiste[1]) ) {
          $idGroupeCo = ajouter_groupe($db, $nomGroupe, $dateGroupe, $descriptionGroupe, $urlImageGroupe);
          if ( $idGroupeCo != null ) {
            $indiceListe = 0;
            do {
              $idArtisteCo = (int) $listeIdArtiste[$indiceListe];
              $operationOk = ajouter_constituer_groupe($db, $idGroupeCo, $idArtisteCo);
              $indiceListe++;
            } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
            if ( $operationOk ) {
              header('Location: ./gestionGroupe.php?operation=ok');
            } else {
              supprimer_groupe($db, $idGroupeCo);
              $erreur = "L'opération 2 n'a pas pu être exécuté.";
            }
          } else {
            $erreur = "L'opération 1 n'a pas pu être exécuté.";
          }
        } else {
          $erreur = "Il faut au minimum deux artistes sélectionné.";
        }
      } else {
        $erreur = "Certains champs du formulaire sont vide.";
      }
    } else {
      $erreur = "Le formulaire n'est pas valide.";
    }
    break;
    
  case "modifierGroupe":
    /*
     * Champs présent : idGroupe, nomGroupe, dateGroupe, descriptionGroupe,
     * urlImageGroupe, listeIdArtiste
     * Champs obligatoire : idGroupe, nomGroupe, dateGroupe, idArtiste1
     */
    if ( isset($idGroupe, $nomGroupe, $dateGroupe, $descriptionGroupe, $urlImageGroupe) ) {
      if ( !empty($idGroupe) && !empty($nomGroupe) ) {
        if ( isset($listeIdArtiste[0], $listeIdArtiste[1]) && !empty($listeIdArtiste[0]) && !empty($listeIdArtiste[1]) ) {
          $operationOk = modifier_groupe($db, $idGroupe, $nomGroupe, $dateGroupe, $descriptionGroupe, $urlImageGroupe);
          if ( $operationOk ) {
            $operationOk = supprimer_constituer_groupe_tous($db, $idGroupe);
            if ( $operationOk ) {
              $indiceListe = 0;
              do {
                $idArtiste = (int) $listeIdArtiste[$indiceListe];
                $operationOk = ajouter_constituer_groupe($db, $idGroupe, $idArtiste);
                $indiceListe++;
              } while ( $operationOk && $indiceListe < sizeof($listeIdArtiste) );
              if ( $operationOk ) {
                header('Location: ./gestionGroupe.php?operation=ok');
              } else {
                supprimer_groupe($db, $iGroupe);
                $erreur = "L'opération 3 n'a pas pu être exécuté.";
              }
            } else {
              $erreur = "L'opération 2 n'a pas pu être exécuté.";
            }
          } else {
            $erreur = "L'opération 1  n'a pas pu être éxécuté.";
          }
        } else {
          $erreur = "Il faut au minimum deux artistes sélectionné.";
        }
      } else {
        $erreur = "Certains champs du formulaire sont vide.";
      }
    } else {
      $erreur = "Le formulaire n'est pas valide.";
    }
    break;
    
  case "supprimerGroupe":
    /*
     * Champs présent : idGroupe
     * Champs obligatoire : idGroupe
     * On vérifie tout les champs
     */
    if ( isset($idGroupe) ) {
      if ( !empty($idGroupe) ) {
        $operationOk = supprimer_constituer_groupe_tous($db, $idGroupe);
        if ( operationOk ) {
          $operationOk = supprimer_groupe($db, $idGroupe);
          if ( $operationOk ) {
            header('Location: ./gestionGroupe.php?operation=ok');
          } else {
            $erreur = "L'opération 2 n'a pas pu être exécuté.";
          }
        } else {
          $erreur = "L'opération 1 n'a pas pu être exécuté.";
        }
      } else {
        $erreur = "L'identifiant de la récompense doit être renseigné.";
      }
    } else {
      $erreur = "Le formulaire est incomplet.";
    }
    break;
}

?>