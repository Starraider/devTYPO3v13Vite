<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_blackboard',
        'label' => 'title',
        'label_alt' => 'start_date',
        'label_alt_force' => true,
        'default_sortby' => 'start_date DESC',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,description',
        'iconfile' => 'EXT:leseohren/Resources/Public/Icons/tx_leseohren_domain_model_blackboard.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'title, person, description, start_date, end_date, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
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

        'title' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_blackboard.title',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_blackboard.title.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
                'default' => ''
            ],
        ],
        'description' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_blackboard.description',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_blackboard.description.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => 'true',
                'rows' => 15,
                'eval' => 'trim',
                'default' => ''
            ]
        ],
        'start_date' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_blackboard.start_date',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_blackboard.start_date.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'required' => true,
                'size' => 20,
                'default' => 0,
            ],
        ],
        'end_date' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_blackboard.end_date',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_blackboard.end_date.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'required' => true,
                'size' => 20,
                'default' => 0,
            ],
        ],
        'person' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_leseohren_domain_model_person',
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],

    ],
];
