<?php

return [
    'template' => [
        'wraper_start' => temp_PATH . 'wraper_start.php',
        'header' => temp_PATH . 'header.php',
        'navbar' => temp_PATH . 'navbar.php',
        'start_view' => temp_PATH . 'start_view.php',
        ':view' => 'view',
        'end_view' => temp_PATH . 'end_view.php',
    ],
    'header_resources' =>[
        'bootstrap' => '/css/bootstrap.css',
        'foawsome' => '/css/all.css',
        'googleIcon' => 'https://fonts.googleapis.com/icon?family=Material+Icons',
        'datatables' => '/css/datatables.min.css',
        'confirm' => '/css/jquery-confirm.min.css',
        'main_ar' => '/css/main_ar.css',
        'main_en' => '/css/main_en.css',
    ],

    'footer_resources' =>[
        'jquery' => '/js/vendor/jquery-1.12.0.min.js',
        'popper' => 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
        'bootstrap' => '/js/vendor/bootstrap.min.js',
        'datatables' => '/js/en/datatables_en.min.js',
        'bootstrap4' => '/js/vendor/dataTables.bootstrap4.min.js',
        'confirm' => '/js/vendor/jquery-confirm.min.js',
        'main' => '/js/main.js',

    ]
];