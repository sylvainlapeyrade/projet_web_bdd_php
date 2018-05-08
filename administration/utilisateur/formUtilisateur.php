<?php
session_start();
include_once(dirname(__FILE__).'/../../fonctions/variables.php');
include_once(dirname(__FILE__).'/../../fonctions/fonctionCompte.php');
include_once(dirname(__FILE__).'/../../bdd/connexion.php');

$info['head']['subTitle'] = "Gestion utilisateur";
$info['head']['stylesheets'] = ['adminGestion.css'];

if(!is_connect() || !is_admin()) {leave();}

$idUtilisateur = $_GET['idUtilisateur'];
if ( isset($db) && isset($idUtilisateur) && !empty($idUtilisateur) ) {
    $utilisateur = recuperer_utilisateur($db, $idUtilisateur);
    if ( $utilisateur != null ) {
        $idUtilisateur = $utilisateur['idutilisateur'];
    }
}

/* Fichier de fonction exécuter suivant deux cas :
 * 1: ajouter un utilisateur avec action = ajouterUtilisateur
 * 2: modifier un utilisateur avec action = modifierUtilisateur
 */
include_once(dirname(__FILE__).'/actionUtilisateur.php');

include_once(dirname(__FILE__).'/../../head.php');

include_once(dirname(__FILE__).'/../../header.php');
?>

<main>
    <section>
        <?php include_once(dirname(__FILE__).'/../adminHeader.php'); ?>
        <div>
            <?php include_once(dirname(__FILE__).'/headerUtilisateur.php'); ?>
            <div class="text-center">
                <h1>Formulaire Utilisateur</h1>

                <!-- FORMULAIRE :
                     idUtilisateur : text
                     motDePasse : password
                     verification : password
                -->
                <form class="flex flex-center flex-column " action="./formUtilisateur.php" method="get">
                    <input class="input-text" 
                           type="text" 
                           title="idUtilisateur"
                           placeholder="Identifiant"
                           value="<?php echo $idUtilisateur ?>" 
                           <?php if ( isset($idUtilisateur) && !empty($idUtilisateur) ) { echo "disabled"; } else { echo 'name="idUtilisateur"'; } ?>
                           />
                  
                    <input class="input-text" 
                           type="password" 
                           name="motDePasse" 
                           placeholder="Mot de passe" 
                           required
                           />
                  
                    <input class="input-text" 
                           type="password" 
                           name="verification" 
                           placeholder="Vérification" 
                           required
                           />
                    
                    <!-- BOUTON AJOUTER/MODIFIER AVEC CHAMPS CACHES -->
                    <?php  if ( isset($idUtilisateur) && !empty($idUtilisateur) ) { /**** BOUTON POUR MODIFIER */ ?>
                        <input type="hidden"
                               name="idUtilisateur"
                               value="<?php echo $idUtilisateur ?>"
                        />
                        <input type="hidden"
                               name="action"
                               value="modifierMotDePasseUtilisateur"
                        />
                        <input class="inputButton1"
                               type="submit"
                               value="modifier"
                        />
                    <?php } else { /***************************************************** BOUTON POUR AJOUTER */ ?>
                        <input type="hidden"
                               name="action"
                               value="ajouterUtilisateur"
                        />
                        <input class="inputButton1"
                               type="submit"
                               value="ajouter"
                        />
                    <?php } ?>
                </form>
                <!-- FIN FORMULAIRE -->

            </div>
        </div>
    </section>
</main>
