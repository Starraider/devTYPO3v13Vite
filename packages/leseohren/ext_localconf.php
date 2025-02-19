<?php
use SKom\Leseohren\Controller\PersonController;
use SKom\Leseohren\Controller\OrganizationController;
use SKom\Leseohren\Controller\EventController;
use SKom\Leseohren\Controller\BlackboardController;
use SKom\Leseohren\Controller\PersonDashboardController;
use SKom\Leseohren\Controller\HolidayController;
use SKom\Leseohren\Controller\PresentController;
use SKom\Leseohren\Controller\RegistrationController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

(static function () {
    ExtensionUtility::configurePlugin(
        'Leseohren',
        'Personen',
        [
            PersonController::class => 'list, index, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            PersonController::class => 'new, create, edit, update, delete'
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    ExtensionUtility::configurePlugin(
        'Leseohren',
        'Organizations',
        [
            OrganizationController::class => 'list, index, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            OrganizationController::class => 'new, create, edit, update, delete'
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    ExtensionUtility::configurePlugin(
        'Leseohren',
        'Events',
        [
            EventController::class => 'list, listPast, index, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            EventController::class => 'new, create, edit, update, delete'
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    ExtensionUtility::configurePlugin(
        'Leseohren',
        'Blackboards',
        [
            BlackboardController::class => 'list, index, show, new, create, edit, update, delete, deletegoperson'
        ],
        // non-cacheable actions
        [
            BlackboardController::class => 'new, create, edit, update, delete, deletegoperson'
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );
    ExtensionUtility::configurePlugin(
        'Leseohren',
        'PersonDashboard',
        [
            PersonDashboardController::class => 'statuschange, birthdays'
        ],
        // non-cacheable actions
        [
            PersonDashboardController::class => ''
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );
    ExtensionUtility::configurePlugin(
        'Leseohren',
        'Holidays',
        [
            HolidayController::class => 'index'
        ],
        // non-cacheable actions
        [
            HolidayController::class => ''
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );
    ExtensionUtility::configurePlugin(
        'Leseohren',
        'Presents',
        [
            PresentController::class => 'list, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            PresentController::class => 'new, create, edit, update, delete'
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );
    ExtensionUtility::configurePlugin(
        'Leseohren',
        'Registrations',
        [
            RegistrationController::class => 'list, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            RegistrationController::class => 'new, create, edit, update, delete'
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );
    // Register TypeConverter for file upload
    //ExtensionUtility::registerTypeConverter(
    //    \SKom\Leseohren\Property\TypeConverter\UploadedFileReferenceConverter::class
    //);
})();
