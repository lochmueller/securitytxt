<?php

/** @var string $_EXTKEY */
$EM_CONF[$_EXTKEY] = [
    'title' => 'security.txt integration',
    'description' => 'Integration the security.txt standard into TYPO3',
    'version' => '0.1.0',
    'category' => 'fe',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'php' => '8.3.0-8.99.99',
        ],
    ],
    'state' => 'stable',
    'author' => 'Tim Lochmüller',
    'author_email' => 'tim@fruit-lab.de',
    'author_company' => 'HDNET GmbH & Co. KG',
    'autoload' => [
        'psr-4' => [
            'HDNET\\SecurityTxt\\' => 'Classes',
        ],
    ],
];