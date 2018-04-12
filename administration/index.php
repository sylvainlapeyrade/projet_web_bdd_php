<?php
    session_start();
    include_once(dirname(__FILE__).'/../functions/variables.php');
    include_once(dirname(__FILE__).'/../functions/base.php');


    $info['head']['subTitle'] = "Administration";
    $info['head']['stylesheets'] = ['administration.css'];

    include_once(dirname(__FILE__).'/../head.php');
?>

<?php include_once(dirname(__FILE__).'/../header.php'); ?>

    <main>
        <h1>Page d'administration.</h1>
        <section>
            <ul>
                <a href="./adminGestionUser.php">
                    <li class="button button-blue">Gestion des utilisateur</li>
                </a>
                <a>
                    <li class="button button-blue">Gestion des artistes</li>
                </a>
            </ul>
        </section>
    </main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
