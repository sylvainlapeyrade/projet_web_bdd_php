<?php

include_once(dirname(__FILE__).'/connexion.php');

$db->exec(file_get_contents('./structure.sql'));
$db->exec(file_get_contents('./population.sql'));

?>
