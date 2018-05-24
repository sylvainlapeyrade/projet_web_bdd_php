<?php

/**
 * @file fonctions/fonctionRecherche.php
 * @brief Fichier des fonctions de recherche dans la BDD.
 */

/**
 * @brief Renvoie les artistes à partir de leur nom, prénom ou nom de scène
 * On utilise les joker % avant d'utiliser bindParam
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $recherche String Chaîne à rechercher
 * @return array Artistes correspondant à la recherche
 */
function rechercher_artiste($db, $recherche) {
    $recherche = "%$recherche%";
    $req = $db->prepare("SELECT * FROM Artiste WHERE nomArtiste LIKE :recherche OR prenomArtiste LIKE :recherche
 OR nomScene LIKE :recherche ORDER BY nomArtiste ASC,nomScene ASC, prenomArtiste ASC;");
    $req->bindParam(':recherche', $recherche);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * @brief Renvoie les groupes à partir de leur nom
 * On utilise les joker % avant d'utiliser bindParam
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $recherche String Chaîne à rechercher
 * @return array Groupes correspondant à la recherche
 */
function rechercher_groupe($db, $recherche) {
    $recherche = "%$recherche%";
    $req = $db->prepare("SELECT * FROM Groupe WHERE nomGroupe LIKE :recherche ORDER BY nomGroupe ASC;");
    $req->bindParam(':recherche', $recherche);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * @brief Renvoie les albums à partir de leur nom
 * On utilise les joker % avant d'utiliser bindParam
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $recherche String Chaîne à rechercher
 * @return array Albums correspondant à la recherche
 */
function rechercher_album($db, $recherche) {
    $recherche = "%$recherche%";
    $req = $db->prepare("SELECT * FROM Album, Composer_Album, Artiste
	WHERE (Album.nomAlbum LIKE :recherche OR Artiste.nomArtiste LIKE :recherche OR Artiste.prenomArtiste LIKE :recherche OR Artiste.nomScene LIKE :recherche)
	AND Album.idAlbum = Composer_Album.idAlbumCoAl
	AND Composer_Album.idArtisteCoAl = Artiste.idArtiste 
	ORDER BY nomAlbum ASC;");
    $req->bindParam(':recherche', $recherche);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * @brief Renvoie les musiques à partir de leur nom
 * On utilise les joker % avant d'utiliser bindParam
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $recherche String Chaîne à rechercher
 * @return array Musiques correspondant à la recherche
 */
function rechercher_musique($db, $recherche) {
    $recherche = "%$recherche%";
    $req = $db->prepare("SELECT * FROM Musique, Composer_Musique, Artiste 
	WHERE titreMusique LIKE :recherche 
	AND Musique.idMusique=Composer_Musique.idMusiqueCoMu 
	AND Composer_Musique.idArtisteCoMu=Artiste.idArtiste 
	ORDER BY Musique.titreMusique ASC;");
    $req->bindParam(':recherche', $recherche);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

?>