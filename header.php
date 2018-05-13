<header class="flex flex-center">
    <nav class="flex flex-between">
        <ul class="flex">
            <a class="t25" href="/index.php"><li>Critique <span class="white">Musicale</span></li></a>
        </ul>
        <ul class="flex">
            <a class="bouton flex item-center" href="/index.php"><li>Accueil</li></a>
            <?php if ( is_connect() ) { ?>
                <?php if ( is_admin() ) { ?>
                    <a class="bouton flex item-center" href="/administration/index.php"><li>Administration</li></a>
                <?php } ?>
                <a class="bouton flex item-center"><li>Compte</li></a>
                <a class="bouton flex item-center" href="/compte/deconnexion.php"><li>Déconnexion</li></a>
            <?php } else { ?>
                <a class="bouton flex item-center" href="/compte/connexion.php"><li>Connexion</li></a>
                <a class="bouton flex item-center" href="/compte/inscription.php"><li>Inscription</li></a>
            <?php } ?>
            <a class="bouton flex item-center" href="/index.php"><li>à propos</li></a>
        </ul>
    </nav>
</header>