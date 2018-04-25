<?php

include_once(dirname(__FILE__).'/connexion.php');
include_once(dirname(__FILE__).'/../functions/base.php');

$db->exec(file_get_contents('./structure.sql'));
$db->exec(file_get_contents('./population.sql'));

?>
