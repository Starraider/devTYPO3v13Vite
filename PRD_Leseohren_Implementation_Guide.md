# Leseohren Implementation Guide - Product Requirements Document (PRD)

## 1. Implementation Overview

### 1.1 Development Approach
The Leseohren system follows TYPO3 best practices with a focus on:
- **Extbase Framework**: MVC architecture for clean separation of concerns
- **Domain-Driven Design**: Business logic encapsulated in domain models
- **Test-Driven Development**: Comprehensive testing strategy
- **Continuous Integration**: Automated testing and deployment

### 1.2 Development Environment Setup

#### 1.2.1 Prerequisites
```bash
# Required software
- PHP 8.2+
- Composer 2.0+
- Node.js 18+
- MySQL 8.0+ / MariaDB 10.5+
- Git
- TYPO3 v12+ (Latest LTS)
```

#### 1.2.2 Local Development Setup
```bash
# Clone repository
git clone <repository-url>
cd leseohrendb

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Build assets
npm run build

# Setup TYPO3
# Follow TYPO3 installation guide
```

## 2. Extension Development Standards

### 2.1 Code Standards

#### 2.1.1 PHP Coding Standards
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * Person Model
 *
 * Represents a volunteer in the Leseohren system.
 *
 * @package SKom\Leseohren\Domain\Model
 */
class Person extends AbstractEntity
{
    /**
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected $lastname = '';

    /**
     * Returns the lastname
     *
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Sets the lastname
     *
     * @param string $lastname
     * @return void
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }
}
```

#### 2.1.2 File Naming Conventions
- **Classes**: PascalCase (e.g., `PersonController.php`)
- **Files**: PascalCase for classes, lowercase for others
- **Namespaces**: Follow PSR-4 autoloading standards
- **Directories**: Match namespace structure

### 2.2 TYPO3 Extension Structure

#### 2.2.1 Directory Structure
```
leseohren/
├── Classes/
│   ├── Controller/
│   ├── Domain/
│   │   ├── Model/
│   │   └── Repository/
│   ├── Property/
│   ├── Updates/
│   └── ViewHelpers/
├── Configuration/
│   ├── Extbase/
│   ├── FlexForms/
│   ├── Sets/
│   ├── TCA/
│   └── TypoScript/
├── Resources/
│   ├── Private/
│   │   ├── Language/
│   │   ├── Layouts/
│   │   ├── Partials/
│   │   ├── Scss/
│   │   └── Templates/
│   └── Public/
├── Tests/
├── composer.json
├── ext_emconf.php
├── ext_localconf.php
└── ext_tables.php
```

## 3. Domain Model Implementation

### 3.1 Model Development

#### 3.1.1 Base Model Structure
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Abstract base model for Leseohren entities
 */
abstract class AbstractLeseohrenModel extends AbstractEntity
{
    /**
     * @var ObjectStorage<Category>
     */
    public $categories;

    /**
     * Initialize object storage properties
     */
    public function __construct()
    {
        $this->categories = new ObjectStorage();
        $this->initializeObject();
    }

    /**
     * Initialize object when reconstructed from database
     */
    public function initializeObject(): void
    {
        // Override in child classes
    }

    /**
     * Add a category
     */
    public function addCategory(Category $category): void
    {
        $this->categories->attach($category);
    }

    /**
     * Remove a category
     */
    public function removeCategory(Category $category): void
    {
        $this->categories->detach($category);
    }

    /**
     * Get all categories
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * Set categories
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }
}
```

#### 3.1.2 Person Model Implementation
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * Person Model
 */
class Person extends AbstractLeseohrenModel
{
    /**
     * Gender constants
     */
    public const GENDER_FEMALE = 0;
    public const GENDER_MALE = 1;
    public const GENDER_DIVERSE = 2;

    /**
     * Status constants
     */
    public const STATUS_ACTIVE = 0;
    public const STATUS_PAUSED = 1;
    public const STATUS_RETIRED = 2;

