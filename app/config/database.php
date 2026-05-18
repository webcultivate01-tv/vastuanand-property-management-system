<?php
return [
    'default' => 'mongodb',

    'connections' => [
        'mongodb' => [
            'driver'   => 'mongodb',
            'uri'      => env('MONGO_URI', 'mongodb://127.0.0.1:27017'),
            'database' => env('MONGO_DB', 'vastuanand'),
            'options'  => [
                'retryWrites'         => true,
                'w'                   => 'majority',
                'serverSelectionTimeoutMS' => 5000,
            ],
            'driverOptions' => [],
        ],
    ],

    'collections' => [
        'users'         => 'users',
        'admins'        => 'admins',
        'properties'    => 'properties',
        'leads'         => 'leads',
        'inquiries'     => 'inquiries',
        'blogs'         => 'blogs',
        'testimonials'  => 'testimonials',
        'gallery'       => 'gallery',
        'careers'       => 'careers',
        'subscribers'   => 'subscribers',
        'settings'      => 'settings',
        'popups'        => 'popups',
        'visits'        => 'visit_requests',
        'compare'       => 'compare_lists',
        'saved'         => 'saved_properties',
        'audit'         => 'audit_logs',
    ],
];
