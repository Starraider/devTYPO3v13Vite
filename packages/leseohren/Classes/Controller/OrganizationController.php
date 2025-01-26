<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use SKom\Leseohren\Domain\Repository\OrganizationRepository;
use SKom\Leseohren\Domain\Repository\CategoryRepository;
use SKom\Leseohren\Domain\Model\Organization;

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

    public function __construct(OrganizationRepository $organizationRepository, CategoryRepository $categoryRepository)
    {
        $this->organizationRepository = $organizationRepository;
        $this->categoryRepository = $categoryRepository;
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
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @return ResponseInterface
     */
    public function showAction(Organization $organization): ResponseInterface
    {
        $this->view->assign('organization', $organization);
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
        $this->view->assign('categories', $categories);
        return $this->htmlResponse();
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
        $this->view->assign('categories', $categories);
        $this->view->assign('organization', $organization);
        return $this->htmlResponse();
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
}
