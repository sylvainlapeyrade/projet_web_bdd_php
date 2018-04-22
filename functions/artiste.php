<?php

/**
 * FICHIER : FUNCTIONS -> ARTISTE.PHP
 * Fichier des fonction de gestion des artistes
 */


function recuperer_artiste_tous($db) {
  $req = $db->prepare("SELECT * FROM Artiste ORDER BY nomArtiste, prenomArtiste ASC");
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

function recupere_artiste($db, $idArtiste) {
  $req = $db->prepare("SELECT * FROM Artiste WHERE idArtiste=:idArtiste");
  $req->bindParam(':idArtiste', $idArtiste);
  $req->execute();
  $res = $req->fetchAll();
  if ( sizeof($res) == 1) {
    return $res[0];
  }
  return null;
}

function ajouter_artiste($db, $nomArtiste, $prenomArtiste, $nomScene, $dateNaissanceArtiste,  $urlImageArtiste, $descriptionArtiste) {
  $req = $db->prepare("INSERT INTO Artiste(nomArtiste, prenomArtiste, nomScene, urlImageArtiste, descriptionArtiste)
      VALUES(:nomArtiste, :prenomArtiste, :nomScene, :urlImageArtiste, :descriptionArtiste);");
  $req->bindParam(':nomArtiste', $nomArtiste, PDO::PARAM_STR);
  $req->bindParam(':prenomArtiste', $prenomArtiste, PDO::PARAM_STR);
  $req->bindParam(':nomScene', $nomScene, PDO::PARAM_STR);
  //$req->bindParam(':dateNaissanceArtiste', date('Y-m-d H:i:s', strtotime($dateNaissanceArtiste)));
  $req->bindParam(':urlImageArtiste', $urlImageArtiste, PDO::PARAM_STR);
  $req->bindParam(':descriptionArtiste', $descriptionArtiste, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

function modifier_artiste($db, $idArtiste, $nomArtiste, $prenomArtiste, $nomScene, $dateNaissanceArtiste,  $urlImageArtiste, $descriptionArtiste) {
  $req = $db->prepare("UPDATE Artiste SET nomArtiste=:nomArtiste, prenomArtiste=:prenomArtiste, nomScene=:nomScene, urlImageArtiste=:urlImageArtiste, descriptionArtiste=:descriptionArtiste WHERE idArtiste=:idArtiste;");
  $req->bindParam(':idArtiste', $idArtiste, PDO::PARAM_INT);
  $req->bindParam(':nomArtiste', $nomArtiste, PDO::PARAM_STR);
  $req->bindParam(':prenomArtiste', $prenomArtiste, PDO::PARAM_STR);
  $req->bindParam(':nomScene', $nomScene, PDO::PARAM_STR);
  //$req->bindParam(':dateNaissanceArtiste', $dateNaissanceArtiste, PDO::PARAM_DATE);
  $req->bindParam(':urlImageArtiste', $urlImageArtiste, PDO::PARAM_STR);
  $req->bindParam(':descriptionArtiste', $descriptionArtiste, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

function supprimer_artiste($db, $idArtiste) {
  $req = $db->prepare("DELETE FROM Artiste WHERE idArtiste=:idArtiste;");
  $req->bindParam(':idArtiste', $idArtiste, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}
  
?>