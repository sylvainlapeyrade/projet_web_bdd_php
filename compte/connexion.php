<?php
    session_start();
    include_once(dirname(__FILE__).'/../functions/variables.php');
    include_once(dirname(__FILE__).'/../functions/base.php');
    include_once(dirname(__FILE__).'/../database/connexion.php');
    include_once(dirname(__FILE__).'/../functions/compte.php');

    $info['head']['subTitle'] = "Connexion";
    $info['head']['stylesheets'] = ['connexion.css'];

    if(is_connect()) {leave();}

    /* Gestion du formulaire connexion */
    if ( isset($_GET['connexion']) && $_GET['connexion'] == 'connexion' ) {
        $paramOk = check_param($_GET);
        $identify = $_GET['idUtilisateur'];
        $password = $_GET['motDePasse'];
        if ( $paramOk ) {
            $actionOk = connectionAccount($db, $identify, $password);
            if ( $actionOk ) {
                header('Location: /index.php');
            } else {
                $error = 'Votre identifiant ou votre mot de passe est incorrect.';
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
        <h1 class="t30">Connexion</h1>
        <? if ( isset($error) ) { ?>
        <!-- Message d'erreur du formulaire -->
        <p class="red"><?php echo $error; ?></p>
        <? } ?>
        <? if ( isset($_GET['action']) && $_GET['action'] == 'inscription' ) { ?>
        <!-- Message si l'utilisateur viens de s'inscrire -->
        <p class="green">Votre compte a été crée.<br>Connectez-vous à votre compte !</p>
        <? } ?>
        <form class="flex flex-center flex-column" method="get">
            <input class="input1" type="text" name="idUtilisateur" placeholder="Identifiant"
                   value="<?php if( isset($identify) ){ echo $identify; } ?>">
            <input class="input1" type="password" name="motDePasse" placeholder="Mot de passe">
            <input class="inputButton1" type="submit" name="connexion" value="connexion">
        </form>
    </section>

</main>

<?php include_once(dirname(__FILE__).'/../footer.php'); ?>
