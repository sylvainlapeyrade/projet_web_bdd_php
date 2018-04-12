<?php
    session_start();
    include_once(dirname(__FILE__).'/../functions/variables.php');
    include_once(dirname(__FILE__).'/../functions/base.php');
    include_once(dirname(__FILE__).'/../functions/compte.php');
    include_once(dirname(__FILE__).'/../database/connexion.php');

    $info['head']['subTitle'] = "Gestion utilisateur";
    $info['head']['stylesheets'] = ['adminGestionUser.css'];

    if(!is_connect() || !is_admin()) {leave();}

    /* Gestion du formulaire */
    if ( isset($_GET['action']) && $_GET['action'] == 'Ajouter' ) {
        $paramOk = check_param($_GET);
        $identify = $_GET['identifiant'];
        $password = $_GET['motDePasse'];
        $verification = $_GET['verification'];
        if ( $password == $verification ) {

            if ( $_GET['estAdmin'] == 'estAdmin' ) {
                $isAdmin = 1;
            } else {
                $isAdmin = 0;
            }
            if ( $paramOk ) {
                $userExist = getUser($db, $identify) != null;
                if ( !$userExiste ) {
                    $actionOk =  add_user($db, $identify, $password, $isAdmin);
                    if ( $actionOk ) {
                        header('Location: ./adminGestionUser.php?action=effectuer');
                    } else {
                        $error = 'L\'utilisateur n\'a pas pu être enregistré.';
                    }
                } else {
                    $error = 'Un utilisateur portant ce nom existe déjà';
                }
            } else {
                $error = 'Le formulaire n\'est pas valide.';
            }
        } else {
            $error = 'Les deux mots de passe sont différents.';
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
            <form class="flex flex-center flex-column " action="./adminFormAddUser.php" method="get">
                <input class="input1" type="text" name="identifiant" placeholder="Nom d'utilisateur">
                <input class="input1" type="password" name="motDePasse" placeholder="Mot de passe">
                <input class="input1" type="password" name="verification" placeholder="Vérification">
                <label for="admin">
                    <input id="admin" type="checkbox" name="estAdmin" value="estAdmin">
                    Utilisateur adminstrateur
                </label>
                <input class="inputButton1" type="submit" name="action" value="Ajouter">
            </form>
        </section>
    </main>
