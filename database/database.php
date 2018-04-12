<?php

include_once(dirname(__FILE__).'/connexion.php');
include_once(dirname(__FILE__).'/../functions/base.php');

if ( !isset($_GET['name']) || $_GET['name'] != 'admin' ) { leave(); }

$file = file_get_contents('./structure.sql');

echo $file;

$db->exec($file);

?>
