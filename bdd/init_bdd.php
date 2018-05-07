<?php

include_once(dirname(__FILE__).'/connexion.php');

if ( isset($db)){
    var_dump($db->exec(file_get_contents('./structure.sql')));
    var_dump($db->exec(file_get_contents('./population.sql')));
}
