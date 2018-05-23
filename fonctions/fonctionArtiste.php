<?php
/**
 * FICHIER : FUNCTIONS -> fonctionArtiste.php
 * Fichier des fonction de gestion des artistes.
 */

/**
 * Recupere les musiques d'un artiste avec leur numero de piste
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idArtiste Int Identifiant artiste dans Assembler_Album
 * @return array Association des musique et de leur compositeur
 */
function recuperer_musique_artiste($db, $idArtiste) {
    $req = $db->prepare("SELECT * FROM Composer_Musique, Musique WHERE Composer_Musique.idArtisteCoMu=:idArtiste AND Composer_Musique.idMusiqueCoMu = Musique.idMusique ORDER BY Musique.titreMusique ASC;");
    $req->bindParam(':idArtiste', $idArtiste, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Recupere les groupes d'un artiste
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idArtiste Int Identifiant artiste dans Assembler_Album
 * @return array Association des albums et de leur compositeur
 */
function recuperer_groupe_artiste($db, $idArtiste) {
    $req = $db->prepare("SELECT * FROM Constituer, Groupe WHERE Constituer.idArtisteCo=:idArtiste AND Groupe.idGroupe=Constituer.idGroupeCo ORDER BY Groupe.nomGroupe ASC;");
    $req->bindParam(':idArtiste', $idArtiste, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Recupere les recompense d'un artiste
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idArtiste Int Identifiant artiste dans Assembler_Album
 * @return array Association des récompense et de leur artistes
 */
function recuperer_recompense_artiste($db, $idArtiste) {
    $req = $db->prepare("SELECT * FROM Obtenir_Artiste, Recompense WHERE Obtenir_Artiste.idArtisteOa=:idArtiste AND Obtenir_Artiste.idRecompenseOa=recompense.idRecompense ORDER BY Recompense.dateRecompense DESC;");
    $req->bindParam(':idArtiste', $idArtiste, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Recupere les musique d'un artiste ainsi que les albums associés
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idArtiste Int Identifiant artiste dans Assembler_Album
 * @return array Association des musique et de leur artistes et des albums
 */
function recuperer_musique_album_artiste($db, $idArtiste) {
    $req = $db->prepare("SELECT * FROM Musique, Composer_Musique, Assembler_Album, Album WHERE Composer_Musique.idArtisteCoMu=:idArtiste AND Composer_Musique.idMusiqueCoMu=Musique.idMusique AND Assembler_Album.idMusiqueAa=Musique.idMusique AND Assembler_Album.idAlbumAa=Album.idAlbum;");
    $req->bindParam(':idArtiste', $idArtiste, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Récupère tout les artistes de la BDD en les triant
 * par ordre alphabétique par le nom puis le prenom.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @return array Tous les artistes dans la BDD.
 */
function recuperer_artiste_tous($db) {
    $req = $db->prepare("SELECT * FROM Artiste ORDER BY nomArtiste, prenomArtiste ASC");
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/***
 * Récupère un artiste de la BDD
 * spécifier par l'identifiant 'idArtiste'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idArtiste Int Identifiant de l'artiste
 * @return array L'artiste correspondant à l'id
 */
function recuperer_artiste($db, $idArtiste) {
    $req = $db->prepare("SELECT * FROM Artiste WHERE idArtiste=:idArtiste");
    $req->bindParam(':idArtiste', $idArtiste);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Ajoute un nouvel artiste à la BDD avec un nom, prénom,
 * nom de scéne, date de naissance, url d'une image
 * et une description de l'artiste.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $nomArtiste String nom de l'artiste
 * @param $prenomArtiste String prenom de l'artiste
 * @param $nomScene String Nom de scene de l'artiste
 * @param $dateNaissanceArtiste String Date de naissance de l'artiste
 * @param $urlImageArtiste String URL dune image de l'artiste
 * @param $descriptionArtiste String Description de l'artiste
 * @return True si la requête s'est bien exécutée | False Sinon
 */
function ajouter_artiste($db, $nomArtiste, $prenomArtiste, $nomScene, $dateNaissanceArtiste,  $urlImageArtiste, $descriptionArtiste) {
    $req = $db->prepare("INSERT INTO Artiste(nomArtiste, prenomArtiste, nomScene, dateNaissanceArtiste, urlImageArtiste, descriptionArtiste) VALUES(:nomArtiste, :prenomArtiste, :nomScene, :dateNaissanceArtiste, :urlImageArtiste, :descriptionArtiste);");
    $req->bindParam(':nomArtiste', $nomArtiste, PDO::PARAM_STR);
    $req->bindParam(':prenomArtiste', $prenomArtiste, PDO::PARAM_STR);
    $req->bindParam(':nomScene', $nomScene, PDO::PARAM_STR);
    $req->bindParam(':dateNaissanceArtiste', format_date($dateNaissanceArtiste));
    $req->bindParam(':urlImageArtiste', $urlImageArtiste, PDO::PARAM_STR);
    $req->bindParam(':descriptionArtiste', $descriptionArtiste, PDO::PARAM_STR);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Modifie un artiste existant dans la BDD avec un
 * nom, prénom, nom de scéne, date de naissance, url d'une image
 * et une description de l'artiste.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idArtiste Int Identifiant de l'artiste
 * @param $nomArtiste String nom de l'artiste
 * @param $prenomArtiste String prenom de l'artiste
 * @param $nomScene String Nom de scene de l'artiste
 * @param $dateNaissanceArtiste String Date de naissance de l'artiste
 * @param $urlImageArtiste String URL dune image de l'artiste
 * @param $descriptionArtiste String Description de l'artiste
 * @return True si la requête s'est bien exécutée | False Sinon
 */
function modifier_artiste($db, $idArtiste, $nomArtiste, $prenomArtiste, $nomScene, $dateNaissanceArtiste,  $urlImageArtiste, $descriptionArtiste) {
    $req = $db->prepare("UPDATE Artiste SET nomArtiste=:nomArtiste, prenomArtiste=:prenomArtiste, nomScene=:nomScene, dateNaissanceArtiste=:dateNaissanceArtiste, urlImageArtiste=:urlImageArtiste, descriptionArtiste=:descriptionArtiste WHERE idArtiste=:idArtiste;");
    $req->bindParam(':idArtiste', $idArtiste, PDO::PARAM_INT);
    $req->bindParam(':nomArtiste', $nomArtiste, PDO::PARAM_STR);
    $req->bindParam(':prenomArtiste', $prenomArtiste, PDO::PARAM_STR);
    $req->bindParam(':nomScene', $nomScene, PDO::PARAM_STR);
    $req->bindParam(':dateNaissanceArtiste', format_date($dateNaissanceArtiste));
    $req->bindParam(':urlImageArtiste', $urlImageArtiste, PDO::PARAM_STR);
    $req->bindParam(':descriptionArtiste', $descriptionArtiste, PDO::PARAM_STR);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Supprime un artiste de la BDD
 * spécifié par l'identifiant 'idArtiste'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idArtiste Int Identifiant de l'artiste
 * @return True si toutes les suppression se sont bien exécutées | False Sinon
 */
function supprimer_artiste($db, $idArtiste) {
    $req = $db->prepare("DELETE FROM Artiste WHERE idArtiste=:idArtiste;");
    $req->bindParam(':idArtiste', $idArtiste, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

?>