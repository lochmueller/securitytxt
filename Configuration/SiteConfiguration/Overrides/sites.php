<?php

$lll = 'LLL:EXT:securitytxt/Resources/Private/Language/locallang.xlf:';


$regularFields = ['contact', 'encryption', 'acknowledgments', 'policy', 'hiring', 'preferredLanguages', 'relativeDate'];

foreach ($regularFields as $field) {
    $GLOBALS['SiteConfiguration']['site']['columns']['securitytxt' . ucfirst($field)] = [
        'label' => $lll . $field,
        'description' => $lll . $field . '.description',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
        ],
    ];
}

$newFields = array_map(fn($field) => 'securitytxt' . ucfirst($field), $regularFields);

$GLOBALS['SiteConfiguration']['site']['columns']['securitytxtRelativeDate']['config']['default'] = 'last day of next month';


$GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] = str_replace(
    ', languages,',
    ', languages, --div--;' . $lll . 'securitytxt, ' . implode(',', $newFields) . ',',
    $GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'],
);