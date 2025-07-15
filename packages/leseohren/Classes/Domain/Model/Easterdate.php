<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * This file is part of the "Leseohren" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Sven Kalbhenn <sven@skom.de>, SKom
 */

/**
 * Dates of easter
 */
class Easterdate extends AbstractEntity
{

    /**
     * easterdate
     *
     * @var \DateTime
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected $easterdate;

    /**
     * Returns the easterdate
     *
     * @return \DateTime
     */
    public function getEasterdate()
    {
        return $this->easterdate;
    }

    /**
     * Sets the easterdate
     *
     * @param \DateTime $easterdate
     * @return void
     */
    public function setEasterdate(\DateTime $easterdate): void
    {
        $this->easterdate = $easterdate;
    }
}
