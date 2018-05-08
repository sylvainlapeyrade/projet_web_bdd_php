<?php

/**
 * FICHIER : FUNCTIONS -> fonctionMusique.PHP
 * Fichier des fonctions de gestion des musiques.
 */

function recuperer_musique_tous($db) {
  $req = $db->prepare("SELECT * FROM Musique ORDER BY titreMusique ASC");
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

function recuperer_musique($db, $idMusique) {
  $req = $db->prepare("SELECT * FROM Musique WHERE idMusique=:idMusique");
  $req->bindParam(':idMusique', $idMusique);
  $req->execute();
  $res = $req->fetchAll();
  if ( sizeof($res) == 1) {
    return $res[0];
  }
  return null;
}

function ajouter_musique($db, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique) {
  $req = $db->prepare("INSERT INTO Musique(titreMusique, dureeMusique, dateMusique, descriptionMusique)
      VALUES(:titreMusique, :dureeMusique, :dateMusique, :descriptionMusique);");
  $req->bindParam(':titreMusique', $titreMusique, PDO::PARAM_STR);
  $req->bindParam(':dureeMusique', $dureeMusique, PDO::PARAM_INT);
  $req->bindParam(':dateMusique', format_date($dateMusique));
  $req->bindParam(':descriptionMusique', $descriptionMusique, PDO::PARAM_STR);
  $reqOk = $req->execute();
  if ( $reqOk ) {
    $idMusique = $db->lastInsertId();
    return $idMusique;
  }
  return null;
}

function modifier_musique($db, $idMusique, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique) {
  $req = $db->prepare("UPDATE Musique SET titreMusique=:titreMusique, dureeMusique=:dureeMusique, dateMusique=:dateMusique, descriptionMusique=:descriptionMusique WHERE idMusique=:idMusique;");
  $req->bindParam(':idMusique', $idMusique, PDO::PARAM_INT);
  $req->bindParam(':titreMusique', $titreMusique, PDO::PARAM_STR);
  $req->bindParam(':dureeMusique', $dureeMusique, PDO::PARAM_INT);
  $req->bindParam(':dateMusique', format_date($dateMusique));
  $req->bindParam(':descriptionMusique', $descriptionMusique, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

function supprimer_musique($db, $idMusique) {
  $req = $db->prepare("DELETE FROM Musique WHERE idMusique=:idMusique;");
  $req->bindParam(':idMusique', $idMusique, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

function recuperer_composer_musique($db, $idMusiqueCoMu) {
  $req = $db->prepare("SELECT * FROM Composer_Musique WHERE idMusiqueCoMu=:idMusiqueCoMu");
  $req->bindParam(':idMusiqueCoMu', $idMusiqueCoMu, PDO::PARAM_INT);
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

function ajouter_composer_musique($db, $idMusiqueCoMu, $idArtisteCoMu) {
  $req = $db->prepare("INSERT INTO Composer_Musique(idMusiqueCoMu, idArtisteCoMu)
      VALUES(:idMusiqueCoMu, :idArtisteCoMu);");
  $req->bindParam(':idMusiqueCoMu', $idMusiqueCoMu, PDO::PARAM_INT);
  $req->bindParam(':idArtisteCoMu', $idArtisteCoMu, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

function supprimer_composer_musique_tous($db, $idMusiqueCoMu) {
  $req = $db->prepare("DELETE FROM Composer_Musique WHERE idMusiqueCoMu=:idMusiqueCoMu;");
  $req->bindParam(':idMusiqueCoMu', $idMusiqueCoMu, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

function recuperer_assembler_album($db, $idMusiqueAa) {
  $req = $db->prepare("SELECT * FROM Composer_Album WHERE idMusiqueAa=:idMusiqueAa");
  $req->bindParam(':idMusiqueAa', $idMusiqueAa, PDO::PARAM_INT);
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

function ajouter_assembler_album($db, $idMusiqueAa, $idAlbumAa, $numeroPiste) {
  $req = $db->prepare("INSERT INTO Composer_Album(idMusiqueAa, idAlbumAa, numeroPiste)
      VALUES(:idMusiqueAa, :idAlbumAa, :numeroPiste);");
  $req->bindParam(':idMusiqueAa', $idMusiqueAa, PDO::PARAM_INT);
  $req->bindParam(':idAlbumAa', $idAlbumAa, PDO::PARAM_INT);
  $req->bindParam(':numeroPiste', $numeroPiste, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

function supprimer_assembler_album_tous($db, $idAlbumAa) {
  $req = $db->prepare("DELETE FROM Assembler_Album WHERE idMusiqueAa=:idMusiqueAa;");
  $req->bindParam(':idMusiqueAa', $idAlbumAa, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

?>