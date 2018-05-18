<?php

/**
 * FICHIER : FUNCTIONS -> fonctionAlbum.php
 * Fichier des fonctions de gestion d'album.
 */

/**
 * Recupere les artistes d'un album
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbum Int Identifiant album dans Assembler_Album
 * @return array Association des albums et de leur compositeur artistes
 */
function recuperer_artiste_album($db, $idAlbum) {
    $req = $db->prepare("SELECT * FROM Composer_Album, Artiste WHERE Composer_Album.idAlbumCoAl=:idAlbum AND Composer_Album.idArtisteCoAl = Artiste.idArtiste ORDER BY Artiste.nomArtiste ASC, Artiste.prenomArtiste ASC;");
    $req->bindParam(':idAlbum', $idAlbum, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Recupere les groupes d'un album
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbum Int Identifiant album dans Assembler_Album
 * @return array Association des albums et de leur compositeur groupe
 */
function recuperer_groupe_album($db, $idAlbum) {
    $req = $db->prepare("SELECT * FROM Composer_AlbumGr, Groupe WHERE Composer_AlbumGr.idAlbumCoAr=:idAlbum AND Composer_AlbumGr.idGroupeCoAr = Groupe.idGroupe ORDER BY Groupe.nomGroupe ASC;");
    $req->bindParam(':idAlbum', $idAlbum, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Recupere les artiste d'un album
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbum Int Identifiant album dans Assembler_Album
 * @return array Association des albums et de leur compositeur
 */
function recuperer_musique_album($db, $idAlbum) {
    $req = $db->prepare("SELECT * FROM Assembler_Album, Musique WHERE Assembler_Album.idAlbumAa=:idAlbum AND Assembler_Album.idMusiqueAa = Musique.idMusique ORDER BY numeroPiste ASC, titreMusique ASC;");
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
 * @return array L'utilisateur correspondant a l'id
 */
function recuperer_album($db, $idAlbum) {
    $req = $db->prepare("SELECT * FROM Album WHERE idAlbum=:idAlbum");
    $req->bindParam(':idAlbum', $idAlbum);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Ajoute un nouvel utilisateur dans la BDD
 * avec un id, un mdp et un statut
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $nomAlbum String Nom de l'album
 * @param $dateAlbum String Date de sortie de l'album
 * @param $descriptionAlbum String Desciption de l'album
 * @param $urlPochetteAlbum String URL de la jaquette de l'album
 * @return int L'id de la recompense si la requête s'est bien exécutée | Null sinon
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
 * @param $dateAlbum String Date de sortie de l'album
 * @param $descriptionAlbum String Desciption de l'album
 * @param $urlPochetteAlbum String URL de la jaquette de l'album
 * @return True si la requête s'est bien exécutée | False sinon
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
 * Récupère les associations d'album et leur compositeur
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
 * @return True si la requête s'est bien exécutée | False sinon
 */
function ajouter_composer_album($db, $idAlbumCoAl, $idArtisteCoAl) {
    $req = $db->prepare("INSERT INTO Composer_Album(idAlbumCoAl, idArtisteCoAl) VALUES(:idAlbumCoAl, :idArtisteCoAl);");
    $req->bindParam(':idAlbumCoAl', $idAlbumCoAl, PDO::PARAM_INT);
    $req->bindParam(':idArtisteCoAl', $idArtisteCoAl, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Supprime toutes les associations de la table Composer_Album
 * spécifiées par l'identifiant 'idAlbumCoAl'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbumCoAl Int Identifiant album dans Composer_Album
 * @return True si la requête s'est bien exécutée | False sinon
 */
function supprimer_composer_album_tous($db, $idAlbumCoAl) {
    $req = $db->prepare("DELETE FROM Composer_Album WHERE idAlbumCoAl=:idAlbumCoAl;");
    $req->bindParam(':idAlbumCoAl', $idAlbumCoAl, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Récupère les associations d'album et leur groupe
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbumCoAr Int Identifiant album dans Composer_AlbumGr
 * @return array Association des albums et de leur groupe
 */
function recuperer_composer_albumGr($db, $idAlbumCoAr) {
    $req = $db->prepare("SELECT * FROM Composer_AlbumGr WHERE idAlbumCoAr=:idAlbumCoAr");
    $req->bindParam(':idAlbumCoAr', $idAlbumCoAr, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Ajoute une association entre un album et son groupe
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbumCoAr Int Identifiant album dans Composer_AlbumGr
 * @param $idGroupeCoAr Int Identifiant groupe dans Composer_AlbumGr
 * @return True si la requête s'est bien exécutée | False sinon
 */
function ajouter_composer_albumGr($db, $idAlbumCoAr, $idGroupeCoAr) {
    $req = $db->prepare("INSERT INTO Composer_AlbumGr(idAlbumCoAr, idGroupeCoAr) VALUES(:idAlbumCoAr, :idGroupeCoAr);");
    $req->bindParam(':idAlbumCoAr', $idAlbumCoAr, PDO::PARAM_INT);
    $req->bindParam(':idGroupeCoAr', $idGroupeCoAr, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Supprime toutes les associations de la table Composer_AlbumGr
 * spécifiées par l'identifiant 'idAlbumCoAr'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbumCoAr Int Identifiant album dans Composer_AlbumGr
 * @return True si la requête s'est bien exécutée | False sinon
 */
function supprimer_composer_albumGr_tous($db, $idAlbumCoAr) {
    $req = $db->prepare("DELETE FROM Composer_AlbumGr WHERE idAlbumCoAr=:idAlbumCoAr;");
    $req->bindParam(':idAlbumCoAr', $idAlbumCoAr, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Récupère une associations de musiques et album
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbumAa Int Identifiant album dans Assembler_Album
 * @param $idMusiqueAa Int Identifiant musique dans Assembler_Album
 * @return array Association des musiques et album
 */
function recuperer_assembler_album($db, $idAlbumAa, $idMusiqueAa) {
    $req = $db->prepare("SELECT * FROM Assembler_Album WHERE idAlbumAa=:idAlbumAa AND idMusiqueAa=:idMusiqueAa");
    $req->bindParam(':idMusiqueAa', $idMusiqueAa, PDO::PARAM_INT);
    $req->bindParam(':idAlbumAa', $idAlbumAa, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Ajoute une association entre une musique et un album
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueAa Int Identifiant musique dans Assembler_Album
 * @param $idAlbumAa Int Identifiant album dans Assembler_Album
 * @param $numeroPiste Int Numero de la musique dans l'album
 * @return True si la requête s'est bien exécutée | False sinon
 */
function ajouter_assembler_album($db, $idAlbumAa, $idMusiqueAa, $numeroPiste) {
    $req = $db->prepare("INSERT INTO Assembler_Album(idMusiqueAa, idAlbumAa, numeroPiste) VALUES(:idMusiqueAa, :idAlbumAa, :numeroPiste);");
    $req->bindParam(':idMusiqueAa', $idMusiqueAa, PDO::PARAM_INT);
    $req->bindParam(':idAlbumAa', $idAlbumAa, PDO::PARAM_INT);
    $req->bindParam(':numeroPiste', $numeroPiste, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Modifie une association entre une musique et un album
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueAa Int Identifiant musique dans Assembler_Album
 * @param $idAlbumAa Int Identifiant album dans Assembler_Album
 * @param $numeroPiste Int Numero de la musique dans l'album
 * @return True si la requête s'est bien exécutée | False sinon
 */
function modifier_assembler_album($db, $idAlbumAa, $idMusiqueAa, $numeroPiste) {
    $req = $db->prepare("UPDATE Assembler_Album SET numeroPiste=:numeroPiste WHERE idAlbumAa=:idAlbumAa AND idMusiqueAa=:idMusiqueAa;");
    $req->bindParam(':numeroPiste', $numeroPiste, PDO::PARAM_INT);
    $req->bindParam(':idAlbumAa', $idAlbumAa, PDO::PARAM_INT);
    $req->bindParam(':idMusiqueAa', $idMusiqueAa, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Supprime toutes les associations de la table Assembler_Album
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idMusiqueAa Int Identifiant musique dans Assembler_Album
 * @param $idAlbumAa Int Identifiant album dans Assembler_Album
 * @return True si la requête s'est bien exécutée | False sinon
 */
function supprimer_assembler_album($db, $idAlbumAa, $idMusiqueAa) {
    $req = $db->prepare("DELETE FROM Assembler_Album WHERE idAlbumAa=:idAlbumAa AND idMusiqueAa=:idMusiqueAa;");
    $req->bindParam(':idAlbumAa', $idAlbumAa, PDO::PARAM_INT);
    $req->bindParam(':idMusiqueAa', $idMusiqueAa, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Supprime toutes les associations de la table Assembler_Album
 * spécifié par l'identifiant 'idAlbumAa'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idAlbumAa Int Identifiant album dans Assembler_Album
 * @return True si la requête s'est bien exécutée | False sinon
 */
function supprimer_assembler_album_tous($db, $idAlbumAa) {
    $req = $db->prepare("DELETE FROM Assembler_Album WHERE idAlbumAa=:idAlbumAa;");
    $req->bindParam(':idAlbumAa', $idAlbumAa, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

?>