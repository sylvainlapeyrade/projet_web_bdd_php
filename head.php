<?php
/**
 * Page head.php
 * Inclut les caractéristiques de la tete de page
 */
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <!-- Affichage du titre de la page -->
        <title>
            <?php
            if ( isset($info) ) {
                if ( isset($info['head']) ) {
                    if ( isset($info['head']['title']) ) {
                        echo $info['head']['title'];
                    } else {
                        echo "Projet Web";
                    }
                    if ( isset($info['head']['subTitle']) ) {
                        echo ' - '.$info['head']['subTitle'];
                    }
                }
            }
            ?>
        </title>
        
        <!-- Affichage des STYLESHEETS -->
        <link rel="stylesheet" href="/styles/defaut.css">
        <link rel="stylesheet" href="/styles/header.css">
        <link rel="stylesheet" href="/styles/footer.css">
        <?php foreach($info['head']['stylesheets'] as $style) { ?>
            <link rel="stylesheet" href="/styles/<?php echo $style ?>">
        <?php } ?>  
        
    </head>
<body>