    /**
     * @var int
     */
    protected $gender = self::GENDER_FEMALE;

    /**
     * @var string
     */
    protected $firstname = '';

    /**
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected $lastname = '';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $job = '';

    /**
     * @var \DateTime|null
     */
    protected $birthday = null;

    // Contact information properties
    protected $street1 = '';
    protected $street2 = '';
    protected $zip = '';
    protected $city = '';
    protected $district = '';
    protected $phoneLandline = '';
    protected $phoneMobile = '';
    protected $email = '';
    protected $whatsapp = '';

    // Volunteer-specific properties
    protected $awareness = 0;
    protected $notes = '';
    protected $status = self::STATUS_ACTIVE;
    protected $statuschangeDate = null;
    protected $statusbeginDate = null;
    protected $statusendDate = null;
    protected $travelOptions = 0;
    protected $languages = [];
    protected $preferenceAgegroup = [];
    protected $preferenceOrganizationType = [];

    // Membership properties
    protected $membershipType = 0;
    protected $membershipFee = '';
    protected $paymentMethod = 0;
    protected $mandatsreferenz = '';
    protected $iban = '';
    protected $swift = '';
    protected $accountOwner = '';
    protected $bankname = '';
    protected $paypal = '';
    protected $memberorg = '';

    // Document properties
    protected $fileFuehrungszeugnis = null;
    protected $fuehrungszeugnisChecked = false;
    protected $fuehrungszeugnisDate = null;
    protected $fileMandat = null;
    protected $fileOthers = null;

    // Relationships
    public $donations;
    public $registrations;
    public $blackboards;
    public $organizations;

    /**
     * Initialize object storage properties
     */
    public function initializeObject(): void
    {
        $this->donations = $this->donations ?: new ObjectStorage();
        $this->registrations = $this->registrations ?: new ObjectStorage();
        $this->blackboards = $this->blackboards ?: new ObjectStorage();
        $this->organizations = $this->organizations ?: new ObjectStorage();
    }

    /**
     * Get full name
     */
    public function getFullname(): string
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }

    /**
     * Get age
     */
    public function getAge(): ?int
    {
        if (!$this->birthday) {
            return null;
        }

        $now = new \DateTime();
        $interval = $now->diff($this->birthday);
        return $interval->y;
    }

    /**
     * Check if person is active
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if criminal background check is expired
     */
    public function isFuehrungszeugnisExpired(): bool
    {
        if (!$this->fuehrungszeugnisDate) {
            return true;
        }

        $expiryDate = clone $this->fuehrungszeugnisDate;
        $expiryDate->add(new \DateInterval('P5Y')); // 5 years validity

        return $expiryDate < new \DateTime();
    }

    // Getters and setters for all properties...
}
```

### 3.2 Repository Implementation

#### 3.2.1 Base Repository
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Abstract base repository for Leseohren entities
 */
abstract class AbstractLeseohrenRepository extends Repository
{
    /**
     * Default ordering
     */
    protected $defaultOrderings = [
        'crdate' => QueryInterface::ORDER_DESCENDING
    ];

    /**
     * Find by category
     */
    public function findByCategory($category): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->contains('categories', $category)
        );
        return $query->execute();
    }

    /**
     * Find active records
     */
    public function findActive(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('hidden', 0)
        );
        return $query->execute();
    }

    /**
     * Find by date range
     */
    public function findByDateRange(\DateTime $start, \DateTime $end, string $dateField = 'crdate'): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->greaterThanOrEqual($dateField, $start),
                $query->lessThanOrEqual($dateField, $end)
            ])
        );
        return $query->execute();
    }
}
```

#### 3.2.2 Person Repository
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Person Repository
 */
class PersonRepository extends AbstractLeseohrenRepository
{
    /**
     * Find upcoming birthdays
     */
    public function upcomingBirthdays(int $days = 7): QueryResultInterface
    {
        $query = $this->createQuery();

        $startDate = new \DateTime();
        $endDate = clone $startDate;
        $endDate->add(new \DateInterval("P{$days}D"));

        $query->matching(
            $query->logicalAnd([
                $query->equals('hidden', 0),
                $query->equals('status', 0), // Active status
                $query->logicalAnd([
                    $query->greaterThanOrEqual('birthday', $startDate),
                    $query->lessThanOrEqual('birthday', $endDate)
                ])
            ])
        );

        $query->setOrderings([
            'birthday' => QueryInterface::ORDER_ASCENDING
        ]);

        return $query->execute();
    }

