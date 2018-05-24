<?php

/**
 * @file compte/headerCompte.php
 * @bref Inclut des messages pour la partie compte
 */

?>

<div>

    <? if ( isset($erreur) ) { ?>
        <p class="red"><?php echo $erreur; ?></p>
    <? } elseif ( isset($message) ) { ?>
        <p class="green"><?php echo $message; ?></p>
    <? } ?>

</div>