<?php

return [
    'collections' => [
        'default' => [
            'info' => [
                'title' => config('app.name'),
                'description' => 'Test task for Foundarium.',
                'version' => '1.0.0',
                'contact' => [],
            ],
            'servers' => [
                [
                    'url' => env('APP_URL'),
                    'description' => 'Default dev backend',
                    'variables' => [],
                ],
                [
                    'url' => 'http://localhost/',
                    'description' => 'localhost:80',
                    'variables' => [],
                ],
                [
                    'url' => 'http://localhost:8000/',
                    'description' => 'localhost:8000',
                    'variables' => [],
                ],
                [
                    'url' => 'http://localhost:8080/',
                    'description' => 'localhost:8080',
                    'variables' => [],
                ],
            ],
            'tags' => [
                [
                    'name' => 'cars_crud',
                    'description' => 'Cars CRUD',
                ],
                [
                    'name' => 'users_crud',
                    'description' => 'Users CRUD',
                ],
                [
                    'name' => 'assign',
                    'description' => 'Car assign API',
                ],
            ],
            'security' => [
            // GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement::create()->securityScheme('JWT'),
            ],
            // Non standard attributes used by code/doc generation tools can be added here
            'extensions' => [
            // 'x-tagGroups' => [
            //     [
            //         'name' => 'General',
            //         'tags' => [
            //             'user',
            //         ],
            //     ],
            // ],
            ],
            // Route for exposing specification.
            // Leave uri null to disable.
            'route' => [
                'uri' => '/openapi',
                'middleware' => [],
            ],
            // Register custom middlewares for different objects.
            'middlewares' => [
                'paths' => [
                //
                ],
                'components' => [
                //
                ],
            ],
        ],
    ],
    // Directories to use for locating OpenAPI object definitions.
    'locations' => [
        'callbacks' => [
            app_path('OpenApi/Callbacks'),
        ],
        'request_bodies' => [
            app_path('OpenApi/RequestBodies'),
        ],
        'responses' => [
            app_path('OpenApi/Responses'),
        ],
        'schemas' => [
            app_path('OpenApi/Schemas'),
        ],
        'security_schemes' => [
            app_path('OpenApi/SecuritySchemes'),
        ],
    ],
];
