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
        if ( $_SESSION['statut'] == 1 ) {
            return true;
        }
    }
    return false;
}

/**
 * Fonction qui vérifie si un formulaire passé en paramètre est
 * est valide ou non.
 * Un formulaire valide est définit par un formulaire non vide
 */
function check_param($form) {
    if ( empty($form) ) {
        return false;
    }
    foreach($form as $var) {
        if ( empty($var) ) {
            return false;
        }
    }
    return true;
}

?>
