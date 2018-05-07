<?php

function recuperer_album_tous($db) {
  $req = $db->prepare("SELECT * FROM Album ORDER BY nomAlbum ASC");
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

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

function ajouter_album($db, $nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum) {
  $req = $db->prepare("INSERT INTO Album(nomAlbum, descriptionAlbum, urlPochetteAlbum)
      VALUES(:nomAlbum, :descriptionAlbum, :urlPochetteAlbum);");
  $req->bindParam(':nomAlbum', $nomAlbum, PDO::PARAM_STR);
  //$req->bindParam(':dateNaissanceArtiste', date('Y-m-d H:i:s', strtotime($dateNaissanceArtiste)));
  $req->bindParam(':descriptionAlbum', $descriptionAlbum, PDO::PARAM_STR);
  $req->bindParam(':urlPochetteAlbum', $urlPochetteAlbum, PDO::PARAM_STR);
  $reqOk = $req->execute();
  if ( $reqOk ) {
    $idRecompense = $db->lastInsertId();
    return $idRecompense;
  }
  return null;
}

function modifier_album($db, $idAlbum, $nomAlbum, $dateAlbum, $descriptionAlbum, $urlPochetteAlbum) {
  $req = $db->prepare("UPDATE Album SET nomAlbum=:nomAlbum, descriptionAlbum=:descriptionAlbum, urlPochetteAlbum=:urlPochetteAlbum WHERE idAlbum=:idAlbum;");
  $req->bindParam(':idAlbum', $idAlbum, PDO::PARAM_INT);
  $req->bindParam(':nomAlbum', $nomAlbum, PDO::PARAM_STR);
  //$req->bindParam(':dateRecompense', $dateRecompense, PDO::PARAM_DATE);
  $req->bindParam(':descriptionAlbum', $descriptionAlbum, PDO::PARAM_STR);
  $req->bindParam(':urlPochetteAlbum', $urlPochetteAlbum, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

function supprimer_album($db, $idAlbum) {
  $req = $db->prepare("DELETE FROM Album WHERE idAlbum=:idAlbum;");
  $req->bindParam(':idAlbum', $idAlbum, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

function recuperer_composer_album($db, $idAlbumCoAl) {
  $req = $db->prepare("SELECT * FROM Composer_Album WHERE idAlbumCoAl=:idAlbumCoAl");
  $req->bindParam(':idAlbumCoAl', $idAlbumCoAl);
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

function ajouter_composer_album($db, $idAlbumCoAl, $idArtisteCoAl) {
  $req = $db->prepare("INSERT INTO Composer_Album(idAlbumCoAl, idArtisteCoAl)
      VALUES(:idAlbumCoAl, :idArtisteCoAl);");
  $req->bindParam(':idAlbumCoAl', $idAlbumCoAl, PDO::PARAM_INT);
  $req->bindParam(':idArtisteCoAl', $idArtisteCoAl, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

function supprimer_composer_album_tous($db, $idAlbumCoAl) {
  $req = $db->prepare("DELETE FROM Composer_Album WHERE idAlbumCoAl=:idAlbumCoAl;");
  $req->bindParam(':idAlbumCoAl', $idAlbumCoAl, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

?>