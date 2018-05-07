<?php

include_once(dirname(__FILE__).'/connexion.php');

$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

var_dump($db->exec(file_get_contents('./structure.sql')));
var_dump($db->exec(file_get_contents('./population.sql')));

?>
