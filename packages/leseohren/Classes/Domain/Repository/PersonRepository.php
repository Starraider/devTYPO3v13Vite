<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;


use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\DebugUtility;

/**
 * This file is part of the "Leseohren" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Sven Kalbhenn <sven@skom.de>, SKom
 */
/**
 * The repository for people
 */
class PersonRepository extends Repository
{
    public function initializeObject(): void
    {
        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * Find all persons having a birthday today
     *
     * @param string $interval Number of days to look ahead
     * @return QueryResultInterface
     */
    public function upcomingBirthdays($interval = '7')
    {
        $query = $this->createQuery();
        $sql = 'SELECT uid, pid, firstname, lastname, title, birthday, gender, email FROM tx_leseohren_domain_model_person WHERE DATE_ADD(FROM_UNIXTIME(birthday), INTERVAL YEAR(CURDATE())-YEAR(FROM_UNIXTIME(birthday)) + IF(DAYOFYEAR(CURDATE()) > DAYOFYEAR(FROM_UNIXTIME(birthday)),1,0)YEAR) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL '.$interval.' DAY) ORDER BY DATE_FORMAT(FROM_UNIXTIME(birthday), "%m-%d") ASC';
        $query->statement($sql);
        /*
        SELECT * FROM `tx_leseohren_domain_model_person` WHERE DATE_ADD(FROM_UNIXTIME(birthday), INTERVAL YEAR(CURDATE())-YEAR(FROM_UNIXTIME(birthday)) + IF(DAYOFYEAR(CURDATE()) > DAYOFYEAR(FROM_UNIXTIME(birthday)),1,0)YEAR) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY);
        $query->statement($statement, array $parameters = [])
        */
        return $query->execute();
    }

    /**
     * Find all persons whose status will change the next 7 days
     *
     * @param string $interval Number of days to look ahead
     * @return QueryResultInterface
     */
    public function upcomingStatusChange($interval = '7')
    {
        $today = new \DateTime('today');
        $thisweek = new \DateTime('today');
        $thisweek = $thisweek->modify('+'.$interval.' days');
        $query = $this->createQuery();
        $query->matching(
            $query->between('statusend_date', $today, $thisweek)
        );
        $query->setOrderings(['statusend_date' => QueryInterface::ORDER_ASCENDING]);

        // $typo3DbQueryParser = GeneralUtility::makeInstance(Typo3DbQueryParser::class);
        // $queryBuilder = $typo3DbQueryParser->convertQueryToDoctrineQueryBuilder($query);
        // DebuggerUtility::var_dump($queryBuilder->getSQL());
        // DebuggerUtility::var_dump($queryBuilder->getParameters());

        return $query->execute();
    }

    /**
     * Find all persons whose fuehrungszeugnis will expire the next 14 days
     *
     * @param string $interval Number of days to look ahead
     * @return QueryResultInterface
     */
    public function expiredFuehrungszeugnis($interval = '14')
    {
        $fiveYearsAgo = new \DateTime('today');
        $fiveYearsAgo = $fiveYearsAgo->modify('-5 years');
        $fiveYearsAgo = $fiveYearsAgo->modify('+'.$interval.' days');
        //DebugUtility::debug($fiveYearsAgo, 'vorJahren');
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->logicalNot(
                    $query->equals('fuehrungszeugnis_date', 0)
                ),
                $query->lessThanOrEqual('fuehrungszeugnis_date', $fiveYearsAgo)
            )
        );
        $query->setOrderings(['fuehrungszeugnis_date' => QueryInterface::ORDER_ASCENDING]);

        // $typo3DbQueryParser = GeneralUtility::makeInstance(Typo3DbQueryParser::class);
        // $queryBuilder = $typo3DbQueryParser->convertQueryToDoctrineQueryBuilder($query);
        // DebuggerUtility::var_dump($queryBuilder->getSQL());
        // DebuggerUtility::var_dump($queryBuilder->getParameters());

        return $query->execute();
    }

    /**
     * Find all persons by category
     *
     * @param string $category
     * @param bool $invert Should the result be inverted
     * @return QueryResultInterface
     */
    public function searchCategory($category, $invert = false)
    {
        $query = $this->createQuery();
        if($invert == false){
            $query->matching(
                $query->in('categories', $category)
            );
        }else {
            $query->matching(
                $query->logicalNot(
                    $query->in('categories', $category)
                )
            );
        }
        return $query->execute();
    }

    protected $defaultOrderings = [
        'lastname' => QueryInterface::ORDER_ASCENDING,
        'firstname' => QueryInterface::ORDER_ASCENDING
    ];


    /**
     * Find all events by category UID
     *
     * @param array $categories
     * @param bool $invert Should the result be inverted
     * @return QueryResultInterface
     */
    public function searchCategoryUid($categories = [], $invert = false)
    {
        $constraints = [];
        $query = $this->createQuery();
        foreach ($categories as $category) {
            $constraints[] = $query->contains('categories', \intval($category));
        }
        if (!empty($constraints)) {
            if($invert == false){
                $query->matching(
                    $query->logicalOr(...array_values($constraints)),
                );
            }else {
                $query->matching(
                    $query->logicalNot(
                        $query->logicalOr(...array_values($constraints))
                    ),
                );
            }
        }
        return $query->execute();
    }
}
