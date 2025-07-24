<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use SKom\Leseohren\Domain\Repository\PresentRepository;
use SKom\Leseohren\Domain\Repository\GiftRepository;
use SKom\Leseohren\Domain\Model\Present;
use SKom\Leseohren\Domain\Model\Person;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Cache\CacheManager;

/**
 * This file is part of the "Leseohren" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Sven Kalbhenn <sven@skom.de>, SKom
 */

/**
 * PresentController
 */
class PresentController extends ActionController
{
    /**
     * presentRepository
     *
     * @var PresentRepository
     */
    protected $presentRepository = null;

    /**
     * giftRepository
     *
     * @var GiftRepository
     */
    protected $giftRepository = null;

    public function __construct(PresentRepository $presentRepository, GiftRepository $giftRepository)
    {
        $this->presentRepository = $presentRepository;
        $this->giftRepository = $giftRepository;
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
        $presents = $this->presentRepository->findAll();
        //DebugUtility::debug($presents, 'meineVariable');
        $this->view->assign('presents', $presents);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @return ResponseInterface
     */
    public function showAction(Present $present): ResponseInterface
    {
        $this->view->assign('present', $present);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return ResponseInterface
     */
    public function newAction(Person $person): ResponseInterface
    {
        $this->view->assign('person', $person);
        $gifts = $this->giftRepository->findAll();
        $this->view->assign('gifts', $gifts);
        return $this->htmlResponse();
    }

    /**
     * initialize create action
     *
     * @param void
     */
    public function initializeCreateAction(): void
    {
        $this->arguments->getArgument('newPresent')
            ->getPropertyMappingConfiguration()->forProperty('*')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
    }


    /**
     * action create
     */
    public function createAction(Present $newPresent, Person $person)
    {
        if($person){
            $redirectPID = intval($this->settings['pageIDs']['personShowPid']);
        }
        $newPresent->addPerson($person);
        $this->addFlashMessage('Die neue Schenkung wurde erfolgreich gespeichert.', '', ContextualFeedbackSeverity::OK);
        $this->presentRepository->add($newPresent);
        if($person){
            // Cache für die betroffene Personenseite leeren (TYPO3 v13)
            $pid = intval($this->settings['pageIDs']['personShowPid']);
            $pageCache = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Cache\CacheManager::class)->getCache('pages');
            $pageCache->flushByTag('pageId_' . $pid);
            return $this->redirect('show', 'Person', 'Leseohren', ['person' => $person], $redirectPID, null, 303);
        } else {
            return $this->redirect('list');
        }
    }

    /**
     * action edit
     *
     * @return ResponseInterface
     */
    #[IgnoreValidation(['value' => 'present'])]
    public function editAction(Present $present): ResponseInterface
    {
        $this->view->assign('present', $present);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     */
    public function updateAction(Present $present)
    {
        $this->addFlashMessage('Die Änderungen wurden erfolgreich gespeichert.', '', ContextualFeedbackSeverity::OK);
        $this->presentRepository->update($present);
        return $this->redirect('list');
    }

    /**
     * action delete
     *
     */
    // public function deleteAction(Present $present)
    // {
    //     $this->addFlashMessage('Die Schenkung wurde erfolgreich gelöscht.', '', ContextualFeedbackSeverity::OK);
    //     $this->presentRepository->remove($present);
    //     return $this->redirect('list');
    // }

    /**
     * action delete
     *
     * @param Present $present
     * @param Person $person
     */
    public function deleteAction(Present $present, Person $person = null)
    {
        $redirectPID = intval($this->settings['pageIDs']['personShowPid']);

        $this->addFlashMessage('Die Schenkung wurde erfolgreich gelöscht.', '', ContextualFeedbackSeverity::OK);
        $this->presentRepository->remove($present);
        if($person) {
            return $this->redirect('show', 'Person', 'Leseohren', ['person' => $person], $redirectPID, null, 303);
        }else{
            return $this->redirect('list');
        }
    }
}
