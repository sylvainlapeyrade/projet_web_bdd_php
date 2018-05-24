<?php

/**
 * @file evaluation/headerEvaluation.php
 * @brief Inclut des messages pour la partie evaluation
 */

?>

<div>

    <?php if ( isset($erreur) ) { ?>
        <div class="red"><?php echo $erreur; ?></div>
    <?php } elseif ( isset($message) ) { ?>
        <div class="green"><?php echo $message; ?></div>
    <?php } ?>
    
</div>