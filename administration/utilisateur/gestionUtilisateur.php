<?php

session_start();
include_once(dirname(__FILE__).'/../../fonctions/variables.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../../bdd/connexion.php');

$info['head']['subTitle'] = "Gestion utilisateur";
$info['head']['stylesheets'] = ['adminGestion.css'];

if(!is_connect() || !is_admin()) {leave();}

include_once(dirname(__FILE__) . '/actionUtilisateur.php');

if ( isset($db) ) {
    $listUser = recuperer_utilisateur_tous($db);
}

include_once(dirname(__FILE__).'/../../head.php');

?>

<?php include_once(dirname(__FILE__).'/../../header.php'); ?>

<main>
    <section>
        <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
        <div>
            <?php include_once(dirname(__FILE__) . '/headerUtilisateur.php'); ?>
            <div>
                
                <!-- TABLEAU
                    Nom Utilisateur - Status
                -->
                <table id="tableauGestion">
                    
                <tr class="table-head">
                    <th class="width-350">Nom d'utilisateur</th>
                    <th class="width-350">Status utilisateur</th>
                </tr>

                <?php foreach($listUser as $user) { ?>
                <tr class="table-lign">
                    <td> <?php echo $user['idutilisateur']; ?> </td>
                    <?php if ( $user['statut'] ) { ?>
                        <td>Admin</td>
                        <td class="bouton bouton-blue">
                            <a href="?action=modifierStatutUtilisateur&idUtilisateur=<?php echo $user['idutilisateur'] ?>&statut=0">Devenir User</a>
                        </td>
                    <?php } else { ?>
                        <td>User</td>
                        <td class="bouton bouton-green">
                            <a href="?action=modifierStatutUtilisateur&idUtilisateur=<?php echo $user['idutilisateur'] ?>&statut=1">Devenir Admin</a>
                        </td>
                    <?php } ?>
                    <td class="bouton bouton-blue">
                        <a href="formUtilisateur.php?idUtilisateur=<?php echo $user['idutilisateur'] ?>">Modifier mot de passe</a>
                    </td>
                    <td class="bouton bouton-red">
                        <a href="?action=supprimerUtilisateur&idUtilisateur=<?php echo $user['idutilisateur'] ?>">Supprimer</a>
                    </td>
                </tr>
                <?php } ?>

                </table>
                <!-- FIN TABLEAU -->
                
            </div>
        </div>
    </section>
</main>

<?php include_once(dirname(__FILE__).'/../../footer.php'); ?>

