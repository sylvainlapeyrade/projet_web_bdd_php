<div>

    <? if ( isset($erreur) ) { ?>
        <p class="red"><?php echo $erreur; ?></p>
    <? elseif ( isset($message) ) { ?>
        <p class="green"><?php echo $message; ?></p>
    <? } ?>

</div>