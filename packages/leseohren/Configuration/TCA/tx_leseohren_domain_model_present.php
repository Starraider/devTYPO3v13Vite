<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_present',
        'label' => 'gift_date',
        'label_alt' => 'gift',
        'label_alt_force' => true,
        'default_sortby' => 'gift_date DESC',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => '',
        'iconfile' => 'EXT:leseohren/Resources/Public/Icons/tx_leseohren_domain_model_present.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'gift_date, given, gift, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
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
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'gift_date' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_present.gift_date',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_present.gift_date.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'required' => true,
                'size' => 20,
                'default' => 0,
            ],
        ],
        'given' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_present.given',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_present.given.description',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ]
        ],
        'gift' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_present.gift',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_present.gift.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_leseohren_domain_model_gift',
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
