<?php

defined('TYPO3') || die();

(static function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Leseohren',
        'Personen',
        [
            \SKom\Leseohren\Controller\PersonController::class => 'list, index, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            \SKom\Leseohren\Controller\PersonController::class => 'new, create, edit, update, delete'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Leseohren',
        'Organizations',
        [
            \SKom\Leseohren\Controller\OrganizationController::class => 'list, index, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            \SKom\Leseohren\Controller\OrganizationController::class => 'new, create, edit, update, delete'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Leseohren',
        'Events',
        [
            \SKom\Leseohren\Controller\EventController::class => 'list, listPast, index, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            \SKom\Leseohren\Controller\EventController::class => 'new, create, edit, update, delete'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Leseohren',
        'Blackboards',
        [
            \SKom\Leseohren\Controller\BlackboardController::class => 'list, index, show, new, create, edit, update, delete, deletegoperson'
        ],
        // non-cacheable actions
        [
            \SKom\Leseohren\Controller\BlackboardController::class => 'new, create, edit, update, delete, deletegoperson'
        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Leseohren',
        'PersonDashboard',
        [
            \SKom\Leseohren\Controller\PersonDashboardController::class => 'statuschange, birthdays'
        ],
        // non-cacheable actions
        [
            \SKom\Leseohren\Controller\PersonDashboardController::class => ''
        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Leseohren',
        'Holidays',
        [
            \SKom\Leseohren\Controller\HolidayController::class => 'index'
        ],
        // non-cacheable actions
        [
            \SKom\Leseohren\Controller\HolidayController::class => ''
        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Leseohren',
        'Presents',
        [
            \SKom\Leseohren\Controller\PresentController::class => 'list, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            \SKom\Leseohren\Controller\PresentController::class => 'new, create, edit, update, delete'
        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Leseohren',
        'Registrations',
        [
            \SKom\Leseohren\Controller\RegistrationController::class => 'list, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            \SKom\Leseohren\Controller\RegistrationController::class => 'new, create, edit, update, delete'
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    personen {
                        iconIdentifier = leseohren-plugin-personen
                        title = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_personen.name
                        description = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_personen.description
                        tt_content_defValues {
                            CType = list
                            list_type = leseohren_personen
                        }
                    }
                    organizations {
                        iconIdentifier = leseohren-plugin-organizations
                        title = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_organizations.name
                        description = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_organizations.description
                        tt_content_defValues {
                            CType = list
                            list_type = leseohren_organizations
                        }
                    }
                    events {
                        iconIdentifier = leseohren-plugin-events
                        title = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_events.name
                        description = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_events.description
                        tt_content_defValues {
                            CType = list
                            list_type = leseohren_events
                        }
                    }
                    blackboards {
                        iconIdentifier = leseohren-plugin-blackboards
                        title = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_blackboards.name
                        description = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_blackboards.description
                        tt_content_defValues {
                            CType = list
                            list_type = leseohren_blackboards
                        }
                    }
                    persondashboard {
                        iconIdentifier = leseohren-plugin-events
                        title = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_persondashboard.name
                        description = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_persondashboard.description
                        tt_content_defValues {
                            CType = list
                            list_type = leseohren_persondashboard
                        }
                    }
                    holidays {
                        iconIdentifier = leseohren-plugin-holidays
                        title = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_holidays.name
                        description = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_holidays.description
                        tt_content_defValues {
                            CType = list
                            list_type = leseohren_holidays
                        }
                    }
                    presents {
                        iconIdentifier = leseohren-plugin-presents
                        title = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_presents.name
                        description = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_presents.description
                        tt_content_defValues {
                            CType = list
                            list_type = leseohren_presents
                        }
                    }
                    registrations {
                        iconIdentifier = leseohren-plugin-registrations
                        title = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_registrations.name
                        description = LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_registrations.description
                        tt_content_defValues {
                            CType = list
                            list_type = leseohren_registrations
                        }
                    }
                }
                show = *
            }
        }'
    );
    // Register TypeConverter for file upload
    //\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter(
    //    \SKom\Leseohren\Property\TypeConverter\UploadedFileReferenceConverter::class
    //);
})();
