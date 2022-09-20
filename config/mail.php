<?php

  

return [


    'mailers' => [

  
        'mailjet' => [

            'key' => env('MAILJET_APIKEY'),

            'secret' => env('MAILJET_APISECRET'),

            'transactional' => [

                'call' => true,

                'options' => [

                    'url' => 'api.mailjet.com',

                    'version' => 'v3.1',

                    'call' => true,

                    'secured' => true

                ]

            ],

            'common' => [

                'call' => true,

                'options' => [

                    'url' => 'api.mailjet.com',

                    'version' => 'v3',

                    'call' => true,

                    'secured' => true

                ]

                ],

            ],
            ],
        ];

                

                