<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use SKom\Leseohren\Domain\Repository\OrganizationRepository;
use SKom\Leseohren\Domain\Repository\CategoryRepository;
use SKom\Leseohren\Domain\Repository\PersonRepository;
use SKom\Leseohren\Domain\Model\Organization;
use SKom\Leseohren\Domain\Model\Person;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
/**
 * This file is part of the "Leseohren" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Sven Kalbhenn <sven@skom.de>, SKom
 */

/**
 * OrganizationController
 */
class OrganizationController extends ActionController
{
    /**
     * categoryRepository
     *
     * @var CategoryRepository
     */
    protected $categoryRepository = null;

    /**
     * organizationRepository
     *
     * @var OrganizationRepository
     */
    protected $organizationRepository = null;

    /**
     * personRepository
     *
     * @var PersonRepository
     */
    protected $personRepository = null;

    public function __construct(OrganizationRepository $organizationRepository, CategoryRepository $categoryRepository, PersonRepository $personRepository)
    {
        $this->organizationRepository = $organizationRepository;
        $this->categoryRepository = $categoryRepository;
        $this->personRepository = $personRepository;
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
        $organizations = $this->organizationRepository->findAll();
        $this->view->assign('organizations', $organizations);
        //DebugUtility::debug($organizations, 'organizations');
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @return ResponseInterface
     */
    public function showAction(Organization $organization): ResponseInterface
    {
        $vlpaten = $this->personRepository->searchCategoryUid([3]);
        $this->view->assign('organization', $organization);
        $this->view->assign('vlpaten', $vlpaten);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return ResponseInterface
     */
    public function newAction(): ResponseInterface
    {
        $categories = $this->categoryRepository->findBy(['parent' => '10']);
        $contactPersons = $this->personRepository->searchCategoryUid([6]);
        $this->view->assign('categories', $categories);
        $this->view->assign('contactPersons', $contactPersons);
        return $this->htmlResponse();
    }

    /**
     * initialize create action
     *
     * @param void
     */
    public function initializeCreateAction(): void
    {
        $this->arguments->getArgument('newOrganization')
            ->getPropertyMappingConfiguration()->forProperty('*')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
        $this->arguments->getArgument('newOrganization')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('vpLanguages', 'array');
    }

    /**
     * action create
     */
    public function createAction(Organization $newOrganization)
    {
        $this->addFlashMessage('Die neue Organisation wurde erfolgreich erstellt.', '', ContextualFeedbackSeverity::OK);
        $this->organizationRepository->add($newOrganization);
        return $this->redirect('list');
    }

    /**
     * action edit
     *
     * @return ResponseInterface
     */
    #[IgnoreValidation(['value' => 'organization'])]
    public function editAction(Organization $organization): ResponseInterface
    {
        // ToDo: Read Parent-ID from Settings
        $categories = $this->categoryRepository->findBy(['parent' => '10']);
        $contactPersons = $this->personRepository->searchCategoryUid([6]);
        //DebugUtility::debug($contactPersons, 'editAction');
        $this->view->assign('categories', $categories);
        $this->view->assign('contactPersons', $contactPersons);
        $this->view->assign('organization', $organization);
        return $this->htmlResponse();
    }

    /**
     * initialize update action
     *
     * @param void
     */
    public function initializeUpdateAction(): void
    {
        $this->arguments->getArgument('organization')
            ->getPropertyMappingConfiguration()->forProperty('*')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
        $this->arguments->getArgument('organization')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('vpLanguages', 'array');
    }

    /**
     * action update
     */
    public function updateAction(Organization $organization)
    {
        $this->addFlashMessage('Die Änderungen wurden erfolgreich gespeichert.', '', ContextualFeedbackSeverity::OK);
        $this->organizationRepository->update($organization);
        return $this->redirect('list');
    }

    /**
     * action delete
     */
    public function deleteAction(Organization $organization)
    {
        $this->addFlashMessage('Die Organisation wurde erfolgreich gelöscht.', '', ContextualFeedbackSeverity::OK);
        $this->organizationRepository->remove($organization);
        return $this->redirect('list');
    }

    /**
     * Zeigt das Modal zur Auswahl eines Vorlesepaten
     */
    public function addVlpateAction(Organization $organization): ResponseInterface
    {
        $vlpaten = $this->personRepository->searchCategoryUid([3]);
        //DebugUtility::debug($vlpaten, 'vlpaten');
        $this->view->assignMultiple([
            'organization' => $organization,
            'vlpaten' => $vlpaten
        ]);
        return $this->htmlResponse();
    }

    /**
     * Ordnet eine Person als vlpate zu
     */
    public function assignVlpateAction(Organization $organization, Person $person): ResponseInterface
    {
        if (!$organization->getVlpaten()->contains($person)) {
            $organization->addVlpaten($person);
            $this->organizationRepository->update($organization);
            // Cache für die betroffene Organisationenseite leeren (TYPO3 v13)
            $pid = intval($this->settings['pageIDs']['organizationShowPid']);
            $pageCache = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Cache\CacheManager::class)->getCache('pages');
            $pageCache->flushByTag('pageId_' . $pid);
            $this->addFlashMessage('Vorlesepate erfolgreich zugeordnet.');
        } else {
            $this->addFlashMessage('Diese Person ist bereits zugeordnet.', '', ContextualFeedbackSeverity::WARNING);
        }
        return $this->redirect('show', null, null, ['organization' => $organization]);
    }

    /**
     * Entfernt einen Vorlesepaten aus der Organisation
     */
    public function removeVlpateAction(Organization $organization, Person $person): ResponseInterface
    {
        if ($organization->getVlpaten()->contains($person)) {
            $organization->removeVlpaten($person);
            $this->organizationRepository->update($organization);
            // Cache für die betroffene Organisationenseite leeren (TYPO3 v13)
            $pid = intval($this->settings['pageIDs']['organizationShowPid']);
            $pageCache = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Cache\CacheManager::class)->getCache('pages');
            $pageCache->flushByTag('pageId_' . $pid);
            $this->addFlashMessage('Vorlesepate erfolgreich entfernt.');
        } else {
            $this->addFlashMessage('Diese Person ist nicht als Vorlesepate zugeordnet.', '', ContextualFeedbackSeverity::WARNING);
        }
        return $this->redirect('show', null, null, ['organization' => $organization]);
    }
}
