<?php

/**
 * FICHIER : FUNCTIONS -> fonctionGenre.PHP
 * Fichier des fonctions de gestion des genres.
 */

function recuperer_genre($db, $idMusiqueDe) {
  $req = $db->prepare("SELECT * FROM Definir WHERE idMusiqueDe=:idMusiqueDe");
  $req->bindParam(':idMusiqueDe', $idMusiqueDe);
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

function ajouter_genre($db, $idMusique, $nomGenre) {
  $req = $db->prepare("INSERT INTO Definir(idMusiqueDe, nomGenre)
      VALUES(:idMusiqueDe, :nomGenre);");
  $req->bindParam(':idMusiqueDe', $idMusique, PDO::PARAM_INT);
  $req->bindParam(':nomGenre', $nomGenre, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

function supprimer_genre_tous($db, $idMusiqueDe) {
  $req = $db->prepare("DELETE FROM Definir WHERE idMusiqueDe=:idMusiqueDe;");
  $req->bindParam(':idMusiqueDe', $idMusiqueDe, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

?>