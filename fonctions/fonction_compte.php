<?php
/**
 * FICHIER : FUNCTIONS -> COMPTE.PHP
 * Fichier des fonctions de gestion du compte
 */

/**
 * Fonction qui permet de rediriger l'utilisateur
 * vers la page d'accueil.
 * Est utilisé pour la sécurité de l'application
 */
function leave() {
    header('Location: /index.php');
    exit();
}

function session_active() {
    if ( session_status() == PHP_SESSION_DISABLED ) {
        return false;
    }
    return true;
}

/**
 * Fonction qui vérifie si l'utilisateur est bien connecter
 * Renvoie true si l'utilisateur est connecter.
 * Renvoie false sinon.
 */
function is_connect() {
    if ( !session_active() ) {
        return false;
    }
    if ( isset($_SESSION['idUtilisateur'] ) ) {
        return true;
    }
    return false;
}

/**
 * Fonction qui vérifie si l'utilisateur est connecter
 * et s'il à le statut d'administrateur
 */
function is_admin() {
    if ( is_connect() ) {
        if ( $_SESSION['statut'] ) {
            return true;
        }
    }
    return false;
}

/*
 * Fonction de connexion d'un utilisateur à l'aide d'un identifiant et d'un mot de passe
 * Vérifie dans la base de données si une entrée correspond à un identifiant et un mot de passe.
 * Ouvre une session avec l'identifiant de l'utilisateur ainsi que son statut.
 * Renvoie la valeur true si la connexion à été effectuer,
 * Renvoie false sinon.
 */
function connexion_account($db, $identify, $password) {
  $res = recuperer_utilisateur($db, $identify);
  if ( $res != null ) {
    $passOk = $password == $res['motdepasse'];
    if ( $passOk ) {
      $_SESSION['idUtilisateur'] = $res['idutilisateur'];
      $_SESSION['statut'] = $res['statut'];
      return true;
    }
  }
  return false;
}

/*
 * Permet d'inscrire une nouvelle personne dans la base de données.
 * Vérifie dans la base de données s'il n'y a pas déjà une entrée.
 * Enregistre un utilisateur avec un identifiant, un mot de passe.
 * Le nouveau compte crée est par défaut non administrateur.
 * Renvoie la valeur true, si l'enregistrement dans la base de données à été effectué.
 * Renvoie false sinon.
 */
function inscription($db, $identifiant, $motDePasse) {
  $user = recuperer_utilisateur($db, $identify);
  if ( $user == null ) {
    $inscriptionOk = ajouter_utilisateur($db, $identifiant, $motDePasse, false);
    return $inscriptionOk;
  }
  return false;
}

/*
 * Récupère tout les utilisateurs de la base de données
 * en les triant par ordre alphabétique de leur identifiant
 * Renvoie le réusltat.
 */
function recuperer_utilisateur_tous($db) {
  $req = $db->prepare("SELECT * FROM Utilisateur ORDER BY idUtilisateur ASC");
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

/*
 * Récupère un utilisateur de la base de données
 * spécifié par l'identifiant 'idUtilisateur'.
 * Renvoie le résultat, il est unique.
 * Sinon renvoie la valeur null.
 */
function recuperer_utilisateur($db, $identify) {
  $req = $db->prepare("SELECT * FROM Utilisateur WHERE idUtilisateur=:idUtilisateur");
  $req->bindParam(':idUtilisateur', $identify);
  $req->execute();
  $res = $req->fetchAll();
  if ( sizeof($res) == 1) {
    return $res[0];
  }
  return null;
}

/*
 * Ajoute un nouvel utilisateur dans la base de données
 * avec un identifiant, un mot de passe ainsi que le statut de l'utilisateur
 * Renvoie si l'opération d'ajout c'est bien exécutée.
 */
function ajouter_utilisateur($db, $identify, $password, $statut) {
  $req = $db->prepare("INSERT INTO Utilisateur(idUtilisateur, motDePasse, statut)
      VALUES(:idUtilisateur, :motDePasse, :statut);");
  $req->bindParam(':idUtilisateur', $identify, PDO::PARAM_STR);
  $req->bindParam(':motDePasse', $password, PDO::PARAM_STR);
  $req->bindParam(':statut', $statut, PDO::PARAM_BOOL);
  $reqOk = $req->execute();
  return $reqOk;
}

/*
 * Modifie le mot de passe d'un utilisateur dans la base de données.
 * Renvoie si l'opération de modification c'est bien exécutée.
 */
function modifier_motdepasse_utilisateur($db, $identify, $password) {
  $req = $db->prepare("UPDATE Utilisateur SET motDePasse=:password WHERE idUtilisateur=:idUtilisateur;");
  $req->bindParam(':idUtilisateur', $identify, PDO::PARAM_STR);
  $req->bindParam(':password', $password, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

/*
 * Modifie le statut de l'utilisateur dans la base de données.
 * Renvoie si l'opération de modification c'est bien exécutée.
 */
function modifier_statut_utilisateur($db, $identify, $statut) {
  $req = $db->prepare("UPDATE Utilisateur SET statut=:statut WHERE idUtilisateur=:idUtilisateur;");
  $req->bindParam(':idUtilisateur', $identify, PDO::PARAM_STR);
  $req->bindParam(':statut', $statut, PDO::PARAM_BOOL);
  $reqOk = $req->execute();
  return $reqOk;
}

/*
 * Supprime un utilisateur de la base de données
 * spécifié par l'identifiant 'idUtilisateur'.
 * Renvoie si l'opération de suppression c'est bien exécutée.
 */
function supprimer_utilisateur($db, $identify) {
  $req = $db->prepare("DELETE FROM Utilisateur WHERE idUtilisateur=:idUtilisateur;");
  $req->bindParam(':idUtilisateur', $identify, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

?>
