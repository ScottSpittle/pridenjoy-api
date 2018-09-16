<?php

return [
    'driver' => 'mailgun',

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS'),
        'name' => env('MAIL_FROM_NAME')
    ],
];
