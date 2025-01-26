<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

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
 * The repository for Events
 */
class EventRepository extends Repository
{
    public function initializeObject(): void
    {
        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    protected $defaultOrderings = [
        'start_date' => QueryInterface::ORDER_DESCENDING
    ];


    /**
     * Find upcoming events
     *
     * @return QueryResultInterface
     */
    public function findUpcomingEvents(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->greaterThanOrEqual('end_date', new \DateTime())
        );
        $result = $query->execute();
        return $result;
    }
    /**
     * Find upcoming events
     *
     * @return QueryResultInterface
     */
    public function findPastEvents(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->lessThan('end_date', new \DateTime())
        );
        //$query->getQuerySettings()->setIgnoreEnableFields(true);
        //$query->getQuerySettings()->setEnableFieldsToBeIgnored(['disabled']);
        $result = $query->execute();

        // Debugging
        //$typo3DbQueryParser = GeneralUtility::makeInstance(Typo3DbQueryParser::class);
        //$queryBuilder = $typo3DbQueryParser->convertQueryToDoctrineQueryBuilder($query);
        //DebugUtility::debug($queryBuilder->getSQL());
        //DebugUtility::debug($queryBuilder->getParameters());
        return $result;
    }

    /**
     * Find all events by category
     *
     * @param array $categories
     * @param bool $invert Should the result be inverted
     * @return QueryResultInterface
     */
    public function searchCategory($categories = [], $invert = false)
    {
        $constraints = [];
        $query = $this->createQuery();
        foreach ($categories as $category) {
            $constraints[] = $query->contains('categories', \intval($category));
        }
        if (!empty($constraints)) {
            if($invert == false){
                $query->matching(
                    $query->logicalAnd(
                        $query->logicalOr(...array_values($constraints)),
                        $query->greaterThanOrEqual('end_date', new \DateTime())
                    )
                );
            }else {
                $query->matching(
                    $query->logicalAnd(
                        $query->logicalNot(
                            $query->logicalOr(...array_values($constraints))
                        ),
                        $query->greaterThanOrEqual('end_date', new \DateTime())
                    )
                );
            }
        }
        return $query->execute();
    }
}