    /**
     * Find upcoming status changes
     */
    public function upcomingStatusChange(int $days = 7): QueryResultInterface
    {
        $query = $this->createQuery();

        $startDate = new \DateTime();
        $endDate = clone $startDate;
        $endDate->add(new \DateInterval("P{$days}D"));

        $query->matching(
            $query->logicalAnd([
                $query->equals('hidden', 0),
                $query->logicalAnd([
                    $query->greaterThanOrEqual('statuschangeDate', $startDate),
                    $query->lessThanOrEqual('statuschangeDate', $endDate)
                ])
            ])
        );

        $query->setOrderings([
            'statuschangeDate' => QueryInterface::ORDER_ASCENDING
        ]);

        return $query->execute();
    }

    /**
     * Find expired criminal background checks
     */
    public function expiredFuehrungszeugnis(int $days = 14): QueryResultInterface
    {
        $query = $this->createQuery();

        $expiryDate = new \DateTime();
        $expiryDate->add(new \DateInterval("P{$days}D"));

        $query->matching(
            $query->logicalAnd([
                $query->equals('hidden', 0),
                $query->equals('status', 0), // Active status
                $query->lessThanOrEqual('fuehrungszeugnisDate', $expiryDate)
            ])
        );

        $query->setOrderings([
            'fuehrungszeugnisDate' => QueryInterface::ORDER_ASCENDING
        ]);

        return $query->execute();
    }

    /**
     * Find by status
     */
    public function findByStatus(int $status): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('hidden', 0),
                $query->equals('status', $status)
            ])
        );
        return $query->execute();
    }
}
```

## 4. Controller Implementation

### 4.1 Base Controller
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;

/**
 * Abstract base controller for Leseohren
 */
abstract class AbstractLeseohrenController extends ActionController
{
    /**
     * Add flash message
     */
    protected function addFlashMessage(string $message, string $title = '', int $severity = ContextualFeedbackSeverity::OK): void
    {
        $this->addFlashMessage($message, $title, $severity);
    }

    /**
     * Redirect to list action
     */
    protected function redirectToList(): ResponseInterface
    {
        return $this->redirect('list');
    }

    /**
     * Redirect to show action
     */
    protected function redirectToShow($entity): ResponseInterface
    {
        return $this->redirect('show', null, null, ['entity' => $entity]);
    }

    /**
     * Handle validation errors
     */
    protected function handleValidationErrors(): void
    {
        if ($this->request->hasArgument('__trustedProperties')) {
            $this->addFlashMessage(
                'Please check your input and try again.',
                'Validation Error',
                ContextualFeedbackSeverity::ERROR
            );
        }
    }
}
```

### 4.2 Person Controller
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use SKom\Leseohren\Domain\Model\Person;
use SKom\Leseohren\Domain\Repository\PersonRepository;
use SKom\Leseohren\Domain\Repository\CategoryRepository;

/**
 * Person Controller
 */
class PersonController extends AbstractLeseohrenController
{
    protected PersonRepository $personRepository;
    protected CategoryRepository $categoryRepository;

