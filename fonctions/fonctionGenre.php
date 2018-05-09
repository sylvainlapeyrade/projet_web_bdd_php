<?php

/**
 * FICHIER : FUNCTIONS -> fonctionGenre.PHP
 * Fichier des fonctions de gestion des genres.
 */

/***
 * Récupère les genre d'une musique
 * spécifier par l'identifiant 'idMusiqueDe'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueDe Int Identifiant de la musique
 * @return array L'ensemble des genres de la musique
 */
function recuperer_genre($db, $idMusiqueDe) {
  $req = $db->prepare("SELECT * FROM Definir WHERE idMusiqueDe=:idMusiqueDe");
  $req->bindParam(':idMusiqueDe', $idMusiqueDe);
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

/**
 * Ajoute une nouveau genre à la BDD avec un id musique
 * et un nom de genre.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusique Int Identifiant de la musique
 * @param $nomGenre String Nom du genre
 * @return Int idMusique si la requete s'est bien exécutée | Null Sinon
 */
function ajouter_genre($db, $idMusique, $nomGenre) {
  $req = $db->prepare("INSERT INTO Definir(idMusiqueDe, nomGenre)
      VALUES(:idMusiqueDe, :nomGenre);");
  $req->bindParam(':idMusiqueDe', $idMusique, PDO::PARAM_INT);
  $req->bindParam(':nomGenre', $nomGenre, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

/**
 * Supprime toutes les genres d'une musique
 * spécifié par l'identifiant 'idMusiqueDe'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueDe Int Identifiant musique dans Definir
 * @return True si la requete s'est bien exécutée | False sinon
 */
function supprimer_genre_tous($db, $idMusiqueDe) {
  $req = $db->prepare("DELETE FROM Definir WHERE idMusiqueDe=:idMusiqueDe;");
  $req->bindParam(':idMusiqueDe', $idMusiqueDe, PDO::PARAM_INT);
  $reqOk = $req->execute();
return $reqOk;
}

?>