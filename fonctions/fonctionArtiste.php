<?php

/**
 * FICHIER : FUNCTIONS -> ARTISTE.PHP
 * Fichier des fonction de gestion des artistes
 */

/*
 * Récupère tout les artistes de la base de données
 * en les triant par ordre alphabétique par le nom
 * et ensuite le prenom.
 * Renvoie le résultat.
 */
function recuperer_artiste_tous($db) {
  $req = $db->prepare("SELECT * FROM Artiste ORDER BY nomArtiste, prenomArtiste ASC");
  $req->execute();
  $res = $req->fetchAll();
  return $res;
}

/*
 * Récupère un artiste de la base de données
 * spécifier par l'identifiant 'idArtiste'.
 * Renvoie le résultat, il est unique.
 * Sinon renvoie la valeur null.
 */
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

/*
 * Ajoute un nouvel artiste à la base de données
 * avec un nom, prénom, nom de scéne, date de naissance, url d'une image
 * et une description de l'artiste.
 * Renvoie si l'opération d'ajout c'est bien exécuté.
 */
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

/*
 * Modifier un artiste existant dans la base de données
 * avec un nom, prénom, nom de scéne, date de naissance, url d'une image
 * et une description de l'artiste.
 * Renvoie si l'opération de mdoification c'est bien exécuté.
 */
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

/*
 * Supprime un artiste de la base de données
 * spécifier par l'identifiant 'idArtiste'.
 * Renvoie si l'opération de suppression c'est bien exécuté.
 */
function supprimer_artiste($db, $idArtiste) {
  $req = $db->prepare("DELETE FROM Artiste WHERE idArtiste=:idArtiste;");
  $req->bindParam(':idArtiste', $idArtiste, PDO::PARAM_INT);
  $reqOk = $req->execute();
  return $reqOk;
}
  
?>