    public function __construct(PersonRepository $personRepository, CategoryRepository $categoryRepository)
    {
        $this->personRepository = $personRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * List action
     */
    public function listAction(): ResponseInterface
    {
        $people = $this->personRepository->findAll();
        $this->view->assign('people', $people);
        return $this->htmlResponse();
    }

    /**
     * Show action
     */
    public function showAction(Person $person): ResponseInterface
    {
        $this->view->assign('person', $person);
        return $this->htmlResponse();
    }

    /**
     * New action
     */
    public function newAction(): ResponseInterface
    {
        $categories = $this->categoryRepository->findAll();
        $this->view->assign('categories', $categories);
        return $this->htmlResponse();
    }

    /**
     * Create action
     */
    public function createAction(Person $newPerson): ResponseInterface
    {
        try {
            $this->personRepository->add($newPerson);
            $this->addFlashMessage('Person created successfully.');
            return $this->redirectToShow($newPerson);
        } catch (\Exception $e) {
            $this->addFlashMessage('Error creating person: ' . $e->getMessage(), '', ContextualFeedbackSeverity::ERROR);
            return $this->redirect('new');
        }
    }

    /**
     * Edit action
     */
    public function editAction(Person $person): ResponseInterface
    {
        $categories = $this->categoryRepository->findAll();
        $this->view->assignMultiple([
            'person' => $person,
            'categories' => $categories
        ]);
        return $this->htmlResponse();
    }

    /**
     * Update action
     */
    #[IgnoreValidation(['argumentName' => 'person'])]
    public function updateAction(Person $person): ResponseInterface
    {
        try {
            $this->personRepository->update($person);
            $this->addFlashMessage('Person updated successfully.');
            return $this->redirectToShow($person);
        } catch (\Exception $e) {
            $this->addFlashMessage('Error updating person: ' . $e->getMessage(), '', ContextualFeedbackSeverity::ERROR);
            return $this->redirect('edit', null, null, ['person' => $person]);
        }
    }

    /**
     * Delete action
     */
    public function deleteAction(Person $person): ResponseInterface
    {
        try {
            $this->personRepository->remove($person);
            $this->addFlashMessage('Person deleted successfully.');
            return $this->redirectToList();
        } catch (\Exception $e) {
            $this->addFlashMessage('Error deleting person: ' . $e->getMessage(), '', ContextualFeedbackSeverity::ERROR);
            return $this->redirectToShow($person);
        }
    }
}
```

## 5. Frontend Implementation

### 5.1 Template Development

#### 5.1.1 Base Layout
```html
<!-- Resources/Private/Layouts/Default.html -->
<!DOCTYPE html>
<html lang="{site.language.locale}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{site.title} - {f:translate(key: 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:page.title')}</title>

    <!-- CSS -->
    <f:asset.css identifier="leseohren-styles" />

