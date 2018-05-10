<?php

function format_date($date) {
    if ( isset($date) && !empty($date) ) {
        return date("d-m-Y", strtotime($date));
    }
    return null;
}

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
        'motDePasseDifferent' => "Les deux mot de passe ne sont pas identique.",
        'erreurDevenirUtilisateur' => "Vous ne pouvez pas devenir utilisateur normal.",
        'erreurSupprimerSonCompte' => "Vous ne pouvez pas supprimer votre propre compte."
    ],
    'connexion' => [
        'incorrect' => "Votre identifiant ou votre mot de passe est incorrect.",  
    ],
    'inscription' => [
        'utilisateurExistant' => "Ce nom d'utilisateur existe déjà.",
    ],
    'minimum1Artiste' => "Il faut au minimum un artiste sélectionné.",
    'minimum2Artiste' => "Il faut au minimum deux artistes sélectionnés.",
    'operation' => [
        'ok' => "L'opération a été effectué.",
        'ko' => "L'opération n'a pas pu être effectué."
    ]
]

?>