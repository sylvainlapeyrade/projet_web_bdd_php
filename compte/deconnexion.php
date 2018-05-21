<?php
/**
 * Page deconnexion.php
 * Ferme la session quand on active le bouton "Deconnexion"
 */

    session_start();
    include_once(dirname(__FILE__).'/../fonctions/fonctionCompte.php');

    if( !is_connect() ) {leave();}

    session_destroy();
    header('Location: '.$_SERVER['HTTP_REFERER']);

?>