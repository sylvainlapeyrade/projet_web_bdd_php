<?php

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
  $req = $db->prepare("INSERT INTO Musique(titreMusique, dureeMusique, descriptionMusique)
      VALUES(:titreMusique, :dureeMusique, :descriptionMusique);");
  $req->bindParam(':titreMusique', $titreMusique, PDO::PARAM_STR);
  $req->bindParam(':dureeMusique', $dureeMusique, PDO::PARAM_INT);
  //$req->bindParam(':dateNaissanceArtiste', date('Y-m-d H:i:s', strtotime($dateNaissanceArtiste)));
  $req->bindParam(':descriptionMusique', $descriptionMusique, PDO::PARAM_STR);
  $reqOk = $req->execute();
  return $reqOk;
}

function modifier_musique($db, $idMusique, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique) {
  $req = $db->prepare("UPDATE Musique SET titreMusique=:titreMusique, dureeMusique=:dureeMusique, descriptionMusique=:descriptionMusique WHERE idMusique=:idMusique;");
  $req->bindParam(':idMusique', $idMusique, PDO::PARAM_INT);
  $req->bindParam(':titreMusique', $titreMusique, PDO::PARAM_STR);
  $req->bindParam(':dureeMusique', $dureeMusique, PDO::PARAM_INT);
  //$req->bindParam(':dateRecompense', $dateRecompense, PDO::PARAM_DATE);
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

?>