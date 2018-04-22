<div id="adminHeaderUser" class="flex flex-row">
  <div class="t24">
    <a href="./adminGestionUser.php">Gestion des utilisateurs</a>
  </div>
  <div>
    <a href="adminFormAddUser.php" class="button button-blue t12 button-header">Ajouter un utilisateur</a>
  </div>

  <!-- Message d'erreur du formulaire -->
  <? if ( isset($error) ) { ?>
  <div class="red"><?php echo $error; ?></div>
  <? } ?>

  <!-- Message du formulaire -->
  <? if ( isset($message) ) { ?>
  <div class="green"><?php echo $message; ?></div>
  <? } ?>
</div>