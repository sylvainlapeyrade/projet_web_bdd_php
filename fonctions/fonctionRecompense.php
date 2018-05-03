<?php

function recuperer_recompense_tous($db) {
  $req = $db->prepare("SELECT * FROM Recompense ORDER BY nomRecompense ASC");
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

function recupere_recompense($db, $idRecompense) {
  $req = $db->prepare("SELECT * FROM Recompense WHERE idRecompense=:idRecompense");
  $req->bindParam(':idRecompense', $idRecompense);
  $req->execute();
  $res = $req->fetchAll();
  if ( sizeof($res) == 1) {
    return $res[0];
  }
  return null;
}

function ajouter_recompense($db, $nomRecompense, $dateRecompense, $descriptionRecompense) {
  $req = $db->prepare("INSERT INTO Recompense(nomRecompense, descriptionRecompense)
      VALUES(:nomRecompense, :descriptionRecompense);");
  $req->bindParam(':nomRecompense', $nomRecompense, PDO::PARAM_STR);
  //$req->bindParam(':dateNaissanceArtiste', date('Y-m-d H:i:s', strtotime($dateNaissanceArtiste)));
  $req->bindParam(':descriptionRecompense', $descriptionRecompense, PDO::PARAM_STR);
  $reqOk = $req->execute();
  if ( $reqOk ) {
    $idRecompense = $db->lastInsertId();
    return $idRecompense;
  }
  return null;
}

function modifier_recompense($db, $idRecompense, $nomRecompense, $dateRecompense, $descriptionRecompense) {
  $req = $db->prepare("UPDATE Recompense SET nomRecompense=:nomRecompense, descriptionRecompense=:descriptionRecompense WHERE idRecompense=:idRecompense;");
  $req->bindParam(':idRecompense', $idRecompense, PDO::PARAM_INT);
  $req->bindParam(':nomRecompense', $nomRecompense, PDO::PARAM_STR);
  //$req->bindParam(':dateRecompense', $dateRecompense, PDO::PARAM_DATE);
  $req->bindParam(':descriptionRecompense', $descriptionRecompense, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

function supprimer_recompense($db, $idRecompense) {
  $req = $db->prepare("DELETE FROM Recompense WHERE idRecompense=:idRecompense;");
  $req->bindParam(':idRecompense', $idRecompense, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

function recuperer_obtenir_recompense($db, $idRecompense) {
  $req = $db->prepare("SELECT idArtisteOa FROM Obtenir_Artiste WHERE idRecompenseOa=:idRecompense");
  $req->bindParam(':idRecompense', $idRecompense);
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

function ajouter_obtenir_recompense($db, $idRecompense, $idArtiste) {
  $req = $db->prepare("INSERT INTO Obtenir_Artiste(idRecompenseOa, idArtisteOa)
      VALUES(:idRecompenseOa, :idArtisteOa);");
  $req->bindParam(':idRecompenseOa', $idRecompense, PDO::PARAM_INT);
  $req->bindParam(':idArtisteOa', $idArtiste, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

function supprimer_obtenir_recompense_tous($db, $idRecompense) {
  $req = $db->prepare("DELETE FROM Obtenir_Artiste WHERE idRecompenseOa=:idRecompense;");
  $req->bindParam(':idRecompense', $idRecompense, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}

?>