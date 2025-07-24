<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use SKom\Leseohren\Domain\Model\Registration;
use SKom\Leseohren\Domain\Model\Event;
use SKom\Leseohren\Domain\Model\Person;
use SKom\Leseohren\Domain\Repository\RegistrationRepository;
use SKom\Leseohren\Domain\Repository\EventRepository;
use SKom\Leseohren\Domain\Repository\PersonRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\DebugUtility;


use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Http\ForwardResponse;

/**
 * Controller for handling Registration operations
 */
class RegistrationController extends ActionController
{
    /**
     * eventRepository
     *
     * @var EventRepository
     */
    protected $eventRepository = null;

    public function __construct(
        protected readonly RegistrationRepository $registrationRepository,
        protected readonly PersonRepository $personRepository,
        EventRepository $eventRepository
    ) {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Creates a new registration
     *
     * @param Event|null $event
     * @param Person|null $person
     * @return ResponseInterface
     */
    public function newAction(?Event $event = null, ?Person $person = null): ResponseInterface
    {
        //$events = $this->eventRepository->findUpcomingEvents();
        //DebugUtility::debug($event, 'newAction');
        if($event){
            $this->view->assign('eventref', $event);
        }
        if($person){
            $this->view->assign('personref', $person);
        }
        $this->view->assignMultiple([
            'now' => date('Y-m-d\TH:i:sP', time()),
            'events' => $this->eventRepository->findUpcomingEvents(),
            'persons' => $this->personRepository->findAll(),
        ]);
        return $this->htmlResponse();
    }

    /**
     * Creates a registration
     *
     * @param Registration $newRegistration
     * @param Person|null $personref
     * @param Event|null $eventref
     * @throws IllegalObjectTypeException
     * @return ResponseInterface
     */
    public function createAction(Registration $newRegistration, ?Person $personref = null, ?Event $eventref = null): ResponseInterface
    {
        if($personref){
            $redirectPID = intval($this->settings['pageIDs']['personShowPid']);
            $newRegistration->setPerson($personref);
        }
        if($eventref){
            $redirectPID = intval($this->settings['pageIDs']['eventShowPid']);
            $newRegistration->setEvent($eventref);
        }
        //DebugUtility::debug($personref, 'createAction');
        //DebugUtility::debug($eventref, 'createAction');
        //DebugUtility::debug($newRegistration, 'createAction');
        $this->registrationRepository->add($newRegistration);
        $this->addFlashMessage(
            'Registration created successfully.',
            '',
            ContextualFeedbackSeverity::OK
        );
        if($personref){
            $pid = intval($this->settings['pageIDs']['personShowPid']);
            $pageCache = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Cache\CacheManager::class)->getCache('pages');
            $pageCache->flushByTag('pageId_' . $pid);
            return $this->redirect('show', 'Person', 'Leseohren', ['person' => $personref], $redirectPID, null, 303);
        }
        if($eventref){
            return $this->redirect('show', 'Event', 'Leseohren', ['event' => $eventref], $redirectPID, null, 303);
        }
        //return $this->htmlResponse();
    }

    /**
     * Deletes a registration
     *
     * @param Registration $registration
     * @param Event|null $event
     * @param Person|null $person
     * @return ResponseInterface
     * @throws IllegalObjectTypeException
     */
    public function deleteAction(Registration $registration, ?Event $event = null, ?Person $person = null): ResponseInterface
    {
        if($person){
            $redirectPID = intval($this->settings['pageIDs']['personShowPid']);
        }
        if($event){
            $redirectPID = intval($this->settings['pageIDs']['eventShowPid']);
        }
        try {
            $this->registrationRepository->remove($registration);
            $this->addFlashMessage(
                'Registration deleted successfully.',
                '',
                ContextualFeedbackSeverity::OK
            );
        } catch (\Exception $e) {
            $this->addFlashMessage(
                'Error deleting registration: ' . $e->getMessage(),
                '',
                ContextualFeedbackSeverity::ERROR
            );
        }
        if($person){
            $pid = intval($this->settings['pageIDs']['personShowPid']);
            $pageCache = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Cache\CacheManager::class)->getCache('pages');
            $pageCache->flushByTag('pageId_' . $pid);
            return $this->redirect('show', 'Person', 'Leseohren', ['person' => $person], $redirectPID, null, 303);
        }
        if($event){
            return $this->redirect('show', 'Event', 'Leseohren', ['event' => $event], $redirectPID, null, 303);
        }
        //return $this->redirect('list');
    }

    /**
     * Shows a list of registrations
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $registrations = $this->registrationRepository->findAll();
        $this->view->assign('registrations', $registrations);

        return $this->htmlResponse();
    }

    /**
     * Shows a single registration
     *
     * @param Registration $registration
     * @return ResponseInterface
     */
    public function showAction(Registration $registration): ResponseInterface
    {
        $this->view->assign('registration', $registration);

        return $this->htmlResponse();
    }

    /**
     * Shows edit form for a registration
     *
     * @param Registration $registration
     * @return ResponseInterface
     */
    public function editAction(Registration $registration): ResponseInterface
    {
        $this->view->assignMultiple([
            'registration' => $registration,
            'events' => $this->eventRepository->findAll(),
            'persons' => $this->personRepository->findAll(),
        ]);

        return $this->htmlResponse();
    }

    /**
     * Updates a registration
     *
     * @param Registration $registration
     * @return ResponseInterface
     * @throws IllegalObjectTypeException
     * @throws UnknownObjectException
     */
    public function updateAction(Registration $registration): ResponseInterface
    {
        try {
            $this->registrationRepository->update($registration);
            $this->addFlashMessage(
                'Registration updated successfully.',
                '',
                ContextualFeedbackSeverity::OK
            );
        } catch (\Exception $e) {
            $this->addFlashMessage(
                'Error updating registration: ' . $e->getMessage(),
                '',
                ContextualFeedbackSeverity::ERROR
            );
        }

        return $this->redirect('list');
    }


}
