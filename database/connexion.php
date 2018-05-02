<?php

/* Installer le paquet php7.0-pgsql
 * Puis activer en décommentant la ligne 
 * extension=php_pgsql.so
 * Redémarer ensuite le serveur apache2
 */
    include_once(dirname(__FILE__).'/../functions/variables.php');
    include_once(dirname(__FILE__).'/../database/connexion.php');

    if ( !isset($db) ) {
        $db_name = $info['database']['postgres']['db_name'];
        $db_host = $info['database']['postgres']['db_host'];
        $db_user = $info['database']['postgres']['db_user'];
        $db_pwd = $info['database']['postgres']['db_pwd'];
        
        try {
            $db = new PDO("pgsql:dbname=$db_name;host=$db_host", $db_user, $db_pwd);
        }
        catch(Exception $e)  {
            die('Une erreur c\'est produit avec la base de données.<br>Merci de contacter un administrateur.');
        } 
    }

?>