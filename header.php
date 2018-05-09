<header class="flex flex-center">
    <nav class="flex flex-between">
        <ul class="flex">
            <a class="t25" href="/index.php"><li>Critique <span class="white">Musicale</span></li></a>
        </ul>
        <ul class="flex">
            <a class="button" href="/index.php"><li>Accueil</li></a>
            <?php if ( is_connect() ) { ?>
                <?php if ( is_admin() ) { ?>
                    <a class="button button-blue" href="/administration/index.php"><li>Administration</li></a>
                <?php } ?>
                <a class="button"><li>Compte</li></a>
                <a class="button" href="/compte/deconnexion.php"><li>Déconnexion</li></a>
            <?php } else { ?>
                <a class="button" href="/compte/connexion.php"><li>Connexion</li></a>
                <a class="button" href="/compte/inscription.php"><li>Inscription</li></a>
            <?php } ?>
            <a class="button" href="/index.php"><li>à propos de nous</li></a>
        </ul>
    </nav>
</header>