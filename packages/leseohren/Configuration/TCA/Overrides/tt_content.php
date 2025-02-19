<?php

defined('TYPO3') || die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$personenPluginSignature = ExtensionUtility::registerPlugin(
    'Leseohren',                  // extension name
    'Personen',                   // plugin name
    'Personen',                   // plugin title
    'leseohren-plugin-personen',  // icon identifier
    'default',                    // group
    'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_personen.description' // plugin description
);

ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,', $personenPluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:leseohren/Configuration/FlexForms/Leseohren_Personen.xml',
    $personenPluginSignature
);

ExtensionUtility::registerPlugin(
    'Leseohren',
    'Organizations',
    'Organizations',
    'leseohren-plugin-organizations',  // icon identifier
    'default',                         // group
    'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_organizations.description' // plugin description
);

$eventsPluginSignature = ExtensionUtility::registerPlugin(
    'Leseohren',
    'Events',
    'Events',
    'leseohren-plugin-events',  // icon identifier
    'default',                  // group
    'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_events.description' // plugin description
);
ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,', $eventsPluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:leseohren/Configuration/FlexForms/Leseohren_Events.xml',
    $eventsPluginSignature
);

ExtensionUtility::registerPlugin(
    'Leseohren',
    'Blackboards',
    'Blackboards',
    'leseohren-plugin-blackboards',  // icon identifier
    'default',                       // group
    'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_blackboards.description' // plugin description
);

$personDashboardPluginSignature = ExtensionUtility::registerPlugin(
    'Leseohren',
    'PersonDashboard',
    'PersonDashboard',
    'leseohren-plugin-personen',  // icon identifier
    'default',                  // group
    'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_persondashboard.description' // plugin description
);
ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,', $personDashboardPluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:leseohren/Configuration/FlexForms/Leseohren_PersonDashboard.xml',
    $personDashboardPluginSignature
);

$holidayPluginSignature = ExtensionUtility::registerPlugin(
    'Leseohren',
    'Holidays',
    'Holidays',
    'leseohren-plugin-holidays',  // icon identifier
    'default',                    // group
    'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_holidays.description' // plugin description
);
ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,', $holidayPluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:leseohren/Configuration/FlexForms/Leseohren_Holidays.xml',
    $holidayPluginSignature
);

ExtensionUtility::registerPlugin(
    'Leseohren',
    'Presents',
    'Presents',
    'leseohren-plugin-presents',  // icon identifier
    'default',                    // group
    'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_presents.description' // plugin description
);

ExtensionUtility::registerPlugin(
    'Leseohren',
    'Registrations',
    'Registrations',
    'leseohren-plugin-registrations',  // icon identifier
    'default',                         // group
    'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_registrations.description' // plugin description
);