    <!-- JavaScript -->
    <f:asset.script identifier="leseohren-scripts" />
</head>
<body>
    <div class="leseohren-container">
        <!-- Header -->
        <header class="leseohren-header">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <a class="navbar-brand" href="{f:uri.page(pageUid: '1')}">
                        <f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:site.title" />
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{f:uri.page(pageUid: '2')}">
                                    <f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:nav.volunteers" />
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{f:uri.page(pageUid: '3')}">
                                    <f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:nav.organizations" />
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{f:uri.page(pageUid: '4')}">
                                    <f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:nav.events" />
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="leseohren-main">
            <div class="container">
                <!-- Flash Messages -->
                <f:if condition="{flashMessages}">
                    <div class="flash-messages">
                        <f:for each="{flashMessages}" as="flashMessage">
                            <div class="alert alert-{flashMessage.severity} alert-dismissible fade show">
                                <strong>{flashMessage.title}</strong> {flashMessage.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </f:for>
                    </div>
                </f:if>

                <!-- Page Content -->
                <f:render section="Main" />
            </div>
        </main>

        <!-- Footer -->
        <footer class="leseohren-footer">
            <div class="container">
                <p>&copy; {f:format.date(format: 'Y')} <f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:site.copyright" /></p>
            </div>
        </footer>
    </div>
</body>
</html>
```

#### 5.1.2 Person List Template
```html
<!-- Resources/Private/Templates/Person/List.html -->
<f:layout name="Default" />

<f:section name="Main">
    <div class="person-list">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:person.list.title" /></h1>
                    <a href="{f:uri.action(action: 'new')}" class="btn btn-primary">
                        <f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:person.new" />
                    </a>
                </div>

                <!-- Search and Filters -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchInput"
                                           placeholder="{f:translate key: 'LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:search.placeholder'}">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="statusFilter">
                                    <option value=""><f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:filter.all.status" /></option>
                                    <option value="0"><f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:status.active" /></option>
                                    <option value="1"><f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:status.paused" /></option>
                                    <option value="2"><f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:status.retired" /></option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="categoryFilter">
                                    <option value=""><f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:filter.all.categories" /></option>
                                    <f:for each="{categories}" as="category">
                                        <option value="{category.uid}">{category.title}</option>
                                    </f:for>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="personTable">
                            <thead>
                                <tr>
                                    <th><f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:person.name" /></th>
                                    <th><f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:person.status" /></th>
                                    <th><f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:person.email" /></th>
                                    <th><f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:person.phone" /></th>
                                    <th><f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:person.categories" /></th>
                                    <th><f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:actions" /></th>
                                </tr>
                            </thead>
                            <tbody>
                                <f:for each="{people}" as="person">
                                    <tr>
                                        <td>
                                            <a href="{f:uri.action(action: 'show', arguments: {person: person})}">
                                                {person.fullname}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-{person.status == 0 ? 'success' : (person.status == 1 ? 'warning' : 'secondary')}">
                                                <f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:status.{person.status}" />
                                            </span>
                                        </td>
                                        <td>{person.email}</td>
                                        <td>{person.phoneMobile}</td>
                                        <td>
                                            <f:for each="{person.categories}" as="category">
                                                <span class="badge bg-info me-1">{category.title}</span>
                                            </f:for>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{f:uri.action(action: 'show', arguments: {person: person})}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{f:uri.action(action: 'edit', arguments: {person: person})}"
                                                   class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-person-id="{person.uid}" data-person-name="{person.fullname}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </f:for>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <f:render partial="Person/DeleteModal" />
    </div>
</f:section>
```

### 5.2 SCSS Implementation

#### 5.2.1 Main SCSS File
```scss
// Resources/Private/Scss/Main.entry.scss

// Abstracts
@import 'abstracts/variables';
@import 'abstracts/css-vars';
@import 'abstracts/bem-mixin';

// Base
@import 'base/typography';

// Components
@import 'components/buttons';
@import 'components/modals';

// Layout
@import 'layout/container';

// Plugins
@import 'plugins/plugins';
@import 'plugins/leseohren/leseohren-personen';
@import 'plugins/leseohren/leseohren-events';
@import 'plugins/leseohren/leseohren-blackboards';

// Leseohren specific styles
.leseohren {
    &-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    &-header {
        flex-shrink: 0;
    }

    &-main {
        flex: 1;
        padding: 2rem 0;
    }

    &-footer {
        flex-shrink: 0;
        background-color: $gray-100;
        padding: 1rem 0;
        margin-top: auto;
    }
}

// Data table styles
.data-table {
    .table {
        th {
            border-top: none;
            font-weight: 600;
            color: $gray-700;
        }

        td {
            vertical-align: middle;
        }
    }
}

// Status badges
.status-badge {
    &.status-0 {
        background-color: $success;
    }

    &.status-1 {
        background-color: $warning;
    }

    &.status-2 {
        background-color: $secondary;
    }
}

// Form styles
.form-group {
    margin-bottom: 1rem;

    label {
        font-weight: 500;
        color: $gray-700;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 0.375rem;
        border: 1px solid $gray-300;

        &:focus {
            border-color: $primary;
            box-shadow: 0 0 0 0.2rem rgba($primary, 0.25);
        }
    }
}

// Card styles
.card {
    border: 1px solid $gray-200;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);

    .card-header {
        background-color: $gray-50;
        border-bottom: 1px solid $gray-200;
        font-weight: 600;
    }
}

// Button styles
.btn {
    border-radius: 0.375rem;
    font-weight: 500;
    padding: 0.5rem 1rem;

    &-primary {
        background-color: $primary;
        border-color: $primary;

        &:hover {
            background-color: darken($primary, 10%);
            border-color: darken($primary, 10%);
        }
    }

    &-secondary {
        background-color: $secondary;
        border-color: $secondary;

        &:hover {
            background-color: darken($secondary, 10%);
            border-color: darken($secondary, 10%);
        }
    }
}

// Responsive design
@media (max-width: 768px) {
    .leseohren-main {
        padding: 1rem 0;
    }

    .data-table {
        .table-responsive {
            font-size: 0.875rem;
        }
    }

    .btn-group {
        .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    }
}
```

### 5.3 JavaScript Implementation

#### 5.3.1 Main JavaScript File
```javascript
// Resources/Private/JavaScript/ext.leseohren.entry.js

import { DataTable } from './DataTables.entry.js';
import { Datepicker } from './Datepicker.entry.js';

class LeseohrenApp {
    constructor() {
        this.init();
    }

