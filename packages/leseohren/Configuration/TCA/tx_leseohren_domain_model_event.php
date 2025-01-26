<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event',
        'label' => 'start_date',
        'label_alt' => 'title',
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
        'searchFields' => 'title,description,location',
        'iconfile' => 'EXT:leseohren/Resources/Public/Icons/tx_leseohren_domain_model_event.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => ['showitem' => '
            --div--;Event,
                title,
                --palette--;;datePalette,
                description,
                location,
                categories,
                speaker,
            --div--;Teilnehmer,
                --palette--;;participantsPalette,
                registrations,
                participants,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                hidden,
                starttime,
                endtime'],
    ],
    'palettes' => [
        'datePalette' => [
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.datePalette.description',
            'showitem' => 'start_date, end_date',
        ],
        'participantsPalette' => [
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.participantsPalette.description',
            'showitem' => 'maxparticipants, reminder_sent',
        ],
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
        'categories' => [
            'config' => [
                'type' => 'category',
                'treeConfig' => [
                    'startingPoints' => '18',
                    'nonSelectableLevels' => 0,
                ],
            ],
        ],

        'title' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.title',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.title.description',
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
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.description',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.description.description',
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
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.start_date',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.start_date.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'datetime',
                'required' => true,
                'size' => 20,
                'default' => 0,
            ],
        ],
        'end_date' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.end_date',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.end_date.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'datetime',
                'required' => true,
                'size' => 20,
                'default' => 0,
            ],
        ],
        'location' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.location',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.location.description',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'eval' => 'trim',
                'default' => ''
            ]
        ],
        'maxparticipants' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.maxparticipants',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.maxparticipants.description',
            'config' => [
                'type' => 'number',
                'size' => 4,
                'default' => 0
            ]
        ],
        'reminder_sent' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.reminder_sent',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.reminder_sent.description',
            'config' => [
                'type' => 'check',
                'items' => [
                    [
                        'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_event.reminder_sent.sent',
                    ],
                ],
            ],
        ],
        'speaker' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren.speaker',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren.speaker.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_leseohren_domain_model_person',
                'MM' => 'tx_leseohren_speakerevent_person_mm',
                'size' => 10,
                'autoSizeMax' => 20,
            ],
        ],
    ],
];
