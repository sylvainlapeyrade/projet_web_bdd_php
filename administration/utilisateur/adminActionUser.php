<?php
  /*
   * FICHIER AdminActionUtilisateur.php
   * Fichier d'exécution des actions suivant les paramètre demandé.
   * 4 cas :
   *    1: ajouter un utilisateur
   *    2: modifier le mot de passe d'un utilisateur
   *    3: modifier le statut d'un utilisateur
   *    3: supprimer un utilisateur
   * Date modification : 25/04/2018
   */

switch($action) {
  case 'ajouterUtilisateur':
    /*
     * Champs présent : idUtilisateur, motDePasse, statut
     * Champs obligatoire : idUtilisateur, motDePasse
     */
    if( isset($idUtilisateur, $motDePasse) ) {
      if ( !empty($idUtilisateur) && !empty($motDePasse) ) {
        if ( $statut == 1 )
          $estAdmin = true;
        else
          $estAdmin = false;
        $operationOk = ajouter_utilisateur($db, $idUtilisateur, $motDePasse, $estAdmin);
        if ( $operationOk ) {
          header('Location: ./adminGestionUser.php?operation=ok');
        } else {
          $erreur = "L'opération n'a pas pu être exécuté.";
        }
      } else {
        $erreur = "L'identifiant, le mot de passe et le statut sont obligatoire.";
      }
    } else {
      $erreur = "Le formulaire est incomplet.";
    }
    break;
  
  case 'modifierMotDePasseUtilisateur':
    /*
     * Champs présent : idUtilisateur, motDePasse, verification
     * Champs obligatoire : idUtilisateur, motDePasse, verification
     */
    if ( isset($idUtilisateur, $motDePasse, $verification) ) {
      if ( !empty($idUtilisateur) && !empty($motDePasse) && !empty($verification) ) {
        if ( $motDePasse == $verification ) {
          $operationOk = modifier_motdepasse_utilisateur($db, $idUtilisateur, $motDePasse);
          if ( $operationOk ) {
            header('Location: ./adminGestionUser.php?operation=ok');
          } else {
            $erreur = "L'opération n'a pas pu être exécuté.";
          }
        } else {
          $erreur = "Les deux mot de passe ne sont pas identique.";
        }
      } else {
        $erreur = "L'identifiant, le mot de passe et la vérification sont obligatoire.";
      }
    } else {
      $erreur = "Le formulaire est incomplet.";
    }
    break;
  
  case 'modifierStatutUtilisateur':
    /*
     * Champs présent : idUtilisateur, statut
     * Champs obligatoire : idUtilisateur
     */
    if ( isset($idUtilisateur, $statut) ) {
      if ( !empty($idUtilisateur) ) {
        if ( $statut == 1 )
          $estAdmin = true;
        else
          $estAdmin = false;
        if ( $idUtilisateur != $_SESSION['idUtilisateur'] ) {
          $operationOk = modifier_statut_utilisateur($db, $idUtilisateur, $estAdmin);
          if ( $operationOk ) {
            header('Location: ./adminGestionUser.php?operation=ok');
          } else {
            $erreur = "L'opération n'a pas pu être exécuté.";
          }
        } else {
          $erreur = "Vous ne pouvez pas devenir utilisateur normal.";
        }
      } else {
        $erreur = "L'identifiant et le statut sont obligatoire.";
      }
    } else {
      $erreur = "Le formulaire est incomplet.";
    }
    break;
  
  case 'supprimerUtilisateur':
    /*
     * Champs présent : idUtilisateur
     * Champs obligatoire : idUtilisateur
     */
    if ( isset($idUtilisateur) ) {
      if ( !empty($idUtilisateur) ) {
        if ( $idUtilisateur != $_SESSION['idUtilisateur'] ) {
          $operationOk = supprimer_utilisateur($db, $idUtilisateur);
          if ( $operationOk ) {
            header('Location: ./adminGestionUser.php?operation=ok');
          } else {
            $erreur = "L'opération n'a pas pu être exécuté.";
          }
        } else {
          $erreur = "Vous ne pouvez pas supprimer votre propre compte.";
        }
      } else {
        $erreur = "L'identifiant est obligatoire.";
      }
    } else {
      $erreur = "Le formulaire est incomplet.";
    }
    break;
    
}

?>