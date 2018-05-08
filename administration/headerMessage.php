<!-- Message d'erreur du formulaire -->
<? if ( isset($erreur) ) { ?>
<div class="red"><?php echo $erreur; ?></div>

<!-- Message du formulaire -->
<? } elseif ( isset($message) ) { ?>
<div class="green"><?php echo $message; ?></div>

<!-- Message en rapport a une opération -->
<? } elseif ( isset($_GET['operation']) && $_GET['operation'] == 'ok' ) { ?>
<div class="green">L'opération a été effectué.</div>

<? } elseif ( isset($_GET['operation']) && $_GET['operation'] == 'ko' ) { ?>
<div class="red">L'opération n'a pas pu être effectué.</div>
<?php } ?>