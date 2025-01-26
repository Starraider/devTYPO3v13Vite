<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_registration',
        'label' => 'registration_date',
        'label_alt' => 'event',
        'label_alt_force' => true,
        'default_sortby' => 'registration_date DESC',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => '',
        'iconfile' => 'EXT:leseohren/Resources/Public/Icons/tx_leseohren_domain_model_registration.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'registration_date, onwaitlist, event, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden'],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],

        'registration_date' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_registration.registration_date',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_registration.registration_date.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'datetime',
                'required' => true,
                'size' => 20,
                'default' => time(),
            ],
        ],
        'onwaitlist' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_registration.onwaitlist',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_registration.onwaitlist.description',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ]
        ],
        'event' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_registration.event',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_registration.event.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_leseohren_domain_model_event',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],

        ],
        'person' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],

    ],
];
