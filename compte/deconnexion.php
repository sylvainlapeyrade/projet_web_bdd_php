<?php
    session_start();
    include_once(dirname(__FILE__).'/../functions/base.php');

    if( !is_connect() ) {leave();}

    session_destroy();
    header('Location: /index.php');

?>