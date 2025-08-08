<?php

declare(strict_types=1);

namespace SKom\Leseohren\Updates;

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;

#[UpgradeWizard('skomLeseohrenCTypeMigration')]
final class SKomLeseohrenCTypeMigration extends AbstractListTypeToCTypeUpdate
{
    public function getTitle(): string
    {
        return 'Migrate "SKom Leseohren" plugins to content elements.';
    }

    public function getDescription(): string
    {
        return 'The "SKom Leseohren" plugins are now registered as content element. Update migrates existing records and backend user permissions.';
    }

    /**
     * This must return an array containing the "list_type" to "CType" mapping
     *
     *  Example:
     *
     *  [
     *      'pi_plugin1' => 'pi_plugin1',
     *      'pi_plugin2' => 'new_content_element',
     *  ]
     *
     * @return array<string, string>
     */
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'leseohren_personen' => 'leseohren_personen',
            'leseohren_organizations' => 'leseohren_organizations',
            'leseohren_events' => 'leseohren_events',
            'leseohren_holidays' => 'leseohren_holidays',
            'leseohren_blackboards' => 'leseohren_blackboards',
            'leseohren_presents' => 'leseohren_presents',
            'leseohren_registrations' => 'leseohren_registrations',
            'leseohren_persondashboard' => 'leseohren_persondashboard',
        ];
    }
}
