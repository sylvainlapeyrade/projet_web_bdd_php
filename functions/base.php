<?php

/**
 * Fonction qui permet de rediriger l'utilisateur
 * vers la page d'accueil.
 * Est utilisé pour la sécurité de l'application
 */
function leave() {
    header('Location: /index.php');
    exit();
}

function session_active() {
    if ( session_status() == PHP_SESSION_DISABLED ) {
        return false;
    }
    return true;
}

/**
 * Fonction qui vérifie si l'utilisateur est bien connecter
 * Renvoie true si l'utilisateur est connecter.
 * Renvoie false sinon.
 */
function is_connect() {
    if ( !session_active() ) {
        return false;
    }
    if ( isset($_SESSION['idUtilisateur'] ) ) {
        return true;
    }
    return false;
}

/**
 * Fonction qui vérifie si l'utilisateur est connecter
 * et s'il à le statut d'administrateur
 */
function is_admin() {
    if ( is_connect() ) {
        if ( $_SESSION['statut'] ) {
            return true;
        }
    }
    return false;
}

?>
