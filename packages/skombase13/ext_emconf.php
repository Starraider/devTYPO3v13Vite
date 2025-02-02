<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'skombase13',
    'description' => 'Base sitepacke for TYPO3 v13 with Vite',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'bootstrap_package' => '15.0.0-15.99.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Skom\\Skombase13\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'author' => 'Sven Kalbhenn',
    'author_email' => 'sven@skom.de',
    'author_company' => 'SKom',
    'version' => '1.0.0',
];
