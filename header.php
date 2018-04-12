<header class="flex flex-center">
    <nav class="flex flex-between">
        <ul class="flex">
            <a class="button button-blue" href="/index.php"><li>Accueil</li></a>
        </ul>
        <ul class="flex">
            <?php if ( is_connect() ) { ?>
                <?php if ( is_admin() ) { ?>
                    <a class="button button-blue" href="/administration/index.php"><li>Administration</li></a>
                <?php } ?>
                <a class="button button-cyan" ><li>Compte</li></a>
                <a class="button button-blue" href="/compte/deconnexion.php"><li>Déconnexion</li></a>
            <?php } else { ?>
                <a class="button button-blue" href="/compte/connexion.php"><li>Connexion</li></a>
                <a class="button button-cyan" href="/compte/inscription.php"><li>Inscription</li></a>
            <?php } ?>
        </ul>
    </nav>
</header>