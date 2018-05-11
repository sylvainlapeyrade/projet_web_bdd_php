<?php

/**
 * FICHIER : FUNCTIONS -> fonctionCompte.PHP
 * Fichier des fonctions de gestion du compte.
 */

/**
 * Redirige l'utilisateur vers la page d'accueil.
 * Est utilisé pour la sécurité de l'application.
 */
function leave() {
    header('Location: /index.php');
    exit();
}

/**
 * Vérifie si l'utilisateur est bien connecté
 * @return True si l'utilisateur est connecté | False sinon
 */
function is_connect() {
    if ( session_status() == PHP_SESSION_DISABLED  ) {
        return false;
    }
    if ( isset($_SESSION['idUtilisateur'] ) ) {
        return true;
    }
    return false;
}


/**
 * Vérifie si l'utilisateur est connecté et s'il est administrateur
 * @return True si l'utilisateur est connecté et administrateur | False sinon
 */
function is_admin() {
    if ( is_connect() ) {
        if ( $_SESSION['statut'] ) {
            return true;
        }
    }
    return false;
}

/**
 * Connexion d'un utilisateur avec id et mdp
 * Vérifie dans la BDD si une entrée correspond à l'id et au mdp
 * Ouvre une session avec l'id de l'utilisateur et son statut.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $identifiant String à vérifier
 * @param $motDePasse String à vérifier
 * @return True si la connexion a été effectuée | False sinon.
 */
function connexion_compte($db, $identifiant, $motDePasse) {
  $res = recuperer_utilisateur($db, $identifiant);
  if ( $res != null ) {
    $passOk = $motDePasse == $res['motdepasse'];
    if ( $passOk ) {
      $_SESSION['idUtilisateur'] = $res['idutilisateur'];
      $_SESSION['statut'] = $res['statut'];
      return true;
    }
  }
  return false;
}

/**
 * Inscrit un nouveau utilisateur dans la BDD.
 * Vérifie dans la BDD s'il n'y a pas déjà une entrée correspondant au
 * couple id/mdp et le cas echeant enregistre le nouvel utilisateur.
 * Le nouveau compte crée est par défaut non administrateur.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $identifiant String à vérifier
 * @param $motDePasse String à vérifier
 * @return True si l'enregistrement dans la BDD a été effectué | False sinon.
 */
function inscription($db, $identifiant, $motDePasse) {
  $user = recuperer_utilisateur($db, $identifiant);
  if ( $user == null ) {
    $inscriptionOk = ajouter_utilisateur($db, $identifiant, $motDePasse, false);
    return $inscriptionOk;
  }
  return false;
}

/**
 * Récupère tout les utilisateurs de la BDD en les
 * triant par ordre alphabétique de leur identifiant
 * @param $db PDO Instance PDO de connexion à la BDD
 * @return array Les utilisateurs de la base de données
 */
function recuperer_utilisateur_tous($db) {
  $req = $db->prepare("SELECT * FROM Utilisateur ORDER BY idUtilisateur ASC");
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

/**
 * Récupère un utilisateur de la base de données
 * spécifié par l'identifiant 'idUtilisateur'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param  $identifiant String Identifiant utilisateur
 * @return array L'utilisateur correspondant a l'id | Null sinon
 */
function recuperer_utilisateur($db, $identifiant) {
  $req = $db->prepare("SELECT * FROM Utilisateur WHERE idUtilisateur=:idUtilisateur");
  $req->bindParam(':idUtilisateur', $identifiant);
  $req->execute();
  $res = $req->fetchAll();
    return $res;
}

/**
 * Ajoute un nouvel utilisateur dans la BDD
 * avec un id, un mdp et un statut
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param  $identifiant String Identifiant utilisateur
 * @param $motDePasse String MDP utilisateur
 * @param $statut String Statut utilisateur
 * @return True si l'opération d'ajout s'est bien exécutée | False sinon.
 */
function ajouter_utilisateur($db, $identifiant, $motDePasse, $statut) {
  $req = $db->prepare("INSERT INTO Utilisateur(idUtilisateur, motDePasse, statut)
      VALUES(:idUtilisateur, :motDePasse, :statut);");
  $req->bindParam(':idUtilisateur', $identifiant, PDO::PARAM_STR);
  $req->bindParam(':motDePasse', $motDePasse, PDO::PARAM_STR);
  $req->bindParam(':statut', $statut, PDO::PARAM_BOOL);
  $reqOk = $req->execute();
  return $reqOk;
}

/**
 * Modifie le mot de passe d'un utilisateur dans la BDD.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $identifiant String Identifiant utilisateur
 * @param $motDePasse String MDP utilisateur
 * @return True si l'opération de modification s'est bien exécutée | False Sinon.
 */
function modifier_motdepasse_utilisateur($db, $identifiant, $motDePasse) {
  $req = $db->prepare("UPDATE Utilisateur SET motDePasse=:motDePasse WHERE idUtilisateur=:idUtilisateur;");
  $req->bindParam(':idUtilisateur', $identifiant, PDO::PARAM_STR);
  $req->bindParam(':motDePasse', $motDePasse, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

/**
 * Modifie le statut de l'utilisateur dans la BDD.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $identifiant String Identifiant utilisateur
 * @param $statut String Statut utilisateur
 * @return True si l'opération de modification s'est bien exécutée | False Sinon.
 */
function modifier_statut_utilisateur($db, $identifiant, $statut) {
  $req = $db->prepare("UPDATE Utilisateur SET statut=:statut WHERE idUtilisateur=:idUtilisateur;");
  $req->bindParam(':idUtilisateur', $identifiant, PDO::PARAM_STR);
  $req->bindParam(':statut', $statut, PDO::PARAM_BOOL);
  $reqOk = $req->execute();
  return $reqOk;
}

/**
 * Supprime un utilisateur de la BDD
 * spécifié par l'identifiant 'idUtilisateur'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $identifiant String Identifiant utilisateur
 * @return True si l'opération de suppression s'est bien exécutée | False Sinon.
 */
function supprimer_utilisateur($db, $identifiant) {
  $req = $db->prepare("DELETE FROM Utilisateur WHERE idUtilisateur=:idUtilisateur;");
  $req->bindParam(':idUtilisateur', $identifiant, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}
