<?php

/**
 * FICHIER : FUNCTIONS -> fonctionEvaluer.php
 * Fichier des fonctions de gestion des évalutations.
 */

function recuperer_evaluation_album_tous($db, $idAlbumEvAl) {
    $req = $db->prepare("SELECT * FROM Evaluer_Album WHERE idAlbumEvAl=:idAlbumEvAl");
    $req->bindParam(':idAlbumEvAl', $idAlbumEvAl);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

function recuperer_evaluation_musique_tous($db, $idMusiqueEvMu) {
    $req = $db->prepare("SELECT * FROM Evaluer_Musique WHERE idMusiqueEvMu=:idMusiqueEvMu");
    $req->bindParam(':idMusiqueEvMu', $idMusiqueEvMu);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

function ajouter_evaluation_album($db, $idUtilisateurEvAl, $idAlbumEvAl, $noteEvAl, $commentaireEvAl) {
    $req = $db->prepare("INSERT INTO Evaluer_Album(idUtilisateurEvAl, idAlbumEvAl, noteEvAl, commentaireEvAl) VALUES(:idUtilisateurEvAl, :idAlbumEvAl, :noteEvAl, :commentaireEvAl);");
    $req->bindParam(':idUtilisateurEvAl', $idUtilisateurEvAl, PDO::PARAM_INT);
    $req->bindParam(':idAlbumEvAl', $idAlbumEvAl, PDO::PARAM_INT);
    $req->bindParam(':noteEvAl', $noteEvAl, PDO::PARAM_INT);
    $req->bindParam(':commentaireEvAl', $commentaireEvAl, PDO::PARAM_STR);
    $reqOk = $req->execute();
    return $reqOk;
}

function ajouter_evaluation_musique($db, $idUtilisateurEvMu, $idMusiqueEvMu, $noteEvMu, $commentaireEvMu) {
    $req = $db->prepare("INSERT INTO Evaluer_Musique(idUtilisateurEvMu, idMusiqueEvMu, noteEvMu, commentaireEvMu) VALUES(:idUtilisateurEvMu, :idMusiqueEvMu, :noteEvMu, :commentaireEvMu);");
    $req->bindParam(':idUtilisateurEvMu', $idUtilisateurEvMu, PDO::PARAM_INT);
    $req->bindParam(':idMusiqueEvMu', $idMusiqueEvMu, PDO::PARAM_INT);
    $req->bindParam(':noteEvMu', $noteEvMu, PDO::PARAM_INT);
    $req->bindParam(':commentaireEvMu', $commentaireEvMu, PDO::PARAM_STR);
    $reqOk = $req->execute();
    return $reqOk;
}

function supprimer_evalution_album($db, $idUtilisateurEvAl, $idAlbumEvAl) {
    $req = $db->prepare("DELETE FROM Evaluer_Album WHERE idUtilisateurEvAl=:idUtilisateurEvAl AND idAlbumEvAl=:idAlbumEvAl;");
    $req->bindParam(':idUtilisateurEvAl', $idUtilisateurEvAl, PDO::PARAM_INT);
    $req->bindParam(':idAlbumEvAl', $idAlbumEvAl, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

function supprimer_evaluation_musique($db, $idUtilisateurEvMu, $idAlbumEvMu) {
    $req = $db->prepare("DELETE FROM Evaluer_Musique WHERE idUtilisateurEvMu=:idUtilisateurEvMu AND idAlbumEvMu=:idAlbumEvMu;");
    $req->bindParam(':idUtilisateurEvMu', $idUtilisateurEvMu, PDO::PARAM_INT);
    $req->bindParam(':idAlbumEvMu', $idAlbumEvMu, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

?>