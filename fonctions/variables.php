<?php

function format_date($date) {
    if ( isset($date) && !empty($date) ) {
        return date("d-m-Y", strtotime($date));
    }
    return null;
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

?>