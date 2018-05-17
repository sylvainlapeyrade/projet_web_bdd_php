<?php

/**
 * FICHIER : FUNCTIONS -> fonctionMusique.php
 * Fichier des fonctions de gestion des musiques.
 */

/**
 * Récupère les artiste d'une musique
 * spécifier par l'identifiant 'idMusique'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusique Int Identifiant de la musique
 * @return array Artistes de la musique
 */
function recuperer_artiste_musique($db, $idMusique) {
    $req = $db->prepare("SELECT * FROM Composer_Musique, Artiste 
WHERE Composer_Musique.idMusiqueCoMu=:idMusique AND Composer_Musique.idArtisteCoMu=Artiste.idArtiste;");
    $req->bindParam(':idMusique', $idMusique);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Récupère tout les musiques de la BDD en les triant
 * par ordre alphabétique par leur titre
 * @param $db PDO Instance PDO de connexion à la BDD
 * @return array Toutes les musiques dans la BDD.
 */
function recuperer_musique_tous($db) {
    $req = $db->prepare("SELECT * FROM Musique ORDER BY titreMusique ASC");
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Récupère une musique de la BDD
 * spécifier par l'identifiant 'idMusique'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusique Int Identifiant de la musique
 * @return array La musique correspondant à l'id
 */
function recuperer_musique($db, $idMusique) {
    $req = $db->prepare("SELECT * FROM Musique WHERE idMusique=:idMusique");
    $req->bindParam(':idMusique', $idMusique);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Ajoute une nouvelle musique à la BDD avec un titre, duree,
 * date de sortie et une description de la musique.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $titreMusique String titre de la musique
 * @param $dureeMusique Int duree de la musique
 * @param $dateMusique String Date de sorite de la musique
 * @param $descriptionMusique String Description de la musique
 * @return Int idMusique si la requête s'est bien exécutée | Null Sinon
 */
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

/**
 * Modifie une musique existante dans la BDD avec un titre, duree,
 * date de sortie et une description de la musique.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusique Int Identifiant de la musique
 * @param $titreMusique String titre de la musique
 * @param $dureeMusique Int duree de la musique
 * @param $dateMusique String Date de sorite de la musique
 * @param $descriptionMusique String Description de la musique
 * @return True si la requête s'est bien exécutée | False Sinon
 */
function modifier_musique($db, $idMusique, $titreMusique, $dureeMusique, $dateMusique, $descriptionMusique) {
    $req = $db->prepare("UPDATE Musique SET titreMusique=:titreMusique, dureeMusique=:dureeMusique, 
dateMusique=:dateMusique, descriptionMusique=:descriptionMusique WHERE idMusique=:idMusique;");
    $req->bindParam(':idMusique', $idMusique, PDO::PARAM_INT);
    $req->bindParam(':titreMusique', $titreMusique, PDO::PARAM_STR);
    $req->bindParam(':dureeMusique', $dureeMusique, PDO::PARAM_INT);
    $req->bindParam(':dateMusique', format_date($dateMusique));
    $req->bindParam(':descriptionMusique', $descriptionMusique, PDO::PARAM_STR);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Supprime une musique de la BDD
 * spécifiée par l'identifiant 'idMusique'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusique Int Identifiant de la musique
 * @return True si la suppression s'est bien exécutée | False Sinon
 */
function supprimer_musique($db, $idMusique) {
    $req = $db->prepare("DELETE FROM Musique WHERE idMusique=:idMusique;");
    $req->bindParam(':idMusique', $idMusique, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Recupere les associations de musiques et leur artiste
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueCoMu Int Identifiant musique dans Composer_Musique
 * @return array Association des musiques et de leur compositeur
 */
function recuperer_composer_musique($db, $idMusiqueCoMu) {
    $req = $db->prepare("SELECT * FROM Composer_Musique WHERE idMusiqueCoMu=:idMusiqueCoMu");
    $req->bindParam(':idMusiqueCoMu', $idMusiqueCoMu, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Ajoute une association entre une musique et son artiste
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueCoMu Int Identifiant musique dans Composer_Musique
 * @param $idArtisteCoMu Int Identifiant artiste dans Composer_Musique
 * @return True si la requête s'est bien exécutée | False sinon
 */
function ajouter_composer_musique($db, $idMusiqueCoMu, $idArtisteCoMu) {
    $req = $db->prepare("INSERT INTO Composer_Musique(idMusiqueCoMu, idArtisteCoMu)
      VALUES(:idMusiqueCoMu, :idArtisteCoMu);");
    $req->bindParam(':idMusiqueCoMu', $idMusiqueCoMu, PDO::PARAM_INT);
    $req->bindParam(':idArtisteCoMu', $idArtisteCoMu, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Supprime toutes les association de la table Composer_Musique
 * spécifié par l'identifiant 'idMusiqueCoMu'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueCoMu Int Identifiant album dans Composer_Musique
 * @return True si la requête s'est bien exécutée | False sinon
 */
function supprimer_composer_musique_tous($db, $idMusiqueCoMu) {
    $req = $db->prepare("DELETE FROM Composer_Musique WHERE idMusiqueCoMu=:idMusiqueCoMu;");
    $req->bindParam(':idMusiqueCoMu', $idMusiqueCoMu, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Recupere les associations de musiques et leur groupe
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueCoMr Int Identifiant groupe dans Composer_MusiqueGr
 * @return array Association des musiques et de leur compositeur
 */
function recuperer_composer_musiqueGr($db, $idMusiqueCoMr) {
    $req = $db->prepare("SELECT * FROM Composer_MusiqueGr WHERE idMusiqueCoMr=:idMusiqueCoMr");
    $req->bindParam(':idMusiqueCoMr', $idMusiqueCoMr, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Ajoute une association entre une musique et son groupe
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueCoMr Int Identifiant musique dans Composer_MusiqueGr
 * @param $idGroupeCoMr Int Identifiant groupe dans Composer_MusiqueGr
 * @return True si la requête s'est bien exécutée | False sinon
 */
function ajouter_composer_musiqueGr($db, $idMusiqueCoMr, $idGroupeCoMr) {
    $req = $db->prepare("INSERT INTO Composer_MusiqueGr(idMusiqueCoMr, idGroupeCoMr)
      VALUES(:idMusiqueCoMu, :idArtisteCoMu);");
    $req->bindParam(':idMusiqueCoMr', $idMusiqueCoMr, PDO::PARAM_INT);
    $req->bindParam(':idGroupeCoMr', $idGroupeCoMr, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Supprime toutes les association de la table Composer_MusiqueGr
 * spécifié par l'identifiant 'idMusiqueCoMr'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueCoMr Int Identifiant album dans Composer_MusiqueGr
 * @return True si la requête s'est bien exécutée | False sinon
 */
function supprimer_composer_musique_tousGr($db, $idMusiqueCoMr) {
    $req = $db->prepare("DELETE FROM Composer_MusiqueGr WHERE idMusiqueCoMr=:idMusiqueCoMr;");
    $req->bindParam(':idMusiqueCoMr', $idMusiqueCoMr, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

?>