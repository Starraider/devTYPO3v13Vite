<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use SKom\Leseohren\Domain\Model\Event;

use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * This file is part of the "Leseohren" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Sven Kalbhenn <sven@skom.de>, SKom
 */

/**
 * The repository for Registration
 */
class RegistrationRepository extends Repository
{
    public function initializeObject(): void
    {
        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }


    protected $defaultOrderings = [
        'registration_date' => QueryInterface::ORDER_ASCENDING
    ];


    /**
     * Finds all waitlist registrations for a specific event
     *
     * @param Event $event The event object
     * @return QueryResultInterface
     */
    public function findWaitlistByEvent(Event $event): QueryResultInterface
    {
        $query = $this->createQuery();
        $eventConstraint = $query->equals('event', $event);
        $waitlistConstraint = $query->equals('onwaitlist', true);

        $query->matching(
            $query->logicalAnd($eventConstraint, $waitlistConstraint)
        );
        // $typo3DbQueryParser = GeneralUtility::makeInstance(Typo3DbQueryParser::class);
		// $queryBuilder = $typo3DbQueryParser->convertQueryToDoctrineQueryBuilder($query);
		// DebuggerUtility::var_dump($queryBuilder->getSQL());
		// DebuggerUtility::var_dump($queryBuilder->getParameters());

        return $query->execute();
    }

    /**
     * Finds all regular registrations (not on waitlist) for a specific event
     *
     * @param Event $event The event object
     * @return QueryResultInterface
     */
    public function findRegistrationsByEvent(Event $event): QueryResultInterface
    {
        $query = $this->createQuery();
        $eventConstraint = $query->equals('event', $event);
        $regularConstraint = $query->equals('onwaitlist', false);

        $query->matching(
            $query->logicalAnd($eventConstraint, $regularConstraint)
        );
        return $query->execute();
    }
}
