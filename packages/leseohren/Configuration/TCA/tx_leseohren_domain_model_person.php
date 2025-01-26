<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person',
        'label' => 'lastname',
        'label_alt' => 'firstname',
        'label_alt_force' => true,
        'default_sortby' => 'lastname ASC',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'firstname,lastname',
        'iconfile' => 'EXT:leseohren/Resources/Public/Icons/tx_leseohren_domain_model_person.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => ['showitem' => '
                --div--;Person,
                    firstname, lastname, gender, title, job, birthday,
                    --palette--;;addressPalette,
                    --palette--;;contactPalette,
                    awareness,
                    notes,
                --div--;Categories,
                    categories,
                --div--;Information,
                    --palette--;;statusPalette,
                    travel_options, languages,
                    --palette--;;preferencePalette,
                    organizations,
                --div--;Mitgliedschaft,
                    --palette--;;membershipPalette,
                    memberorg,
                    --palette--;;paymentPalette,
                    --palette--;;bankaccountPalette,
                    paypal,
                --div--;Files,
                    --palette--;;fuehrungszeugnisPalette,
                    file_mandat, file_others,
                --div--;Events,
                    registrations, speakerevent,
                --div--;Gifts,
                    donations,
                --div--;Blackboards,
                    blackboards,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden,
                    starttime,
                    endtime'],
    ],
    'palettes' => [
        'addressPalette' => [
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.addressPalette.description',
            'showitem' => 'street1, --linebreak--, street2, --linebreak--, zip, city, district',
        ],
        'contactPalette' => [
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.contactPalette.description',
            'showitem' => 'phone_landline, phone_mobile, --linebreak--, email, whatsapp',
        ],
        'statusPalette' => [
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.statusPalette.description',
            'showitem' => 'status, statuschange_date, --linebreak--, statusbegin_date, statusend_date',
        ],
        'preferencePalette' => [
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.preferencePalette.description',
            'showitem' => 'preference_agegroup, preference_organization_type',
        ],
        'membershipPalette' => [
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.membershipPalette.description',
            'showitem' => 'membership_type, membership_fee',
        ],
        'paymentPalette' => [
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.paymentPalette.description',
            'showitem' => 'payment_method, mandatsreferenz',
        ],
        'bankaccountPalette' => [
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.bankaccountPalette.description',
            'showitem' => 'iban, swift, --linebreak--, account_owner, bankname',
        ],
        'fuehrungszeugnisPalette' => [
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.file_fuehrungszeugnis',
            'showitem' => 'file_fuehrungszeugnis, --linebreak--, fuehrungszeugnis_checked, fuehrungszeugnis_date',
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
                    'startingPoints' => '1',
                    'nonSelectableLevels' => 0,
                ],
            ],
        ],

        'gender' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.gender',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.gender.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.gender.0', 'value' => 0],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.gender.1', 'value' => 1],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.gender.2', 'value' => 2],
                ],
                'size' => 1,
                'maxitems' => 1,
                'required' => true,
                'eval' => ''
            ],
        ],

        'firstname' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.firstname',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.firstname.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'lastname' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.lastname',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.lastname.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
                'required' => true
            ],
        ],
        'title' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.title',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.title.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
                'required' => false
            ],
        ],
        'job' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.job',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.job.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
                'required' => false
            ],
        ],
        'birthday' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.birthday',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.birthday.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'required' => false,
                'size' => 20,
                'default' => 0,
            ],
        ],
        'street1' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.street1',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.street1.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'street2' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.street2',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.street2.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.zip',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.zip.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.city',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.city.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'district' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.district',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.district.description',
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
        'phone_landline' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.phone_landline',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.phone_landline.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'phone_mobile' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.phone_mobile',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.phone_mobile.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.email',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.email.description',
            'config' => [
                'type' => 'email',
                'eval' => 'nospace,email',
            ]
        ],
        'whatsapp' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.whatsapp',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.whatsapp.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'awareness' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.awareness',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.awareness.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.awareness.0', 'value' => 0],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.awareness.1', 'value' => 1],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.awareness.2', 'value' => 2],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.awareness.3', 'value' => 3],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.awareness.4', 'value' => 4],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.awareness.5', 'value' => 5],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.awareness.6', 'value' => 6],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.awareness.7', 'value' => 7],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.awareness.8', 'value' => 8],
                ],
                'size' => 1,
                'maxitems' => 1,
                'required' => true,
                'eval' => ''
            ],
        ],
        'notes' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.notes',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.notes.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 10,
                'eval' => 'trim',
                'default' => ''
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.status',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.status.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.status.0', 'value' => 0],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.status.1', 'value' => 1],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.status.2', 'value' => 2],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'statuschange_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.statuschange_date',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.statuschange_date.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'required' => true,
                'size' => 20,
                'default' => 0,
            ],
        ],
        'statusbegin_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.statusbegin_date',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.statusbegin_date.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'required' => true,
                'size' => 20,
                'default' => 0,
            ],
        ],
        'statusend_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.statusend_date',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.statusend_date.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'required' => false,
                'size' => 20,
                'default' => 0,
            ],
        ],
        'travel_options' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.travel_options',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.travel_options.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.travelOptions.0', 'value' => 0],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.travelOptions.1', 'value' => 1],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.travelOptions.2', 'value' => 2],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.travelOptions.3', 'value' => 3],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.travelOptions.4', 'value' => 4],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.travelOptions.5', 'value' => 5],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'languages' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.languages',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.languages.description',
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
        'preference_agegroup' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.preference_agegroup',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.preference_agegroup.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'items' => [
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.ageGroup.0', 'value' => 0],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.ageGroup.1', 'value' => 1],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.ageGroup.2', 'value' => 2],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.ageGroup.3', 'value' => 3],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.ageGroup.4', 'value' => 4],
                ],
            ],
        ],
        'preference_organization_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.preference_organization_type',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.preference_organization_type.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'items' => [
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.orgType.1', 'value' => 1],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.orgType.2', 'value' => 2],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.orgType.3', 'value' => 3],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.orgType.4', 'value' => 4],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.orgType.5', 'value' => 5],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.orgType.6', 'value' => 6],
                ],
            ],
        ],
        'membership_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.membership_type',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.membership_type.description',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.membershipType.0', 'value' => 0],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.membershipType.1', 'value' => 1],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.membershipType.2', 'value' => 2],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.membershipType.3', 'value' => 3],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.membershipType.4', 'value' => 4],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.membershipType.5', 'value' => 5],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'membership_fee' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.membership_fee',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.membership_fee.description',
            'displayCond' => 'FIELD:membership_type:!=:0',
            'config' => [
                'type' => 'number',
                'default' => 0,
                'format' => 'decimal',
                'range' => [
                    'lower' => 0,
                    'upper' => 999
                ],
                'size' => 3,
                'slider' => [
                    'step' => 0.5,
                    'width' => 100,
                ],
            ],
        ],
        'payment_method' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.payment_method',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.payment_method.description',
            'displayCond' => 'FIELD:membership_type:!=:0',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.paymentMethod.0', 'value' => 0],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.paymentMethod.1', 'value' => 1],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.paymentMethod.2', 'value' => 2],
                    ['label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:tx_leseohren.paymentMethod.3', 'value' => 3],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'memberorg' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.memberorg',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.memberorg.description',
            'displayCond' => 'FIELD:membership_type:=:4',
            'config' => [
                'type' => 'input',
                'size' => 34,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'mandatsreferenz' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.mandatsreferenz',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.mandatsreferenz.description',
            'displayCond' => 'FIELD:membership_type:!=:0',
            'config' => [
                'type' => 'input',
                'size' => 34,
                'min' => 0,
                'max' => 34,
                'eval' => 'trim,is_in',
                'is_in' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ .,+-/',
                'default' => ''
            ],
        ],
        'iban' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.iban',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.iban.description',
            'displayCond' => [
                'OR' => [
                    'FIELD:payment_method:=:1',
                    'FIELD:payment_method:=:2'
                ]
            ],
            'config' => [
                'type' => 'input',
                'size' => 34,
                'min' => 14,
                'max' => 22,
                'eval' => 'alphanum,upper,nospace',
                'default' => ''
            ],
        ],
        'swift' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.swift',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.swift.description',
            'displayCond' => [
                'OR' => [
                    'FIELD:payment_method:=:1',
                    'FIELD:payment_method:=:2'
                ]
            ],
            'config' => [
                'type' => 'input',
                'size' => 30,
                'min' => 8,
                'max' => 11,
                'eval' => 'alphanum,upper,nospace',
                'default' => ''
            ],
        ],
        'account_owner' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.account_owner',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.account_owner.description',
            'displayCond' => [
                'OR' => [
                    'FIELD:payment_method:=:1',
                    'FIELD:payment_method:=:2'
                ]
            ],
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'bankname' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.bankname',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.bankname.description',
            'displayCond' => [
                'OR' => [
                    'FIELD:payment_method:=:1',
                    'FIELD:payment_method:=:2'
                ]
            ],
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'paypal' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.paypal',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.paypal.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
            'displayCond' => 'FIELD:payment_method:=:3',
        ],
        'file_fuehrungszeugnis' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.file_fuehrungszeugnis',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.file_fuehrungszeugnis.description',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'pdf,doc,docx,xls,xlsx,txt,md,zip,tar,gz'
            ],
        ],
        'fuehrungszeugnis_checked' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.fuehrungszeugnis_checked',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.fuehrungszeugnis_checked.description',
            'config' => [
                'type' => 'check',
                'items' => [
                    [
                        'label' => 'geprüft',
                    ],
                ],
            ],
        ],
        'fuehrungszeugnis_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.fuehrungszeugnis_date',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.fuehrungszeugnis_date.description',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'required' => false,
                'size' => 20,
                'default' => 0,
            ],
        ],
        'file_mandat' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.file_mandat',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.file_mandat.description',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'pdf,doc,docx,xls,xlsx,txt,md,zip,tar,gz'
            ],
        ],
        'file_others' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.file_others',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.file_others.description',
            'config' => [
                'type' => 'file',
                'maxitems' => 20,
                'allowed' => 'pdf,doc,docx,xls,xlsx,txt,md,zip,tar,gz'
            ],
        ],
        'donations' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.donations',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.donations.description',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_leseohren_domain_model_present',
                'foreign_field' => 'person',
                'foreign_default_sortby' => 'ORDER BY gift_date DESC',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'blackboards' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.blackboards',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.blackboards.description',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_leseohren_domain_model_blackboard',
                'foreign_field' => 'person',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'organizations' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.organizations',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.organizations.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_leseohren_domain_model_organization',
                'MM' => 'tx_leseohren_organization_person_mm',
                'MM_opposite_field' => 'organizations',
                'size' => 10,
                'autoSizeMax' => 20,
            ],
        ],
        'speakerevent' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren.speaker',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren.speaker.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_leseohren_domain_model_event',
                'MM' => 'tx_leseohren_speakerevent_person_mm',
                'MM_opposite_field' => 'speakerevent',
                'size' => 10,
                'autoSizeMax' => 20,
            ],
        ],
        'registrations' => [
            'exclude' => false,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.registrations',
            'description' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.registrations.description',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_leseohren_domain_model_registration',
                'foreign_field' => 'person',
                'foreign_default_sortby' => 'ORDER BY registration_date DESC',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],

    ],
];
