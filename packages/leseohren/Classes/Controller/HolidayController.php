<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
//use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use SKom\Leseohren\Domain\Repository\EasterdateRepository;
use SKom\Leseohren\Domain\Model\Easterdate;

/**
 * This file is part of the "Leseohren" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Sven Kalbhenn <sven@skom.de>, SKom
 */

/**
 * HolidayController
 */
class HolidayController extends ActionController
{
    /**
     * EasterdateRepository
     *
     * @var EasterdateRepository
     */
    protected $easterdateRepository = null;

    public function __construct(EasterdateRepository $easterdateRepository)
    {
        $this->easterdateRepository = $easterdateRepository;
    }

    /**
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $today = new \DateTime("now");
        $thisYear = $today->format('Y');

        // Christmas date for the current year
        $christmas = new \DateTimeImmutable("$thisYear-12-24");
        // Calculate the number of days from today to Christmas
        $interval = $today->diff($christmas);
        $daysUntilChristmas = $interval->days;
        $this->view->assign('daysUntilChristmas', $daysUntilChristmas);

        // Fetch all Easter dates from the repository
        $easterdates = $this->easterdateRepository->findAll();
        $days = 366;
        $easterDate = '';
        foreach ($easterdates as $easterdate) {
            $easterDateTime = $easterdate->getEasterdate();
            $interval = $today->diff($easterDateTime, false);
            if(($interval->invert == 0) AND ($interval->days < $days)) {
                $days = $interval->days;
                $easterDate = $easterDateTime->format('d.m.Y');
            }
        }
        $this->view->assign('easterDate', $easterDate);
        $this->view->assign('daysUntilEaster', $days);
        return $this->htmlResponse();
    }
}
