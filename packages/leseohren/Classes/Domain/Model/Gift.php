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
 * Geschenk
 */
class Gift extends AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected $title = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * Returns the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
