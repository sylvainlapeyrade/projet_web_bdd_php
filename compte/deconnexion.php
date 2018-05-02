<?php
    session_start();
    include_once(dirname(__FILE__) . '/../fonctions/fonction_compte.php');

    if( !is_connect() ) {leave();}

    session_destroy();
    header('Location: /index.php');

?>