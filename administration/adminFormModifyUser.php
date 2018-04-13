<?php
    session_start();
    include_once(dirname(__FILE__).'/../functions/variables.php');
    include_once(dirname(__FILE__).'/../functions/base.php');
    include_once(dirname(__FILE__).'/../functions/compte.php');
    include_once(dirname(__FILE__).'/../database/connexion.php');

    $info['head']['subTitle'] = "Gestion utilisateur";
    $info['head']['stylesheets'] = ['adminGestionUser.css'];

    if(!is_connect() || !is_admin()) {leave();}

    $identify = $_GET['idUtilisateur'];

    if ( isset($_GET['action']) && $_GET['action'] == 'Modifier mot de passe' ) {
        $paramOk = check_param($_GET);
        if ( $paramOk ) {
            $password = $_GET['motDePasse'];
            $verification = $_GET['verification'];
            if ( $password == $verification ) {
                $actionOk = modify_password_user($db, $identify, $password);
                if ( $actionOk ) {
                    header('Location: ./adminGestionUser.php?action=effectuer');
                } else {
                    $error = 'L\'action n\'a pas pu être exécuter';
                }
            } else {
                $error = 'Les deux mot de passe ne correspondent pas.';
            }
        } else {
            $error = 'Le formulaire n\'est pas valide';
        }
    }

    include_once(dirname(__FILE__).'/../head.php');
?>

<?php include_once(dirname(__FILE__).'/../header.php'); ?>

    <main class="flex flex-center flex-column">
        <a href="./index.php">
            <h1>Panneau d'adminsitration</h1>
        </a>
        <section class="text-center">
            <a href="./adminGestionUser.php">
                <h2>Gestion des utilisateurs</h2>
            </a>
            <? if ( isset($error) ) { ?>
            <!-- Message d'erreur du formulaire -->
            <p class="red"><?php echo $error; ?></p>
            <? } ?>
            <form class="flex flex-center flex-column " action="./adminFormModifyUser.php" method="get">
                <input class="input1" type="hidden" name="idUtilisateur" value="<?php echo $identify; ?>">
                <input class="input1" type="password" name="motDePasse" placeholder="Mot de passe">
                <input class="input1" type="password" name="verification" placeholder="Vérification">
                <input class="inputButton1" type="submit" name="action" value="Modifier mot de passe">
            </form>
        </section>
    </main>
