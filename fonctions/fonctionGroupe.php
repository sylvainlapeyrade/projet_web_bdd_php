<?php

/**
 * FICHIER : FUNCTIONS -> fonctionGroupe.PHP
 * Fichier des fonctions de gestion des groupes.
 */

function recuperer_groupe_tous($db) {
  $req = $db->prepare("SELECT * FROM Groupe ORDER BY nomGroupe ASC");
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

function recuperer_groupe($db, $idGroupe) {
  $req = $db->prepare("SELECT * FROM Groupe WHERE idGroupe=:idGroupe");
  $req->bindParam(':idGroupe', $idGroupe);
  $req->execute();
  $res = $req->fetchAll();
    return $res;
}

function ajouter_groupe($db, $nomGroupe, $dateGroupe, $descriptionGroupe, $urlImageGroupe) {
  $req = $db->prepare("INSERT INTO Groupe(nomGroupe, dateGroupe, descriptionGroupe, urlImageGroupe)
      VALUES(:nomGroupe, :dateGroupe, :descriptionGroupe, :urlImageGroupe);");
  $req->bindParam(':nomGroupe', $nomGroupe, PDO::PARAM_STR);
  $req->bindParam(':dateGroupe', format_date($dateGroupe));
  $req->bindParam(':descriptionGroupe', $descriptionGroupe, PDO::PARAM_STR);
  $req->bindParam(':urlImageGroupe', $urlImageGroupe, PDO::PARAM_STR);
  $reqOk = $req->execute();
  if ( $reqOk ) {
    $idRecompense = $db->lastInsertId();
    return $idRecompense;
  }
  return null;
}

function modifier_groupe($db, $idGroupe, $nomGroupe, $dateGroupe, $descriptionGroupe, $urlImageGroupe) {
  $req = $db->prepare("UPDATE Groupe SET nomGroupe=:nomGroupe, dateGroupe=:dateGroupe, descriptionGroupe=:descriptionGroupe, urlImageGroupe=:urlImageGroupe WHERE idGroupe=:idGroupe;");
  $req->bindParam(':idGroupe', $idGroupe, PDO::PARAM_INT);
  $req->bindParam(':nomGroupe', $nomGroupe, PDO::PARAM_STR);
  $req->bindParam(':dateGroupe', format_date($dateGroupe));
  $req->bindParam(':descriptionGroupe', $descriptionGroupe, PDO::PARAM_STR);
  $req->bindParam(':urlImageGroupe', $urlImageGroupe, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

function supprimer_groupe($db, $idGroupe) {
  $req = $db->prepare("DELETE FROM Groupe WHERE idGroupe=:idGroupe;");
  $req->bindParam(':idGroupe', $idGroupe, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

function recuperer_constituer_groupe($db, $idGroupeCo) {
  $req = $db->prepare("SELECT * FROM Constituer WHERE idGroupeCo=:idGroupeCo");
  $req->bindParam(':idGroupeCo', $idGroupeCo, PDO::PARAM_INT);
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

function ajouter_constituer_groupe($db, $idGroupeCo, $idArtisteCo) {
  $req = $db->prepare("INSERT INTO Constituer(idGroupeCo, idArtisteCo)
      VALUES(:idGroupeCo, :idArtisteCo);");
  $req->bindParam(':idGroupeCo', $idGroupeCo, PDO::PARAM_INT);
  $req->bindParam(':idArtisteCo', $idArtisteCo, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

function supprimer_constituer_groupe_tous($db, $idGroupeCo) {
  $req = $db->prepare("DELETE FROM Constituer WHERE idGroupeCo=:idGroupeCo;");
  $req->bindParam(':idGroupeCo', $idGroupeCo, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

?>