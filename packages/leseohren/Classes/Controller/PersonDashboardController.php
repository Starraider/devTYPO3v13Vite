<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
//use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use SKom\Leseohren\Domain\Repository\PersonRepository;
use SKom\Leseohren\Domain\Repository\CategoryRepository;
use SKom\Leseohren\Domain\Model\Person;

/**
 * This file is part of the "Leseohren" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Sven Kalbhenn <sven@skom.de>, SKom
 */

/**
 * PersonController
 */
class PersonDashboardController extends ActionController
{
    /**
     * personRepository
     *
     * @var PersonRepository
     */
    protected $personRepository = null;

    /**
     * categoryRepository
     *
     * @var CategoryRepository
     */
    protected $categoryRepository = null;

    public function __construct(PersonRepository $personRepository, CategoryRepository $categoryRepository)
    {
        $this->personRepository = $personRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * action birthdays
     *
     * @return ResponseInterface
     */
    public function birthdaysAction(): ResponseInterface
    {
        $categories = $this->categoryRepository->findBy(['parent' => '1']);
        $this->view->assign('categories', $categories);
        $people = $this->personRepository->upcomingBirthdays();
        $this->view->assign('people', $people);
        return $this->htmlResponse();
    }

    /**
     * action statuschange
     *
     * @return ResponseInterface
     */
    public function statuschangeAction(): ResponseInterface
    {
        // categories
        $categories = $this->categoryRepository->findBy(['parent' => '1']);
        $this->view->assign('categories', $categories);
        // upcoming status changes
        $statusInterval = $this->settings['leseohren_persondashboard']['status_warningperiod'] ?? '7';
        $statuspeople = $this->personRepository->upcomingStatusChange($statusInterval);
        $this->view->assign('statuspeople', $statuspeople);
        // upcoming birthdays
        $birthdayInterval = $this->settings['leseohren_persondashboard']['birthday_warningperiod'] ?? '7';
        $birthdaypeople = $this->personRepository->upcomingBirthdays($birthdayInterval);
        $this->view->assign('birthdaypeople', $birthdaypeople);
        // expired fuehrungszeugnis
        $fuehrungszeugnisInterval = $this->settings['leseohren_persondashboard']['fuehrungszeugnis_expired_warningperiod'] ?? '14';
        $expiredFuehrungszeugnisPeople = $this->personRepository->expiredFuehrungszeugnis($fuehrungszeugnisInterval);
        $this->view->assign('expiredfuehrungszeugnispeople', $expiredFuehrungszeugnisPeople);
        return $this->htmlResponse();
    }
}
