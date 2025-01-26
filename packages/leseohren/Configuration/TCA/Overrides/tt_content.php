<?php

defined('TYPO3') || die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;


$personenPluginSignature = ExtensionUtility::registerPlugin(
    'Leseohren',
    'Personen',
    'Personen'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$personenPluginSignature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    $personenPluginSignature,
    'FILE:EXT:leseohren/Configuration/FlexForms/Leseohren_Personen.xml'
);

ExtensionUtility::registerPlugin(
    'Leseohren',
    'Organizations',
    'Organizations'
);

$eventsPluginSignature = ExtensionUtility::registerPlugin(
    'Leseohren',
    'Events',
    'Events'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$eventsPluginSignature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    $eventsPluginSignature,
    'FILE:EXT:leseohren/Configuration/FlexForms/Leseohren_Events.xml'
);

ExtensionUtility::registerPlugin(
    'Leseohren',
    'Blackboards',
    'Blackboards'
);

$personDashboardPluginSignature = ExtensionUtility::registerPlugin(
    'Leseohren',
    'PersonDashboard',
    'PersonDashboard'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$personDashboardPluginSignature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    $personDashboardPluginSignature,
    'FILE:EXT:leseohren/Configuration/FlexForms/Leseohren_PersonDashboard.xml'
);

$holidayPluginSignature = ExtensionUtility::registerPlugin(
    'Leseohren',
    'Holidays',
    'Holidays',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$holidayPluginSignature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    $holidayPluginSignature,
    'FILE:EXT:leseohren/Configuration/FlexForms/Leseohren_Holidays.xml'
);

ExtensionUtility::registerPlugin(
    'Leseohren',
    'Presents',
    'Presents'
);

ExtensionUtility::registerPlugin(
    'Leseohren',
    'Registrations',
    'Registrations'
);
