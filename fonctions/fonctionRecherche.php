<?php

/**
 * Renvoie les artistes à partir de leur nom, prénom ou nom de scène
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $recherche String Chaîne à rechercher
 * @return array Artistes correspondant à la recherche
 */
function rechercher($db, $recherche) {
    $req = $db->prepare("SELECT * FROM Artiste 
WHERE nomArtiste=:nomArtiste OR prenomArtiste=:prenomArtiste OR nomscene=:nomScene");
    $req->bindParam(':nomArtiste', $recherche);
    $req->bindParam(':prenomArtiste', $recherche);
    $req->bindParam(':nomScene', $recherche);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

?>