<?php

/**
 * FICHIER : FUNCTIONS -> COMPTE.PHP
 * Fichier de fonction de gestion du compte
 *   - connection
 *   - registration
 *   - add_user
 *   - get_user
 */

function connectionAccount($db, $identify, $password) {
    $res = getUser($db, $identify);
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

function registration($db, $identifiant, $motDePasse) {
    $user = getUser($db, $identify);
    if ( $user == null ) {
        $inscriptionOk = add_user($db, $identifiant, $motDePasse, false);
        return true;
    }
    return false;
}

function add_user($db, $identify, $password, $statut) {
    $req = $db->prepare("INSERT INTO Utilisateur(idUtilisateur, motDePasse, statut)
        VALUES(:idUtilisateur, :motDePasse, :statut);");
    $req->bindParam(':idUtilisateur', $identify, PDO::PARAM_STR);
    $req->bindParam(':motDePasse', $password, PDO::PARAM_STR);
    $req->bindParam(':statut', $statut, PDO::PARAM_BOOL);
    $reqOk = $req->execute();
    return $reqOk;
}

function modify_password_user($db, $identify, $password) {
    $req = $db->prepare("UPDATE Utilisateur SET motDePasse=:password WHERE idUtilisateur=:idUtilisateur;");
    $req->bindParam(':idUtilisateur', $identify, PDO::PARAM_STR);
    $req->bindParam(':password', $password, PDO::PARAM_STR);
    $reqOk = $req->execute();
    return $reqOk;
}

function modify_statut_user($db, $identify, $statut) {
    $req = $db->prepare("UPDATE Utilisateur SET statut=:statut WHERE idUtilisateur=:idUtilisateur;");
    $req->bindParam(':idUtilisateur', $identify, PDO::PARAM_STR);
    $req->bindParam(':statut', $statut, PDO::PARAM_BOOL);
    $reqOk = $req->execute();
    return $reqOk;
}

function delete_user($db, $identify) {
    $req = $db->prepare("DELETE FROM Utilisateur WHERE idUtilisateur=:idUtilisateur;");
    $req->bindParam(':idUtilisateur', $identify, PDO::PARAM_STR);
    $reqOk = $req->execute();
    return $reqOk;
}

function getAllUser($db) {
    $req = $db->prepare("SELECT * FROM Utilisateur ORDER BY idUtilisateur ASC");
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

function getUser($db, $identify) {
    $req = $db->prepare("SELECT * FROM Utilisateur WHERE idUtilisateur=:idUtilisateur");
    $req->bindParam(':idUtilisateur', $identify);
    $req->execute();
    $res = $req->fetchAll();
    if ( sizeof($res) == 1) {
        return $res[0];
    }
    return null;
}

?>
