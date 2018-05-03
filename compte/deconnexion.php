<?php
    session_start();
    include_once(dirname(__FILE__).'/../fonctions/fonctionCompte.php');

    if( !is_connect() ) {leave();}

    session_destroy();
    header('Location: /index.php');

?>