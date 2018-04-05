<?php

/**
 * FICHIER : FUNCTIONS -> COMPTE.PHP
 * Fichier de fonction de gestion du compte
 *   - connection
 *   - registration
 *   - add_user
 *   - get_user
 *   - hash_text
 */

function connection($db, $identify, $password) {
    $password = hash_text($password, null);
    $res = getUser($db, $identify);
    if ( $res != null ) {
        $passOk = $password == $res['motdepasse'];
        if ( $passOk ) {
            $_SESSION['identifiant'] = $res['identifiant'];
            $_SESSION['statut'] = $res['statut'];
            return true;
        }
    }
    return false;
}

function registration($db, $identifiant, $motDePasse) {
    $user = getUser($db, $identify);
    if ( $user == null ) {
        $inscriptionOk = add_user($db, $identifiant, $motDePasse);
        return true;
    }
    return false;
}

function add_user($db, $identify, $password) {
    $password = hash_text($password, null);
    $req = $db->prepare("INSERT INTO Utilisateur(identifiant, motDePasse, statut)
        VALUES(:identifiant, :motDePasse, 0);");
    $req->bindParam(':identifiant', $identify, PDO::PARAM_STR);
    $req->bindParam(':motDePasse', $password, PDO::PARAM_STR);
    $reqOk = $req->execute();
    return $reqOk;
}

function getUser($db, $identify) {
    $req = $db->prepare("SELECT * FROM Utilisateur WHERE identifiant=:identifiant");
    $req->bindParam(':identifiant', $identify);
    $req->execute();
    $res = $req->fetchAll();
    if ( sizeof($res) == 1) {
        return $res[0];
    }
    return null;
}

function hash_text($text, $salt) {
    if ( empty($salt) ) {
        $salt = "awectbu,o:?&é'(-è_çà)";
    }
    return crypt($text.$salt, $salt);
}

?>