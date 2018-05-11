<?php

function rechercher($db, $recherche) {
    $req = $db->prepare("SELECT * FROM Artiste WHERE nomArtiste=:nomArtiste OR prenomArtiste=:prenomArtiste");
    $req->bindParam(':nomArtiste', $recherche);
    $req->bindParam(':prenomArtiste', $recherche);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

?>