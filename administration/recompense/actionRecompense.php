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

switch($action) {
  case "ajouterRecompense":
    /*
     * Champs présent : nomRecompense, dateRecompense, descriptionRecompense, listeIdArtiste
     * Champs obligatoire : nomRecompense, dateRecompense, idArtiste1
     * On vérifie tout les champs
     * On ajoute la récompense en récupérant l'identifiant.
     * On ajoute les liens entre les entités Recompense et Artiste.
     * Si ce dernier échoue, on supprime la récompense crée.
     */
    if ( isset($nomRecompense, $dateRecompense, $descriptionRecompense) ) {
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
    
  case "modifierRecompense":
    /*
     * Champs présent : idRecompense, nomRecompense, dateRecompense, descriptionRecompense,
     * listeIdArtiste
     * Champs obligatoire : idRecompense, nomRecompense, dateRecompense, idArtiste1
     * On vérifie tout les champs
     * On modifie la récompense.
     * On supprime tout les liens entre Récompense et Artiste
     * On ajoute les nouveau liens entre les deux entités.
     */
    if ( isset($idRecompense, $nomRecompense, $dateRecompense, $descriptionRecompense) ) {
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
                supprimer_recompense($db, $idRecompenseOa);
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
    
  case "supprimerRecompense":
    /*
     * Champs présent : idRecompense
     * Champs obligatoire : idRecompense
     * On vérifie tout les champs
     * On supprime tout les liens entre les entités.
     * On supprime la récompense.
     */
    if ( isset($idRecompense) ) {
      if ( !empty($idRecompense) ) {
        $operationOk = supprimer_obtenir_recompense_tous($db, $idRecompense);
        if ( operationOk ) {
          $operationOk = supprimer_recompense($db, $idRecompense);
          if ( $operationOk ) {
            header('Location: ./gestionRecompense.php?operation=ok');
          } else {
            $erreur = "L'opération 2 n'a pas pu être exécuté.";
          }
        } else {
          $erreur = "L'opération 1 n'a pas pu être exécuté.";
        }
      } else {
        $erreur = "L'identifiant de la récompense doit être renseingé.";
      }
    } else {
      $erreur = "Le formulaire est incomplet.";
    }
    break;
}

?>