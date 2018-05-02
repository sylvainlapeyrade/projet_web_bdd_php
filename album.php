<?php
    session_start();
    include_once(dirname(__FILE__) . '/fonctions/variables.php');
    include_once(dirname(__FILE__) . '/fonctions/base.php');
    include_once(dirname(__FILE__) . '/fonctions/fonction_album.php');
    include_once(dirname(__FILE__) . '/bdd/connexion.php');

    $info['head']['subTitle'] = "Page album";
    $info['head']['stylesheets'] = ['album.css'];

    include_once(dirname(__FILE__).'/head.php');
?>


