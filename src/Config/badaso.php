<?php

return [
    'db_name' => env('DB_DATABASE'),
    'admin_panel_route_prefix' => env('MIX_ADMIN_PANEL_ROUTE_PREFIX', 'badaso-dashboard'),
    'default_menu' => env('MIX_DEFAULT_MENU', 'admin'),
    'api_route_prefix' => env('MIX_API_ROUTE_PREFIX', 'badaso-api'),
    'storage' => [
        'disk' => env('FILESYSTEM_DRIVER', 'public'),
    ],
    'configuration_groups' => [
        ['value' => 'adminPanel', 'label' => 'Admin Panel'],
        ['value' => 'landingPage', 'label' => 'Landing Page'],
    ],
    'widgets' => [
        'Uasoft\\Badaso\\Widgets\\UserWidget',
        'Uasoft\\Badaso\\Widgets\\RoleWidget',
        'Uasoft\\Badaso\\Widgets\\PermissionWidget',
    ],
    'whitelist' => [
        'web' => [],
        'badaso' => [
            '/maintenance',
            '/login',
        ],
        'api' => [
            '/v1/verify-badaso',
            '/v1/configurations/applyable',
            '/v1/maintenance',
            '/v1/auth/login',
            '/v1/file/*',
        ],
    ],
    'manifest' => [
        'name' => 'Badaso',
        'short_name' => 'Badaso',
        'description' => 'Badaso Progressive Web App ',
        'icons' => [
            [
                'src' => '/storage/files/shares/logo-144px.png',
                'sizes' => '144x144',
                'type' => 'image/png',
            ],
            [
                'src' => '/storage/files/shares/logo-192px.png',
                'sizes' => '192x192',
                'type' => 'image/png',
            ],
            [
                'src' => '/storage/files/shares/logo-512px.png',
                'sizes' => '512x512',
                'type' => 'image/png',
            ],
        ],
        'start_url' => env('MIX_ADMIN_PANEL_ROUTE_PREFIX', 'badaso-dashboard'),
        'display' => 'standalone',
        'theme_color' => '#06bbd3',
        'background_color' => '#06bbd3',
    ],
];
