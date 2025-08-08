<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'name',
        'iconfile' => 'EXT:leseohren/Resources/Public/Icons/tx_leseohren_domain_model_organization.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => ['showitem' => '
            --div--;Organization,
                name,
                contact_person,
                --palette--;;addressPalette,
                --palette--;;contactPalette,
                categories,
                notes,
            --div--;Vorlesepaten,
                vp_number, vlpaten, reading_times, vp_languages,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                hidden,
                starttime,
                endtime'],
    ],
    'palettes' => [
        'addressPalette' => [
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.addressPalette.description',
            'showitem' => 'street1, street2, --linebreak--, zip, city, district',
        ],
        'contactPalette' => [
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.contactPalette.description',
            'showitem' => 'phone1, phone2, --linebreak--, email, url, --linebreak--, opening_hours, whatsapp, --linebreak--, lastcontact',
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
                    'startingPoints' => '10',
                    'nonSelectableLevels' => '0',
                ],
            ],
        ],
        'name' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.name',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.name.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
                'default' => ''
            ],
        ],
        'street1' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.street1',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.street1.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'street2' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.street2',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.street2.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.zip',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.zip.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.city',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.city.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'district' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.district',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.district.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.1', 'value' => '1'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.2', 'value' => '2'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.3', 'value' => '3'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.4', 'value' => '4'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.5', 'value' => '5'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.7', 'value' => '7'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.8', 'value' => '8'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.9', 'value' => '9'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.11', 'value' => '11'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.12', 'value' => '12'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.13', 'value' => '13'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.14', 'value' => '14'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.15', 'value' => '15'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.16', 'value' => '16'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.17', 'value' => '17'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.18', 'value' => '18'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.19', 'value' => '19'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.20', 'value' => '20'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.21', 'value' => '21'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.22', 'value' => '22'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.25', 'value' => '25'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.26', 'value' => '26'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.32', 'value' => '32'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.33', 'value' => '33'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.34', 'value' => '34'],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.district.35', 'value' => '35'],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'phone1' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.phone1',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.phone1.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'phone2' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.phone2',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.phone2.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.email',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.email.description',
            'config' => [
                'type' => 'email',
                'size' => 30,
                'eval' => 'nospace',
                'default' => ''
            ]
        ],
        'url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.url',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.url.description',
            'config' => [
                'type' => 'link',
            ]
        ],
        'whatsapp' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.whatsapp',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.whatsapp.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'lastcontact' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.lastcontact',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.lastcontact.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'required' => false,
                'size' => 20,
                'default' => 0,
            ],
        ],
        'opening_hours' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.opening_hours',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.opening_hours.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim',
                'default' => ''
            ]
        ],
        'notes' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.notes',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.notes.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'default' => ''
            ]
        ],
        'reading_times' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.reading_times',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.reading_times.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim',
                'default' => ''
            ]
        ],
        'vp_languages' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.vp_languages',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.vp_languages.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'items' => [
                    ['label' => 'Deutsch','value' => '1'],
                    ['label' => 'Englisch','value' => '2'],
                    ['label' => 'Türkisch','value' => '3'],
                    ['label' => 'Italienisch','value' => '4'],
                    ['label' => 'Albanisch','value' => '5'],
                    ['label' => 'Chinesisch','value' => '6'],
                    ['label' => 'Russisch','value' => '7'],
                    ['label' => 'Arabisch','value' => '8'],
                    ['label' => 'Griechisch','value' => '9'],
                    ['label' => 'Rumänisch','value' => '10'],
                    ['label' => 'Kurdisch','value' => '11'],
                    ['label' => 'Portugiesisch','value' => '12'],
                    ['label' => 'Französisch','value' => '13'],
                    ['label' => 'Indisch','value' => '14'],
                    ['label' => 'Polnisch','value' => '15'],
                    ['label' => 'Ungarisch','value' => '16'],
                    ['label' => 'Spanisch','value' => '17'],
                    ['label' => 'Sonstiges','value' => '18'],
                ],
            ],
        ],
        'vp_number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.vp_number',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.vp_number.description',
            'config' => [
                'type' => 'number',
                'size' => 4,
                'default' => 0
            ]
        ],
        'vlpaten' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.vlpaten',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.vlpaten.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_leseohren_domain_model_person',
                'MM' => 'tx_leseohren_organization_person_mm',
                'size' => 10,
                'autoSizeMax' => 20,
            ],
        ],
        'contact_person' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.contact_person',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_organization.contact_person.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim',
                'default' => ''
            ]
        ],

    ],
];
