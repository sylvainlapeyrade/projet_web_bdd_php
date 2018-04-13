<?php
    session_start();
    include_once(dirname(__FILE__).'/../functions/variables.php');
    include_once(dirname(__FILE__).'/../functions/base.php');
    include_once(dirname(__FILE__).'/../database/connexion.php');
    include_once(dirname(__FILE__).'/../functions/compte.php');

    $info['head']['subTitle'] = "Inscription";
    $info['head']['stylesheets'] = ['inscription.css'];

    if(is_connect()) {leave();}

    /* Gestion du formulaire d'inscription */
    if ( isset($_GET['inscription']) && $_GET['inscription'] == 'inscription' ) {
        $paramOk = check_param($_GET);
        if ( $paramOk ) {
            $identify = $_GET['idUtilisateur'];
            $password = $_GET['motDePasse'];
            $verify = $_GET['verification'];
            if ( $password == $verify ) {
                $actionOk = inscription($db, $identify, $password, 0);
                if ( actionOk ) {
                    header('Location: /compte/connexion.php?action=inscription');
                } else {
                    $error = 'Ce non d\'utilisateur existe déjà';
                }
            } else {
                $error = 'Les mots de passe ne sont pas identique.';
            }
        } else {
            $error = 'Le formulaire n\'est pas valide.';
        }
    }
?>

<?php include_once(dirname(__FILE__).'/../head.php'); ?>
<?php include_once(dirname(__FILE__).'/../header.php'); ?>

<main class="flex flex-center">

    <section class="flex flex-center flex-column text-center">
        <h1 class="t30">Inscription</h1>
        <? if ( isset($error) ) { ?>
        <!-- Message d'erreur du formulaire -->
        <p class="red"><?php echo $error; ?></p>
        <? } ?>
        <form class="flex flex-center flex-column" method="get">
            <input class="input1" type="text" name="idUtilisateur" placeholder="Identifiant">
            <input class="input1" type="password" name="motDePasse" placeholder="Mot de passe">
            <input class="input1" type="password" name="verification" placeholder="Vérification">
            <input class="inputButton1" type="submit" name="inscription" value="inscription">
        </form>
    </section>

</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
