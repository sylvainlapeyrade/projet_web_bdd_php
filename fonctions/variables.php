<?php

/**
 * Renvoie une date dans le format "Y-m-d" à partir
 * d'une chaine en paramètre.
 * @param $date String Date à transformer
 * @return String La date transformée | Null sinon
 */
function format_date($date) {
    if ( isset($date) && !empty($date) ) {
        return date("Y-m-d", strtotime($date));
    }
    return null;
}

/**
 * Renvoie une date dans le format "d-m-Y" à partir
 * d'une date en format "Y-m-d".
 * @param $date String Date à transformer
 * @return String La date transformée
 */
function affichage_date($date){
    $date = explode("-", $date);
    return $date[2].'-'.$date[1].'-'.$date[0];
}

/**
 * Expression régulière vérifiant si une date est bien
 * conforme à son format attendu
 * @param $date String Date à vérifier
 * @return false si la date est invalide | true sinon
 */
function date_valide($date) {
	//verification format
	$pattern1 = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}/';
	$pattern2 = '/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}/';
	if ( !preg_match($pattern1, $date) && !preg_match($pattern2, $date) )
		return false;
	
	//date actuelle
	$jour = intval(date('j'));
	$mois = intval(date('m'));
	$annee = intval(date('Y'));

    //date en paramètre
	$j_verif = intval($date[8].$date[9]);
	$m_verif = intval($date[5].$date[6]);
	$y_verif = intval($date[0].$date[1].$date[2].$date[3]);
    
    if ($y_verif < $annee )
		return true;
	else if ($y_verif > $annee)
		return false;
	else if ($y_verif == $annee) {
		if ($m_verif < $mois)
			return true;
		else if ($m_verif > $mois)
			return false;
		else if ($m_verif == $mois) {
			if ($j_verif <= $jour) 
				return true;
			else
				return false;
		}
	}
	return false;
}

/**
 * Transforme une durée en secondes
 * en durée en minutes secondes
 * @param $secondes String Durée à convertir
 * @return String durée convertie
 */
function format_duree($secondes) {
	$minutes = intdiv($secondes,60);
	$secondes = $secondes % 60;
	return("$minutes min $secondes s");
}

$info = [
    'head' => [
        'title' => "Mon projet"
    ],
    'bdd' => [
        'postgres' => [
            'db_name' => 'bd_web',
            'db_host' => 'localhost',
            'db_user' => 'postgres',
            'db_pwd' => '1234567890'

        ],
        'mysql' => [
            'db_name' => 'bd_web',
            'db_host' => 'localhost',
            'db_user' => 'user',
            'db_pwd' => '1234567890'   
        ]
    ]
];

$messages = [
    'formulaire' => [
        'champs_obligatoire' => "Certains champs du formulaire sont obligatoire.",
        'champs_vide' => "Certains champs du formulaire sont vide.",
        'invalide' => "Le formulaire est incomplet.",
        'dateInvalide' => "La date n'est pas valide (aaaa-mm-jj).",
        'motDePasseDifferent' => "Les deux mot de passe ne sont pas identique.",
        'erreurDevenirUtilisateur' => "Vous ne pouvez pas devenir utilisateur normal.",
        'erreurSupprimerSonCompte' => "Vous ne pouvez pas supprimer votre propre compte.",
        'valeurNegative' => "La valeur renseigné doit être positive.",
        'noteIncorrecte' => "La note doit être compris entre 1 et 5",
        'nonAutoriser' => "Vous n'avez pas l'autorisation d'effectuer cette action.",
        'evaluationExistant' => "Vous avez déjà évaluer cette élément.",
    ],
    'connexion' => [
        'incorrect' => "Votre identifiant ou votre mot de passe est incorrect.",  
    ],
    'inscription' => [
        'utilisateurExistant' => "Ce nom d'utilisateur existe déjà.",
        'inscriptionOk' => "Le compte à été enregistré.",
    ],
    'minimum1Artiste' => "Il faut au minimum un artiste sélectionné.",
    'minimum1ArtisteOuGroupe' => "Il faut au minimum un artiste ou un groupe de sélectionné.",
    'minimum2Artiste' => "Il faut au minimum deux artistes sélectionnés.",
    '1titreMusique' => "Il faut seulement un titre de musique sélectionner.",
    'operation' => [
        'ok' => "L'opération a été effectué.",
        'ko' => "L'opération n'a pas pu être effectué."
    ]
]

?>