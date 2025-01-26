<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * This file is part of the "Leseohren" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Sven Kalbhenn <sven@skom.de>, SKom
 */

/**
 * The repository for Presents
 */
class PresentRepository extends Repository
{
    protected $defaultOrderings = [
        'gift_date' => QueryInterface::ORDER_DESCENDING
    ];
}
