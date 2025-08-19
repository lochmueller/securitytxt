<?php

use HDNET\SecurityTxt\Middleware\SecurityTxtMiddleware;

return [
    'frontend' => [
        'security-txt' => [
            'target' => SecurityTxtMiddleware::class,
            'before' => [
                'typo3/cms-frontend/maintenance-mode',
            ],
            'after' => [
                'typo3/cms-frontend/site',
            ],
        ],
    ],
];
