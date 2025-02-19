<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use SKom\Leseohren\Domain\Repository\BlackboardRepository;
use SKom\Leseohren\Domain\Model\Blackboard;
use SKom\Leseohren\Domain\Model\Person;
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
 * BlackboardController
 */
class BlackboardController extends ActionController
{
    /**
     * blackboardRepository
     *
     * @var BlackboardRepository
     */
    protected $blackboardRepository = null;

    public function __construct(BlackboardRepository $blackboardRepository)
    {
        $this->blackboardRepository = $blackboardRepository;
    }

    /**
     * action index
     *
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action list
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        //DebugUtility::debug($this, 'blackboardController');
        $blackboards = $this->blackboardRepository->findAll();
        $this->view->assign('blackboards', $blackboards);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @return ResponseInterface
     */
    public function showAction(Blackboard $blackboard): ResponseInterface
    {
        $this->view->assign('blackboard', $blackboard);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return ResponseInterface
     */
    public function newAction(Person $person, Blackboard $blackboard = null): ResponseInterface
    {
        $this->view->assign('person', $person);
        $this->view->assign('blackboard', $blackboard);
        return $this->htmlResponse();
    }

    /**
     * initialize create action
     *
     * @param void
     */
    public function initializeCreateAction(): void
    {
        $this->arguments->getArgument('newBlackboard')
            ->getPropertyMappingConfiguration()->forProperty('*')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
    }

    /**
     * action create
     *
     * @param Blackboard $newBlackboard
     * @param Person $person
     */
    public function createAction(Blackboard $newBlackboard, Person $person)
    {
        $newBlackboard->addPerson($person);
        $this->addFlashMessage('Das neue Schwarze Brett wurde erstellt.', '', ContextualFeedbackSeverity::OK);
        $this->blackboardRepository->add($newBlackboard);
        return $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param Blackboard $blackboard
     * @return ResponseInterface
     */
    #[IgnoreValidation(['value' => 'blackboard'])]
    public function editAction(Blackboard $blackboard): ResponseInterface
    {
        $this->view->assign('blackboard', $blackboard);
        return $this->htmlResponse();
    }

    /**
     * initialize update action
     *
     * @param void
     */
    public function initializeUpdateAction(): void
    {
        $this->arguments->getArgument('blackboard')
            ->getPropertyMappingConfiguration()->forProperty('*')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
    }

    /**
     * action update
     *
     * @param Blackboard $blackboard
     */
    public function updateAction(Blackboard $blackboard)
    {
        $this->addFlashMessage('Die Änderungen wurden erfolgreich gespeichert.', '', ContextualFeedbackSeverity::OK);
        $this->blackboardRepository->update($blackboard);
        return $this->redirect('list');
    }



    /**
     * action delete
     *
     * @param Blackboard $blackboard
     */
    public function deleteAction(Blackboard $blackboard)
    {
        $this->addFlashMessage('Das Schwarze Brett wurde erfolgreich gelöscht.', '', ContextualFeedbackSeverity::OK);
        $this->blackboardRepository->remove($blackboard);
        return $this->redirect('list');
    }


    /**
     * action delete
     *
     * @param Blackboard $blackboard
     */
    public function deletegopersonAction(Blackboard $blackboard)
    {
        $redirectPerson = $blackboard->getPerson();
        $redirectPID = intval($this->settings['pageIDs']['personShowPid']);
        //DebugUtility::debug($redirectPID, 'PID');
        $this->addFlashMessage('Das Schwarze Brett wurde erfolgreich gelöscht.', '', ContextualFeedbackSeverity::OK);
        $this->blackboardRepository->remove($blackboard);
        return $this->redirect('show', 'Person', 'Leseohren', ['person' => $redirectPerson[0]], $redirectPID, null, 303);
    }
}
