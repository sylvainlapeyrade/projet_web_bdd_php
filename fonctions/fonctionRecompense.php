<?php

/**
 * FICHIER : FUNCTIONS -> fonctionRecompense.php
 * Fichier des fonctions de gestion des récompenses.
 */

/**
 * Récupère toutes les récompenses de la BDD en les triant
 * par ordre alphabétique par leur nom
 * @param $db PDO Instance PDO de connexion à la BDD
 * @return array Toutes les récompenses dans la BDD.
 */
function recuperer_recompense_tous($db) {
    $req = $db->prepare("SELECT * FROM Recompense ORDER BY nomRecompense ASC");
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Récupère une récompense de la BDD
 * spécifier par l'identifiant 'idRecompense'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idRecompense Int Identifiant de la récompense
 * @return array La récompense correspondant à l'id
 */
function recupere_recompense($db, $idRecompense) {
    $req = $db->prepare("SELECT * FROM Recompense WHERE idRecompense=:idRecompense");
    $req->bindParam(':idRecompense', $idRecompense);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Ajoute une nouvelle récompense à la BDD avec un nom, une
 * date d'attribution, et une description de la récompense
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $nomRecompense String Nom de la récompense
 * @param $dateRecompense String Date d'attribution de la récompense
 * @param $descriptionRecompense String Description de la récompense
 * @return Int idRecompense si la requête s'est bien exécutée | Null Sinon
 */
function ajouter_recompense($db, $nomRecompense, $dateRecompense, $descriptionRecompense) {
    $req = $db->prepare("INSERT INTO Recompense(nomRecompense, dateRecompense, descriptionRecompense)
      VALUES(:nomRecompense, :dateRecompense, :descriptionRecompense);");
    $req->bindParam(':nomRecompense', $nomRecompense, PDO::PARAM_STR);
    $req->bindParam(':dateRecompense', format_date($dateRecompense));
    $req->bindParam(':descriptionRecompense', $descriptionRecompense, PDO::PARAM_STR);
    $reqOk = $req->execute();
    if ( $reqOk ) {
        $idRecompense = $db->lastInsertId();
        return $idRecompense;
    }
    return null;
}

/**
 * Modifie une récompense existante dans la BDD avec un nom, une
 * date d'attribution, et une description de la récompense
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idRecompense Int Identifiant de la récompense
 * @param $nomRecompense String Nom de la récompense
 * @param $dateRecompense String Date d'attribution de la récompense
 * @param $descriptionRecompense String Description de la récompense
 * @return True si la requête s'est bien exécutée | False Sinon
 */
function modifier_recompense($db, $idRecompense, $nomRecompense, $dateRecompense, $descriptionRecompense) {
    $req = $db->prepare("UPDATE Recompense SET nomRecompense=:nomRecompense, dateRecompense=:dateRecompense,
 descriptionRecompense=:descriptionRecompense WHERE idRecompense=:idRecompense;");
    $req->bindParam(':idRecompense', $idRecompense, PDO::PARAM_INT);
    $req->bindParam(':nomRecompense', $nomRecompense, PDO::PARAM_STR);
    $req->bindParam(':dateRecompense', format_date($dateRecompense));
    $req->bindParam(':descriptionRecompense', $descriptionRecompense, PDO::PARAM_STR);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Supprime une récompense de la BDD
 * spécifier par l'identifiant 'idRecompense'.
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idRecompense Int Identifiant de la récompense
 * @return True si la suppression s'est bien exécutée | False Sinon
 */
function supprimer_recompense($db, $idRecompense) {
    $req = $db->prepare("DELETE FROM Recompense WHERE idRecompense=:idRecompense;");
    $req->bindParam(':idRecompense', $idRecompense, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Récupère les associations d'artistes et d'une récompense
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idRecompenseOa Int Identifiant de la récompense dans Obtenir_Artiste
 * @return array Association d'artistes et d'une récompense
 */
function recuperer_obtenir_recompense($db, $idRecompenseOa) {
    $req = $db->prepare("SELECT * FROM Obtenir_Artiste WHERE idRecompenseOa=:idRecompenseOa");
    $req->bindParam(':idRecompenseOa', $idRecompenseOa, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll();
    return $res;
}

/**
 * Ajoute une association entre un artiste et une récompense
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idRecompenseOa Int Identifiant de la récompense dans Obtenir_Artiste
 * @param $idArtisteOa Int Identifiant artiste dans Obtenir_Artiste
 * @return True si la requête s'est bien exécutée | False sinon
 */
function ajouter_obtenir_recompense($db, $idRecompenseOa, $idArtisteOa) {
    $req = $db->prepare("INSERT INTO Obtenir_Artiste(idRecompenseOa, idArtisteOa)
      VALUES(:idRecompenseOa, :idArtisteOa);");
    $req->bindParam(':idRecompenseOa', $idRecompenseOa, PDO::PARAM_INT);
    $req->bindParam(':idArtisteOa', $idArtisteOa, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

/**
 * Supprime tous les artistes associées à une récompense
 * spécifié par l'identifiant "idRecompense"
 * @param $db PDO Instance PDO de connexion à la BDD
 * @param $idRecompenseOa Int Identifiant de la récompense dans Obtenir_Artiste
 * @return True si la requête s'est bien exécutée | False sinon
 */
function supprimer_obtenir_recompense_tous($db, $idRecompenseOa) {
    $req = $db->prepare("DELETE FROM Obtenir_Artiste WHERE idRecompenseOa=:idRecompenseOa;");
    $req->bindParam(':idRecompenseOa', $idRecompenseOa, PDO::PARAM_INT);
    $reqOk = $req->execute();
    return $reqOk;
}

?>