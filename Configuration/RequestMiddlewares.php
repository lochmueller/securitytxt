<?php

return [
    'frontend' => [
        'security-txt' => [
            'target' => \HDNET\SecurityTxt\Middleware\SecurityTxtMiddleware::class,
            'before' => [
                'typo3/cms-frontend/maintenance-mode',
            ],
            'after' => [
                'typo3/cms-frontend/site',
            ],
        ],
    ],
];