    init() {
        this.initDataTables();
        this.initDatepickers();
        this.initEventListeners();
        this.initModals();
    }

    initDataTables() {
        const tables = document.querySelectorAll('.data-table');
        tables.forEach(table => {
            new DataTable(table, {
                responsive: true,
                language: {
                    url: '/typo3conf/ext/leseohren/Resources/Public/JavaScript/datatables-de.json'
                },
                pageLength: 25,
                order: [[0, 'asc']]
            });
        });
    }

    initDatepickers() {
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            new Datepicker(input, {
                format: 'dd.mm.yyyy',
                language: 'de',
                autoclose: true,
                todayHighlight: true
            });
        });
    }

    initEventListeners() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', this.handleSearch.bind(this));
        }

        // Filter functionality
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) {
            statusFilter.addEventListener('change', this.handleFilter.bind(this));
        }

        const categoryFilter = document.getElementById('categoryFilter');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', this.handleFilter.bind(this));
        }
    }

    initModals() {
        // Delete confirmation modal
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', this.handleDeleteModal.bind(this));
        }
    }

    handleSearch(event) {
        const searchTerm = event.target.value.toLowerCase();
        const table = document.getElementById('personTable');

        if (table) {
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        }
    }

    handleFilter() {
        const statusFilter = document.getElementById('statusFilter');
        const categoryFilter = document.getElementById('categoryFilter');

        if (statusFilter && categoryFilter) {
            // Implement filter logic
            console.log('Filter changed:', {
                status: statusFilter.value,
                category: categoryFilter.value
            });
        }
    }

    handleDeleteModal(event) {
        const button = event.relatedTarget;
        const personId = button.getAttribute('data-person-id');
        const personName = button.getAttribute('data-person-name');

        const modal = event.target;
        const confirmButton = modal.querySelector('.btn-danger');
        const personNameElement = modal.querySelector('.person-name');

        if (confirmButton && personNameElement) {
            personNameElement.textContent = personName;
            confirmButton.href = `/index.php?type=123&tx_leseohren_person[action]=delete&tx_leseohren_person[person]=${personId}`;
        }
    }
}

// Initialize app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new LeseohrenApp();
});

export default LeseohrenApp;
```

## 6. Testing Implementation

### 6.1 Unit Testing

#### 6.1.1 Person Model Test
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use SKom\Leseohren\Domain\Model\Person;

/**
 * Test case for Person model
 */
class PersonTest extends TestCase
{
    protected Person $person;

    protected function setUp(): void
    {
        $this->person = new Person();
    }

    /**
     * @test
     */
    public function canSetAndGetLastname(): void
    {
        $lastname = 'Doe';
        $this->person->setLastname($lastname);

        $this->assertEquals($lastname, $this->person->getLastname());
    }
