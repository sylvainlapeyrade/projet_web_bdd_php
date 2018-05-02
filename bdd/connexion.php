<?php

/* Installer le paquet php7.0-pgsql
 * Puis activer en décommentant la ligne 
 * extension=php_pgsql.so
 * Redémarer ensuite le serveur apache2
 */
    include_once(dirname(__FILE__) . '/../fonctions/variables.php');
    include_once(dirname(__FILE__) . '/../bdd/connexion.php');

    if ( !isset($db) ) {
        $db_name = $info['bdd']['postgres']['db_name'];
        $db_host = $info['bdd']['postgres']['db_host'];
        $db_user = $info['bdd']['postgres']['db_user'];
        $db_pwd = $info['bdd']['postgres']['db_pwd'];
        
        try {
            $db = new PDO("pgsql:dbname=$db_name;host=$db_host", $db_user, $db_pwd); 
        }
        catch(Exception $e)  {
            die('Une erreur c\'est produit avec la base de données.<br>Merci de contacter un administrateur.');
        } 
    }

?>