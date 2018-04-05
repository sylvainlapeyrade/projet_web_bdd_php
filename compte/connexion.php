<?php
    session_start();
    include_once(dirname(__FILE__).'/../functions/variables.php');
    include_once(dirname(__FILE__).'/../functions/base.php');
    include_once(dirname(__FILE__).'/../database/connexion.php');
    include_once(dirname(__FILE__).'/../functions/connexion.php');

    $info['head']['subTitle'] = "Connexion";
    $info['head']['stylesheets'] = ['connexion.css'];
?>

<?php include_once(dirname(__FILE__).'/../head.php'); ?>
<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main class="flex flex-center">
    
    <section class="flex">
        <section class="flex flex-center flex-column">
            <h1 class="t30 text-center">Connexion</h1>
            <? if ( isset($erreur) ) { ?>
            <p class="red"></p>
            <? } ?>
            <form class="flex flex-center flex-column" method="get" target="connexion.php">
                <input class="input1" type="text" name="identifiant" placeholder="Identifiant">
                <input class="input1" type="password" name="motDePasse" placeholder="Mot de passe">
                <input class="button1" type="submit" name="connexion" value="connexion">
            </form>
        </section>
    </section>
    
</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
