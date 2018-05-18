<?php

/**
 * FICHIER : FUNCTIONS -> fonctionEvaluer.php
 * Fichier des fonctions de gestion des évalutations.
 */

/**
 * Recupère toutes les évalutaions d'un album de la table Evaluer_Album
 * spécifié par l'identifiant 'idAlbumEvAl'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbumEvAl Int Identifiant album dans Evaluer_Album
 * @return array Evaluations de l'album
 */
function recuperer_evaluation_album_tous($db, $idAlbumEvAl) {
    $req = $db->prepare("SELECT * FROM Evaluer_Album WHERE idAlbumEvAl=:idAlbumEvAl ORDER BY Evaluer_Album.noteEvAl DESC");
    $req->bindParam(':idAlbumEvAl', $idAlbumEvAl);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Recupère toutes les évalutaions d'une musique de la table Evaluer_Musique
 * spécifié par l'identifiant 'idMusiqueEvMu'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueEvMu Int Identifiant musique dans Evaluer_Musique
 * @return array Evaluations de la musique
 */
function recuperer_evaluation_musique_tous($db, $idMusiqueEvMu) {
    $req = $db->prepare("SELECT * FROM Evaluer_Musique WHERE idMusiqueEvMu=:idMusiqueEvMu ORDER BY Evaluer_Musique.noteEvMu DESC");
    $req->bindParam(':idMusiqueEvMu', $idMusiqueEvMu);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Ajoute une nouvelle évaluation d'album dans la BDD
 * avec un id utilisateur , un id album, une note et un commentaire
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idUtilisateurEvAl Int Id de l'utilisateur faisant l'évaluation
 * @param $idAlbumEvAl Int Id de l'album sur lequel est fait l'évaluation
 * @param $noteEvAl Int Note attribuée à l'album
 * @param $commentaireEvAl String Commentaire fait à l'album
 * @return True si la requête s'est bien exécutée | False sinon
 */
function ajouter_evaluation_album($db, $idUtilisateurEvAl, $idAlbumEvAl, $noteEvAl, $commentaireEvAl) {
    $req = $db->prepare("INSERT INTO Evaluer_Album(idUtilisateurEvAl, idAlbumEvAl, noteEvAl, commentaireEvAl) VALUES(:idUtilisateurEvAl, :idAlbumEvAl, :noteEvAl, :commentaireEvAl);");
    $req->bindParam(':idUtilisateurEvAl', $idUtilisateurEvAl, PDO::PARAM_INT);
    $req->bindParam(':idAlbumEvAl', $idAlbumEvAl, PDO::PARAM_INT);
    $req->bindParam(':noteEvAl', $noteEvAl, PDO::PARAM_INT);
    $req->bindParam(':commentaireEvAl', $commentaireEvAl, PDO::PARAM_STR);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Ajoute une nouvelle évaluation de musique dans la BDD
 * avec un id utilisateur , un id musique, une note et un commentaire
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueEvMu Int Id de l'utilisateur faisant l'évaluation
 * @param $idUtilisateurEvMu Int Id de la musique sur lequel est fait l'évaluation
 * @param $noteEvMu Int Note attribuée à la musique
 * @param $commentaireEvMu String Commentaire fait à la musique
 * @return True si la requête s'est bien exécutée | False sinon
 */
function ajouter_evaluation_musique($db, $idUtilisateurEvMu, $idMusiqueEvMu, $noteEvMu, $commentaireEvMu) {
    $req = $db->prepare("INSERT INTO Evaluer_Musique(idUtilisateurEvMu, idMusiqueEvMu, noteEvMu, commentaireEvMu) VALUES(:idUtilisateurEvMu, :idMusiqueEvMu, :noteEvMu, :commentaireEvMu);");
    $req->bindParam(':idUtilisateurEvMu', $idUtilisateurEvMu, PDO::PARAM_INT);
    $req->bindParam(':idMusiqueEvMu', $idMusiqueEvMu, PDO::PARAM_INT);
    $req->bindParam(':noteEvMu', $noteEvMu, PDO::PARAM_INT);
    $req->bindParam(':commentaireEvMu', $commentaireEvMu, PDO::PARAM_STR);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Supprime une évaluation d'un album de la BDD
 * spécifié par les identifiants 'idUtilisateurEvAl' et 'idAlbumEvAl'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idUtilisateurEvAl Int Identifiant de l'utilisateur
 * @param $idAlbumEvAl Int Identifiant de l'album
 * @return True si l'opération de suppression s'est bien exécutée | False Sinon.
 */
function supprimer_evaluation_album($db, $idUtilisateurEvAl, $idAlbumEvAl) {
    $req = $db->prepare("DELETE FROM Evaluer_Album WHERE idUtilisateurEvAl=:idUtilisateurEvAl AND idAlbumEvAl=:idAlbumEvAl;");
    $req->bindParam(':idUtilisateurEvAl', $idUtilisateurEvAl, PDO::PARAM_INT);
    $req->bindParam(':idAlbumEvAl', $idAlbumEvAl, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Supprime une évaluation d'une musique de la BDD
 * spécifié par les identifiants 'idUtilisateurEvMu' et 'idMusiqueEvMu'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idUtilisateurEvMu Int Identifiant de l'utilisateur
 * @param $idMusiqueEvMu Int Identifiant de l'album
 * @return True si l'opération de suppression s'est bien exécutée | False Sinon.
 */
function supprimer_evaluation_musique($db, $idUtilisateurEvMu, $idMusiqueEvMu) {
    $req = $db->prepare("DELETE FROM Evaluer_Musique WHERE idUtilisateurEvMu=:idUtilisateurEvMu AND idMusiqueEvMu=:idMusiqueEvMu;");
    $req->bindParam(':idUtilisateurEvMu', $idUtilisateurEvMu, PDO::PARAM_INT);
    $req->bindParam(':idMusiqueEvMu', $idMusiqueEvMu, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

?>