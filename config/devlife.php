<?php

return [
    'app_name' => env('DEVLIFE_APP_NAME', 'DevLife OS'),

    'addons' => [
        'path' => base_path('Addons'),

        /*
         * Enable/disable addons without removing code.
         *
         * Keys can be addon slugs (recommended) or addon names.
         */
        'enabled' => [
            // 'crm' => true,
        ],
    ],
];

