<header class="flex flex-center">
    <nav class="flex flex-between">
        <ul class="flex">
            <a class="button1" href="/index.php"><li>Accueil</li></a>
        </ul>
        <ul class="flex">
            <?php if ( is_connect() ) { ?>
                <?php if ( is_admin() ) { ?>
                    <a class="button1"><li>Administration</li></a>
                <?php } ?>
                <a><li>Compte</li></a>
                <a class="button1" href="/compte/deconnexion.php"><li>Déconnexion</li></a>
            <?php } else { ?>
                <a class="button1" href="/compte/connexion.php"><li>Connexion</li></a>
                <a class="button2" href="/compte/inscription.php"><li>Inscription</li></a>
            <?php } ?>
        </ul>
    </nav>
</header>