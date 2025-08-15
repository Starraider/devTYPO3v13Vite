<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use SKom\Leseohren\Domain\Repository\PersonRepository;
use SKom\Leseohren\Domain\Repository\CategoryRepository;
use SKom\Leseohren\Domain\Model\Person;
//use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
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
 * PersonController
 */
class PersonController extends ActionController
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
        $people = $this->personRepository->findAll();
        //DebugUtility::debug($people, 'PersonController');
        $this->view->assign('people', $people);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @return ResponseInterface
     */
    public function showAction(Person $person): ResponseInterface
    {
        //DebugUtility::debug($person, 'Person');
        // Hinweis: Das Setzen eines individuellen Cache-Tags ist in dieser TYPO3-Version nicht direkt möglich.
        $this->view->assign('person', $person);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return ResponseInterface
     */
    public function newAction(): ResponseInterface
    {
        $categories = $this->categoryRepository->findBy(['parent' => '1']);
        $this->view->assign('categories', $categories);
        return $this->htmlResponse();
    }

    /**
     * initialize create action
     *
     * @param void
     */
    public function initializeCreateAction(): void
    {
        $this->arguments->getArgument('newPerson')
            ->getPropertyMappingConfiguration()->forProperty('*')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
        $this->arguments->getArgument('newPerson')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('languages', 'array');
        $this->arguments->getArgument('newPerson')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('preferenceAgegroup', 'array');
        $this->arguments->getArgument('newPerson')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('preferenceOrganizationType', 'array');
        //$this->setTypeConverterConfigurationForFileUpload('newPerson');
    }


    /**
     * action create
     */
    public function createAction(Person $newPerson)
    {
        $this->personRepository->add($newPerson);
        $this->addFlashMessage('Die neue Person wurde erfolgreich gespeichert!', '', ContextualFeedbackSeverity::OK);
        return $this->redirect('list');
    }

    /**
     * action edit
     *
     * @return ResponseInterface
     */
    #[IgnoreValidation(['value' => 'person'])]
    public function editAction(Person $person): ResponseInterface
    {
        // ToDo: Read Parent-ID from Settings
        $categories = $this->categoryRepository->findBy(['parent' => '1']);
        $this->view->assign('categories', $categories);
        $this->view->assign('person', $person);
        return $this->htmlResponse();
    }

    /**
     * initialize update action
     *
     * @param void
     */
    public function initializeUpdateAction(): void
    {
        $this->arguments->getArgument('person')
            ->getPropertyMappingConfiguration()->forProperty('*')->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
        $this->arguments->getArgument('person')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('languages', 'array');
        $this->arguments->getArgument('person')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('preferenceAgegroup', 'array');
        $this->arguments->getArgument('person')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('preferenceOrganizationType', 'array');
        //$this->setTypeConverterConfigurationForFileUpload('person');
    }

    /**
     * action update
     */
    public function updateAction(Person $person)
    {
        $this->personRepository->update($person);
        $this->addFlashMessage('Die Änderungen wurden erfolgreich gespeichert!', '', ContextualFeedbackSeverity::OK);
        return $this->redirect('list');
    }

    /**
     * action delete
     */
    public function deleteAction(Person $person)
    {
        $this->personRepository->remove($person);
        $this->addFlashMessage('Die Person wurde erfolgreich aus der Datenbank entfernt!', '', ContextualFeedbackSeverity::OK);
        return $this->redirect('list');
    }

    /**
     * action processFileUpload
     *
     * @param Person $person
     * @return ResponseInterface
     */
    public function processFileUploadAction(Person $person): ResponseInterface
    {
        try {
            // TYPO3 v13 handles file uploads automatically via FileUpload attributes
            // Just update the person and show success message
            $this->personRepository->update($person);

            $this->addFlashMessage(
                'Die Datei wurde erfolgreich hochgeladen!',
                'Erfolg',
                ContextualFeedbackSeverity::OK
            );

        } catch (\Exception $e) {
            $this->addFlashMessage(
                'Fehler beim Hochladen der Datei: ' . $e->getMessage(),
                'Fehler',
                ContextualFeedbackSeverity::ERROR
            );
        }

        return $this->redirect('show', null, null, ['person' => $person]);
    }

    /**
     * action deleteFile
     *
     * @param Person $person
     * @return ResponseInterface
     */
    public function deleteFileAction(Person $person): ResponseInterface
    {
        try {
            // Get the file reference
            $fileReference = $person->getFileFuehrungszeugnis();

            if ($fileReference) {
                // Get the actual file from the file reference
                $file = $fileReference->getOriginalResource();

                if ($file) {
                    // Method 1: Try to delete using storage
                    try {
                        $storage = $file->getStorage();
                        $storage->deleteFile($file);
                    } catch (\Exception $storageException) {
                        // Method 2: Try using ResourceFactory
                        try {
                            $resourceFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
                            $fileObject = $resourceFactory->getFileObject($file->getUid());
                            $fileObject->getStorage()->deleteFile($fileObject);
                        } catch (\Exception $factoryException) {
                            // Log the error but continue with database cleanup
                            DebugUtility::debug('Could not delete file from storage: ' . $factoryException->getMessage());
                        }
                    }

                    // Delete the file reference from the database
                    $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
                    $persistenceManager->remove($fileReference);

                    // Update the person
                    $this->personRepository->update($person);

                    // Persist all changes
                    $persistenceManager->persistAll();

                    $this->addFlashMessage(
                        'Das Führungszeugnis wurde erfolgreich gelöscht!',
                        'Erfolg',
                        ContextualFeedbackSeverity::OK
                    );
                } else {
                    $this->addFlashMessage(
                        'Datei konnte nicht gefunden werden.',
                        'Warnung',
                        ContextualFeedbackSeverity::WARNING
                    );
                }
            } else {
                $this->addFlashMessage(
                    'Keine Datei zum Löschen gefunden.',
                    'Warnung',
                    ContextualFeedbackSeverity::WARNING
                );
            }

        } catch (\Exception $e) {
            $this->addFlashMessage(
                'Fehler beim Löschen der Datei: ' . $e->getMessage(),
                'Fehler',
                ContextualFeedbackSeverity::ERROR
            );
        }

        return $this->redirect('show', null, null, ['person' => $person]);
    }

    /**
     * action deleteMandat
     *
     * @param Person $person
     * @return ResponseInterface
     */
    public function deleteMandatAction(Person $person): ResponseInterface
    {
        try {
            $fileReference = $person->getFileMandat();

            if ($fileReference) {
                $file = $fileReference->getOriginalResource();

                if ($file) {
                    // Try to delete using storage first
                    try {
                        $storage = $file->getStorage();
                        $storage->deleteFile($file);
                    } catch (\Exception $storageException) {
                        // Fallback: Use ResourceFactory
                        try {
                            $resourceFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
                            $fileObject = $resourceFactory->getFileObject($file->getUid());
                            $fileObject->getStorage()->deleteFile($fileObject);
                        } catch (\Exception $factoryException) {
                            // Log the error but continue with database cleanup
                            DebugUtility::debug('Could not delete Mandat file from storage: ' . $factoryException->getMessage());
                        }
                    }

                    // Remove the file reference from DB
                    $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
                    $persistenceManager->remove($fileReference);

                    // Update and persist
                    $this->personRepository->update($person);
                    $persistenceManager->persistAll();

                    $this->addFlashMessage(
                        'Das Mandat wurde erfolgreich gelöscht!',
                        'Erfolg',
                        ContextualFeedbackSeverity::OK
                    );
                } else {
                    $this->addFlashMessage(
                        'Datei konnte nicht gefunden werden.',
                        'Warnung',
                        ContextualFeedbackSeverity::WARNING
                    );
                }
            } else {
                $this->addFlashMessage(
                    'Keine Datei zum Löschen gefunden.',
                    'Warnung',
                    ContextualFeedbackSeverity::WARNING
                );
            }

        } catch (\Exception $e) {
            $this->addFlashMessage(
                'Fehler beim Löschen der Datei: ' . $e->getMessage(),
                'Fehler',
                ContextualFeedbackSeverity::ERROR
            );
        }

        return $this->redirect('show', null, null, ['person' => $person]);
    }

    /**
     * action deleteOtherFile
     *
     * @param Person $person
     * @param int $fileUid The UID of the file reference to delete
     * @return ResponseInterface
     */
    public function deleteOtherFileAction(Person $person, int $fileUid): ResponseInterface
    {
        try {
            $fileReference = null;

            // Find the specific file reference by UID
            foreach ($person->getFileOthers() as $file) {
                if ($file->getUid() === $fileUid) {
                    $fileReference = $file;
                    break;
                }
            }

            if ($fileReference) {
                $file = $fileReference->getOriginalResource();

                if ($file) {
                    // Try to delete using storage first
                    try {
                        $storage = $file->getStorage();
                        $storage->deleteFile($file);
                    } catch (\Exception $storageException) {
                        // Fallback: Use ResourceFactory
                        try {
                            $resourceFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
                            $fileObject = $resourceFactory->getFileObject($file->getUid());
                            $fileObject->getStorage()->deleteFile($fileObject);
                        } catch (\Exception $factoryException) {
                            // Log the error but continue with database cleanup
                            DebugUtility::debug('Could not delete other file from storage: ' . $factoryException->getMessage());
                        }
                    }

                    // Remove the file reference from ObjectStorage
                    $person->removeFileOther($fileReference);

                    // Remove the file reference from DB
                    $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
                    $persistenceManager->remove($fileReference);

                    // Update and persist
                    $this->personRepository->update($person);
                    $persistenceManager->persistAll();

                    $this->addFlashMessage(
                        'Die Datei wurde erfolgreich gelöscht!',
                        'Erfolg',
                        ContextualFeedbackSeverity::OK
                    );
                } else {
                    $this->addFlashMessage(
                        'Datei konnte nicht gefunden werden.',
                        'Warnung',
                        ContextualFeedbackSeverity::WARNING
                    );
                }
            } else {
                $this->addFlashMessage(
                    'Datei zum Löschen nicht gefunden.',
                    'Warnung',
                    ContextualFeedbackSeverity::WARNING
                );
            }

        } catch (\Exception $e) {
            $this->addFlashMessage(
                'Fehler beim Löschen der Datei: ' . $e->getMessage(),
                'Fehler',
                ContextualFeedbackSeverity::ERROR
            );
        }

        return $this->redirect('show', null, null, ['person' => $person]);
    }

    /**
     * initialize updateFuehrungszeugnis action
     */
    public function initializeUpdateFuehrungszeugnisAction(): void
    {
        if ($this->arguments->hasArgument('person')) {
            $this->arguments->getArgument('person')
                ->getPropertyMappingConfiguration()
                ->forProperty('fuehrungszeugnisDate')
                ->setTypeConverterOption(
                    'TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
                    \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                    'd.m.Y'
                );
        }
    }

    /**
     * action updateFuehrungszeugnis
     */
    public function updateFuehrungszeugnisAction(Person $person)
    {
        // Work around setter casing inconsistency for fuehrungszeugnisChecked
        $args = $this->request->hasArgument('person') ? (array)$this->request->getArgument('person') : [];
        if (array_key_exists('fuehrungszeugnisChecked', $args)) {
            // Checkbox: presence means true ("1"), absence means false
            $person->setFuehrungszeugnischecked((bool)$args['fuehrungszeugnisChecked']);
        } else {
            $person->setFuehrungszeugnischecked(false);
        }

        // Ensure date is properly set if mapper didn't convert
        if (isset($args['fuehrungszeugnisDate']) && is_string($args['fuehrungszeugnisDate']) && trim($args['fuehrungszeugnisDate']) !== '') {
            $date = \DateTime::createFromFormat('d.m.Y', $args['fuehrungszeugnisDate']);
            if ($date instanceof \DateTime) {
                $person->setFuehrungszeugnisDate($date);
            }
        }

        $this->personRepository->update($person);
        $this->addFlashMessage('Führungszeugnis-Daten wurden aktualisiert.', '', ContextualFeedbackSeverity::OK);
        return $this->redirect('show', null, null, ['person' => $person]);
    }

}
