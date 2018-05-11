<?php

/**
 * FICHIER : FUNCTIONS -> fonctionAlbum.PHP
 * Fichier des fonctions de gestion d'album.
 */

/**
 * Recupere les musiques d'un album avec leur numero de piste
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbum Int Identifiant album dans Assembler_Album
 * @return array Association des albums et de leur compositeur
 */
function recuperer_musique_album($db, $idAlbum) {
  $req = $db->prepare("SELECT * FROM Assembler_Album, Musique WHERE Assembler_Album.idAlbumAa=:idAlbum AND Assembler_Album.idMusiqueAa = Musique.idMusique;");
  $req->bindParam(':idAlbum', $idAlbum, PDO::PARAM_INT);
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

/**
 * Récupère tout les albums de la BDD en les
 * triant par ordre alphabétique de leur noms
 * @param $db PDO Instance PDO de connexion à la BDD
 * @return array Les albums de la base de données
 */
function recuperer_album_tous($db) {
  $req = $db->prepare("SELECT * FROM Album ORDER BY nomAlbum ASC");
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

/**
 * Récupère un album de la base de données
 * spécifié par l'identifiant 'idAlbum'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbum int Identifiant utilisateur
 * @return array L'utilisateur correspondant a l'id | Null sinon
 */
function recuperer_album($db, $idAlbum) {
  $req = $db->prepare("SELECT * FROM Album WHERE idAlbum=:idAlbum");
  $req->bindParam(':idAlbum', $idAlbum);
  $req->execute();
  $res = $req->fetchAll();
  if ( sizeof($res) == 1) {
    return $res[0];
  }
  return null;
}

/**
 * Ajoute un nouvel utilisateur dans la BDD
 * avec un id, un mdp et un statut
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $nomAlbum String Nom de l'album
 * @param $dateAlbum DateTime Date de sortie de l'album
 * @param $descriptionAlbum String Desciption de l'album
 * @param $urlPochetteAlbum String URL de la jaquette de l'album
 * @return int L'id de la recompense si la requete s'est bien exécutée | Null sinon
 */
function ajouter_album($db, $nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum) {
  $req = $db->prepare("INSERT INTO Album(nomAlbum, dateAlbum, descriptionAlbum, urlPochetteAlbum) VALUES(:nomAlbum, :dateAlbum, :descriptionAlbum, :urlPochetteAlbum);");
  $req->bindParam(':nomAlbum', $nomAlbum, PDO::PARAM_STR);
  $req->bindParam(':dateAlbum', $dateAlbum, PDO::PARAM_STR);
  $req->bindParam(':dateAlbum', format_date($dateAlbum));
  $req->bindParam(':descriptionAlbum', $descriptionAlbum, PDO::PARAM_STR);
  $req->bindParam(':urlPochetteAlbum', $urlPochetteAlbum, PDO::PARAM_STR);
  $reqOk = $req->execute();
  if ( $reqOk ) {
    $idRecompense = $db->lastInsertId();
    return $idRecompense;
  }
  return null;
}

/**
 * Modifie un album dans la BDD.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbum Int Identifiant de l'album
 * @param $nomAlbum String Nom de l'album
 * @param $dateAlbum DateTime Date de sortie de l'album
 * @param $descriptionAlbum String Desciption de l'album
 * @param $urlPochetteAlbum String URL de la jaquette de l'album
 * @return True si la requete s'est bien exécutée | False sinon
 */
function modifier_album($db, $idAlbum, $nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum) {
  $req = $db->prepare("UPDATE Album SET nomAlbum=:nomAlbum, dateAlbum=:dateAlbum, descriptionAlbum=:descriptionAlbum, urlPochetteAlbum=:urlPochetteAlbum WHERE idAlbum=:idAlbum;");
  $req->bindParam(':idAlbum', $idAlbum, PDO::PARAM_INT);
  $req->bindParam(':nomAlbum', $nomAlbum, PDO::PARAM_STR);
  $req->bindParam(':dateAlbum', format_date($dateAlbum));
  $req->bindParam(':descriptionAlbum', $descriptionAlbum, PDO::PARAM_STR);
  $req->bindParam(':urlPochetteAlbum', $urlPochetteAlbum, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

/**
 * Supprime un album de la BDD
 * spécifié par l'identifiant 'idAlbum'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbum Int Identifiant de l'album
 * @return True si l'opération de suppression s'est bien exécutée | False Sinon.
 */
function supprimer_album($db, $idAlbum) {
  $req = $db->prepare("DELETE FROM Album WHERE idAlbum=:idAlbum;");
  $req->bindParam(':idAlbum', $idAlbum, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

/**
 * Recupere les associations d'album et leur compositeur
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbumCoAl Int Identifiant album dans Composer_album
 * @return array Association des albums et de leur compositeur
 */
function recuperer_composer_album($db, $idAlbumCoAl) {
  $req = $db->prepare("SELECT * FROM Composer_Album WHERE idAlbumCoAl=:idAlbumCoAl");
  $req->bindParam(':idAlbumCoAl', $idAlbumCoAl, PDO::PARAM_INT);
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

/**
 * Ajoute une association entre un album et son compositeur
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbumCoAl Int Identifiant album dans Composer_album
 * @param $idArtisteCoAl Int Identifiant artiste dans Composer_album
 * @return True si la requete s'est bien exécutée | False sinon
 */
function ajouter_composer_album($db, $idAlbumCoAl, $idArtisteCoAl) {
  $req = $db->prepare("INSERT INTO Composer_Album(idAlbumCoAl, idArtisteCoAl)
      VALUES(:idAlbumCoAl, :idArtisteCoAl);");
  $req->bindParam(':idAlbumCoAl', $idAlbumCoAl, PDO::PARAM_INT);
  $req->bindParam(':idArtisteCoAl', $idArtisteCoAl, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

/**
 * Supprime toutes les association de la table Composer_Album
 * spécifié par l'identifiant 'idAlbumCoAl'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbumCoAl Int Identifiant album dans Composer_Album
 * @return True si la requete s'est bien exécutée | False sinon
 */
function supprimer_composer_album_tous($db, $idAlbumCoAl) {
  $req = $db->prepare("DELETE FROM Composer_Album WHERE idAlbumCoAl=:idAlbumCoAl;");
  $req->bindParam(':idAlbumCoAl', $idAlbumCoAl, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

?>