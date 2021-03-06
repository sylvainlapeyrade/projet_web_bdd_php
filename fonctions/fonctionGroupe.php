<?php

/**
 * @file fonctions/fonctionGroupe.php
 * @brief Fichier des fonctions de gestion des groupes.
 */

/**
 * @brief Récupère les musiques d'un groupe
 * spécifié par l'identifiant 'idGroupe'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idGroupe Int Identifiant du groupe
 * @return array Les artistes qui compose le groupe
 */
function recuperer_musique_groupe($db, $idGroupe) {
    $req = $db->prepare("SELECT * FROM Composer_MusiqueGr, Musique WHERE Composer_MusiqueGr.idGroupeCoMr=:idGroupe AND Composer_MusiqueGr.idMusiqueCoMr=Musique.idMusique ORDER BY Musique.titreMusique ASC;");
    $req->bindParam(':idGroupe', $idGroupe);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * @brief Récupère les artistes d'un groupe
 * spécifié par l'identifiant 'idGroupe'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idGroupe Int Identifiant du groupe
 * @return array Les artistes qui compose le groupe
 */
function recuperer_artiste_groupe($db, $idGroupe) {
    $req = $db->prepare("SELECT * FROM Constituer, Artiste WHERE Constituer.idGroupeCo=:idGroupe AND Constituer.idArtisteCo=Artiste.idArtiste ORDER BY Artiste.nomArtiste ASC, Artiste.prenomArtiste ASC;");
    $req->bindParam(':idGroupe', $idGroupe);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * @brief Recupere les musique d'un groupe ainsi que les albums associés
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idGroupe Int Identifiant groupe dans Assembler_Album
 * @return array Association des musique et de leur groupe et des albums
 */
function recuperer_musique_album_groupe($db, $idGroupe) {
    $req = $db->prepare("SELECT * FROM Album, Musique, Composer_MusiqueGr, Assembler_Album WHERE Composer_MusiqueGr.idGroupeCoMr=:idGroupe AND Composer_MusiqueGr.idMusiqueCoMr=Musique.idMusique AND Assembler_Album.idMusiqueAa=Musique.idMusique AND Assembler_Album.idAlbumAa=Album.idAlbum ORDER BY Musique.titreMusique ASC;");
    $req->bindParam(':idGroupe', $idGroupe, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * @brief Récupère tout les groupes de la BDD en les triant
 * par ordre alphabétique par leur nom de groupe
 * @param $db PDO Instance PDO de connexion à la BDD
 * @return array Toutes les musiques dans la BDD.
 */
function recuperer_groupe_tous($db) {
    $req = $db->prepare("SELECT * FROM Groupe ORDER BY nomGroupe ASC");
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * @brief Récupère un groupe de la BDD
 * spécifié par l'identifiant 'idGroupe'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idGroupe Int Identifiant du groupe
 * @return array Le groupe correspondant à l'id
 */
function recuperer_groupe($db, $idGroupe) {
    $req = $db->prepare("SELECT * FROM Groupe WHERE idGroupe=:idGroupe");
    $req->bindParam(':idGroupe', $idGroupe);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * @brief Ajoute un nouveau  groupe à la BDD avec un nom, une date de création,
 * une description et l'URL de la jaquette du groupe
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $nomGroupe String Nom du groupe
 * @param $dateGroupe String Date de création du groupe
 * @param $descriptionGroupe String Description du groupe
 * @param $urlImageGroupe String URL de la jaquette du groupe
 * @return Int idGroupe si la requête s'est bien exécutée | Null Sinon
 */
function ajouter_groupe($db, $nomGroupe, $dateGroupe, $descriptionGroupe, $urlImageGroupe) {
    $req = $db->prepare("INSERT INTO Groupe(nomGroupe, dateGroupe, descriptionGroupe, urlImageGroupe) VALUES(:nomGroupe, :dateGroupe, :descriptionGroupe, :urlImageGroupe);");
    $req->bindParam(':nomGroupe', $nomGroupe, PDO::PARAM_STR);
    $req->bindParam(':dateGroupe', format_date($dateGroupe));
    $req->bindParam(':descriptionGroupe', $descriptionGroupe, PDO::PARAM_STR);
    $req->bindParam(':urlImageGroupe', $urlImageGroupe, PDO::PARAM_STR);
    $reqOk = $req->execute();
    if ( $reqOk ) {
        $idGroupe = $db->lastInsertId();
        return $idGroupe;
    }
    return null;
}

/**
 * @brief Modifie un groupe existant dans la BDD avec un nom, une date de création,
 * une description et l'URL de la jaquette du groupe
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idGroupe Int Identifiant du groupe
 * @param $nomGroupe String Nom du groupe
 * @param $dateGroupe String Date de création du groupe
 * @param $descriptionGroupe String Description du groupe
 * @param $urlImageGroupe String URL de la jaquette du groupe
 * @return True si la requête s'est bien exécutée | False Sinon
 */
function modifier_groupe($db, $idGroupe, $nomGroupe, $dateGroupe, $descriptionGroupe, $urlImageGroupe) {
    $req = $db->prepare("UPDATE Groupe SET nomGroupe=:nomGroupe, dateGroupe=:dateGroupe, descriptionGroupe=:descriptionGroupe, urlImageGroupe=:urlImageGroupe WHERE idGroupe=:idGroupe;");
    $req->bindParam(':idGroupe', $idGroupe, PDO::PARAM_INT);
    $req->bindParam(':nomGroupe', $nomGroupe, PDO::PARAM_STR);
    $req->bindParam(':dateGroupe', format_date($dateGroupe));
    $req->bindParam(':descriptionGroupe', $descriptionGroupe, PDO::PARAM_STR);
    $req->bindParam(':urlImageGroupe', $urlImageGroupe, PDO::PARAM_STR);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * @brief Supprime un groupe de la BDD
 * spécifié par l'identifiant 'idGroupe'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idGroupe Int Identifiant du groupe
 * @return True si la suppression s'est bien exécutée | False Sinon
 */
function supprimer_groupe($db, $idGroupe) {
    $req = $db->prepare("DELETE FROM Groupe WHERE idGroupe=:idGroupe;");
    $req->bindParam(':idGroupe', $idGroupe, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * @brief Récupère les associations d'un groupe et des artistes le composant
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idGroupeCo Int Identifiant groupe dans Constituer
 * @return array Association d'un groupe et des artistes le composant
 */
function recuperer_constituer_groupe($db, $idGroupeCo) {
    $req = $db->prepare("SELECT * FROM Constituer WHERE idGroupeCo=:idGroupeCo");
    $req->bindParam(':idGroupeCo', $idGroupeCo, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * @brief Ajoute une association entre un groupe et des artistes le composant
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idGroupeCo Int Identifiant groupe dans Constituer
 * @param $idArtisteCo Int Identifiant artiste dans Constituer
 * @return True si la requête s'est bien exécutée | False sinon
 */
function ajouter_constituer_groupe($db, $idGroupeCo, $idArtisteCo) {
    $req = $db->prepare("INSERT INTO Constituer(idGroupeCo, idArtisteCo)
      VALUES(:idGroupeCo, :idArtisteCo);");
    $req->bindParam(':idGroupeCo', $idGroupeCo, PDO::PARAM_INT);
    $req->bindParam(':idArtisteCo', $idArtisteCo, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * @brief Supprime tous les membres d'un groupe spécifié par
 * l'identifiant "idGroupeCo"
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idGroupeCo Int Identifiant groupe dans Constituer
 * @return True si la requête s'est bien exécutée | False sinon
 */
function supprimer_constituer_groupe_tous($db, $idGroupeCo) {
    $req = $db->prepare("DELETE FROM Constituer WHERE idGroupeCo=:idGroupeCo;");
    $req->bindParam(':idGroupeCo', $idGroupeCo, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

?>