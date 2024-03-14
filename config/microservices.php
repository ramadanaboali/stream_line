<?php

return [
    'organization' =>   [
                    'base_uri' => env('ORGANIZATION_SERVICE_BASE_URL','127.0.0.1:8001'),
                    'secret' => env('ORGANIZATION_SERVICE_SECRET','service_001'),
                    ],

    'hr' =>   [
        'base_uri' => env('HR_SERVICE_BASE_URL','127.0.0.1:8002'),
        'secret' => env('HR_SERVICE_SECRET','service_002'),
    ],
    'users' =>   [
        'base_uri' => env('USER_SERVICE_BASE_URL','127.0.0.1:8003'),
        'secret' => env('USER_SERVICE_SECRET','service_003'),
    ],
    'building' =>   [
        'base_uri' => env('BUILDING_SERVICE_BASE_URL','127.0.0.1:8004'),
        'secret' => env('BUILDING_SERVICE_SECRET','service_004'),
    ],

    'storage' =>   [
        'base_uri' => env('STORAGE_SERVICE_BASE_URL','127.0.0.1:8005'),
        'secret' => env('STORAGE_SERVICE_SECRET','service_005'),
    ],

    'notification' =>   [
        'base_uri' => env('NOTIFICATION_SERVICE_BASE_URL','127.0.0.1:8006'),
        'secret' => env('NOTIFICATION_SERVICE_SECRET','service_006'),
    ],
    'academic_year' =>   [
        'base_uri' => env('YEAR_SERVICE_BASE_URL','127.0.0.1:8007'),
        'secret' => env('YEAR_SERVICE_SECRET','service_007'),
    ],
    'admission' =>   [
        'base_uri' => env('ADMISSION_SERVICE_BASE_URL','127.0.0.1:8008'),
        'secret' => env('ADMISSION_SERVICE_SECRET','service_008'),
    ],

    'pricing' =>   [
        'base_uri' => env('PRICING_SERVICE_BASE_URL','127.0.0.1:8009'),
        'secret' => env('PRICING_SERVICE_SECRET','service_009'),
    ],

    'transportation' =>   [
        'base_uri' => env('TRANSPORTATION_SERVICE_BASE_URL','127.0.0.1:8010'),
        'secret' => env('TRANSPORTATION_SERVICE_SECRET','service_010'),
    ],

    'nafith' =>   [
        'base_uri' => env('NAFITH_SERVICE_BASEz_URL','127.0.0.1:8011'),
        'secret' => env('NAFITH_SERVICE_SECRET','service_011'),
    ],

    'payfort' =>   [
        'base_uri' => env('PAYFORT_SERVICE_BASE_URL','127.0.0.1:8012'),
        'secret' => env('PAYFORT_SERVICE_SECRET','service_012'),
    ],
    'anb' =>   [
        'base_uri' => env('ANB_SERVICE_BASE_URL','127.0.0.1:8013'),
        'secret' => env('ANB_SERVICE_SECRET','service_013'),
    ],
    'exams' =>   [
        'base_uri' => env('EXAM_SERVICE_BASE_URL','127.0.0.1:8014'),
        'secret' => env('EXAM_SERVICE_SECRET','service_014'),
    ],
    'supply_chain' =>   [
        'base_uri' => env('SUPPLY_SERVICE_BASE_URL','127.0.0.1:8015'),
        'secret' => env('SUPPLY_SERVICE_SECRET','service_015'),
    ],
    'appointment' =>   [
        'base_uri' => env('APPOINTMENT_SERVICE_BASE_URL','127.0.0.1:8016'),
        'secret' => env('APPOINTMENT_SERVICE_SECRET','service_016'),
    ],
    'billing' =>   [
        'base_uri' => env('BILLING_SERVICE_BASE_URL','127.0.0.1:8017'),
        'secret' => env('BILLING_SERVICE_SECRET','service_017'),
    ],
    'students' =>   [
        'base_uri' => env('STUDENT_SERVICE_BASE_URL','127.0.0.1:8018'),
        'secret' => env('STUDENT_SERVICE_SECRET','service_018'),
    ],
    'withdrawal' =>   [
        'base_uri' => env('WITHDRAWAL_SERVICE_BASE_URL','127.0.0.1:8019'),
        'secret' => env('WITHDRAWAL_SERVICE_SECRET','service_019'),
    ],



    ];
