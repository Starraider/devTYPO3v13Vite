# TYPO3 Best Practices for Leseohren

## Extension Development

### Extension Structure
Follow TYPO3 extension conventions:
```
leseohren/
├── Classes/
│   ├── Controller/           # MVC Controllers
│   ├── Domain/
│   │   ├── Model/           # Domain models
│   │   └── Repository/      # Data repositories
│   ├── Property/
│   │   └── TypeConverter/   # Custom type converters
│   ├── Updates/             # Upgrade wizards
│   └── ViewHelpers/         # Custom Fluid ViewHelpers
├── Configuration/
│   ├── Extbase/
│   │   └── Persistence/     # Persistence configuration
│   ├── FlexForms/           # Plugin configuration
│   ├── Sets/                # Configuration sets
│   ├── TCA/                 # Table configuration
│   └── TypoScript/          # TypoScript configuration
├── Resources/
│   ├── Private/
│   │   ├── Language/        # Translation files
│   │   ├── Layouts/         # Fluid layouts
│   │   ├── Partials/        # Fluid partials
│   │   ├── Templates/       # Fluid templates
│   │   └── Scss/           # SCSS source files
│   └── Public/
│       ├── Css/            # Compiled CSS
│       ├── Icons/          # Extension icons
│       └── JavaScript/     # JavaScript files
└── Tests/                  # Unit and functional tests
```

### Dependency Injection
Use constructor injection in controllers:
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use SKom\Leseohren\Domain\Repository\PersonRepository;

class PersonController extends ActionController
{
    protected PersonRepository $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }
}
```

### Services Configuration
Configure services in `Configuration/Services.yaml`:
```yaml
services:
  _defaults:
    autowire: true
    autoconfigure: true
    public: false

  SKom\Leseohren\:
    resource: '../Classes/*'
    exclude: '../Classes/Domain/Model/*'
```

## TCA Configuration

### Model TCA Structure
```php
<?php
// Configuration/TCA/tx_leseohren_domain_model_person.php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person',
        'label' => 'lastname',
        'label_alt' => 'firstname',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'firstname,lastname,email,phone_mobile',
        'iconfile' => 'EXT:leseohren/Resources/Public/Icons/tx_leseohren_domain_model_person.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;personal,
                    --palette--;;contact,
                --div--;LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tabs.volunteer,
                    --palette--;;volunteer_status,
                    --palette--;;preferences,
                --div--;LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tabs.documents,
                    --palette--;;documents,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;hidden,
                    --palette--;;access,
            '
        ],
    ],
    'palettes' => [
        'personal' => [
            'showitem' => 'gender, title, firstname, lastname, birthday'
        ],
        'contact' => [
            'showitem' => 'email, phone_mobile, phone_landline, --linebreak--, street1, street2, --linebreak--, zip, city, district'
        ],
        'volunteer_status' => [
            'showitem' => 'status, statuschange_date, --linebreak--, statusbegin_date, statusend_date'
        ],
        'documents' => [
            'showitem' => 'file_fuehrungszeugnis, fuehrungszeugnis_date, fuehrungszeugnis_checked, --linebreak--, file_mandat, file_others'
        ],
    ],
    'columns' => [
        'firstname' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.firstname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        // ... more fields
    ],
];
```

### File References
Use FAL for file handling:
```php
'file_fuehrungszeugnis' => [
    'exclude' => true,
    'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.file_fuehrungszeugnis',
    'config' => [
        'type' => 'file',
        'allowed' => 'common-image-types,pdf',
        'maxitems' => 1,
        'appearance' => [
            'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
        ],
    ],
],
```

## Extbase Best Practices

### Repository Patterns
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class PersonRepository extends Repository
{
    protected $defaultOrderings = [
        'lastname' => QueryInterface::ORDER_ASCENDING,
        'firstname' => QueryInterface::ORDER_ASCENDING
    ];

    public function findByStatus(int $status): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('status', $status)
        );
        return $query->execute();
    }

    public function findUpcomingBirthdays(int $days = 7): QueryResultInterface
    {
        $query = $this->createQuery();
        
        // Complex query logic here
        $startDate = new \DateTime();
        $endDate = clone $startDate;
        $endDate->add(new \DateInterval("P{$days}D"));

        $query->matching(
            $query->logicalAnd([
                $query->equals('hidden', 0),
                $query->logicalAnd([
                    $query->greaterThanOrEqual('birthday', $startDate),
                    $query->lessThanOrEqual('birthday', $endDate)
                ])
            ])
        );

        return $query->execute();
    }
}
```

### Model Validation
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;

class Person extends AbstractEntity
{
    #[Validate(['validator' => 'NotEmpty'])]
    protected $lastname = '';

    #[Validate(['validator' => 'EmailAddress'])]
    protected $email = '';

    #[Validate(['validator' => 'DateTime'])]
    protected $birthday = null;
}
```

## TypoScript Configuration

### Plugin Configuration
```typoscript
# Configuration/TypoScript/setup.typoscript

plugin.tx_leseohren {
    view {
        templateRootPaths {
            0 = EXT:leseohren/Resources/Private/Templates/
            1 = {$plugin.tx_leseohren.view.templateRootPath}
        }
        partialRootPaths {
            0 = EXT:leseohren/Resources/Private/Partials/
            1 = {$plugin.tx_leseohren.view.partialRootPath}
        }
        layoutRootPaths {
            0 = EXT:leseohren/Resources/Private/Layouts/
            1 = {$plugin.tx_leseohren.view.layoutRootPath}
        }
    }

    persistence {
        storagePid = {$plugin.tx_leseohren.persistence.storagePid}
    }

    features {
        skipDefaultArguments = 1
        ignoreAllEnableFieldsInBe = 0
    }

    mvc {
        callDefaultActionIfActionCantBeResolved = 1
    }
}
```

### Constants Configuration
```typoscript
# Configuration/TypoScript/constants.typoscript

plugin.tx_leseohren {
    view {
        # cat=plugin.tx_leseohren/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:leseohren/Resources/Private/Templates/
        # cat=plugin.tx_leseohren/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:leseohren/Resources/Private/Partials/
        # cat=plugin.tx_leseohren/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:leseohren/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_leseohren//a; type=string; label=Default storage PID
        storagePid =
    }
}
```

## Fluid Template Best Practices

### ViewHelper Usage
```html
<!-- Use proper ViewHelper syntax -->
<f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:person.name" />

<!-- Format dates properly -->
<f:format.date format="d.m.Y">{person.birthday}</f:format.date>

<!-- Handle empty values -->
<f:if condition="{person.email}">
    <a href="mailto:{person.email}">{person.email}</a>
</f:if>

<!-- Use proper form ViewHelpers -->
<f:form action="create" object="{newPerson}">
    <f:form.textfield property="firstname" class="form-control" />
    <f:form.submit value="Save" class="btn btn-primary" />
</f:form>
```

### Partial Templates
```html
<!-- Resources/Private/Partials/Person/ContactInfo.html -->
<div class="contact-info">
    <f:if condition="{person.email}">
        <div class="contact-item">
            <strong>Email:</strong>
            <a href="mailto:{person.email}">{person.email}</a>
        </div>
    </f:if>
    
    <f:if condition="{person.phoneMobile}">
        <div class="contact-item">
            <strong>Mobile:</strong>
            <a href="tel:{person.phoneMobile}">{person.phoneMobile}</a>
        </div>
    </f:if>
</div>
```

## Security Best Practices

### Input Validation
- Always validate input server-side
- Use TYPO3 validation framework
- Sanitize output in templates
- Implement proper CSRF protection

### Access Control
```php
// In controller actions
if (!$this->request->hasArgument('person') || !$person instanceof Person) {
    throw new \TYPO3\CMS\Core\Error\Http\PageNotFoundException();
}
```

### File Upload Security
```php
// TCA configuration for secure file uploads
'config' => [
    'type' => 'file',
    'allowed' => 'pdf,jpg,jpeg,png',
    'maxitems' => 1,
    'max_size' => 5000, // 5MB
    'appearance' => [
        'createNewRelationLinkTitle' => 'Add file'
    ],
],
```

## Performance Optimization

### Caching
```php
// Use TYPO3 caching framework
$cache = GeneralUtility::makeInstance(CacheManager::class)->getCache('leseohren_cache');
$cacheKey = 'person_' . $person->getUid();

if ($cache->has($cacheKey)) {
    $data = $cache->get($cacheKey);
} else {
    $data = $this->processPersonData($person);
    $cache->set($cacheKey, $data, ['person_' . $person->getUid()], 3600);
}
```

### Database Optimization
- Use proper indexing in ext_tables.sql
- Implement lazy loading for relationships
- Use QueryBuilder for complex queries
- Monitor query performance

### Asset Optimization
```php
// Use TYPO3 asset management
$this->pageRenderer->addCssFile(
    'EXT:leseohren/Resources/Public/Css/leseohren.min.css',
    'stylesheet',
    'all',
    '',
    true,
    false,
    '',
    true
);
```

## Testing

### Unit Tests
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Unit\Domain\Model;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use SKom\Leseohren\Domain\Model\Person;

class PersonTest extends UnitTestCase
{
    protected Person $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new Person();
    }

    /**
     * @test
     */
    public function getFullnameReturnsFirstnameAndLastname(): void
    {
        $this->subject->setFirstname('John');
        $this->subject->setLastname('Doe');
        
        self::assertEquals('John Doe', $this->subject->getFullname());
    }
}
```

### Functional Tests
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Functional\Controller;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class PersonControllerTest extends FunctionalTestCase
{
    protected $testExtensionsToLoad = [
        'typo3conf/ext/leseohren',
    ];

    /**
     * @test
     */
    public function listActionReturnsPersons(): void
    {
        // Test implementation
    }
}
```

## Deployment and Maintenance

### Version Management
- Use semantic versioning
- Maintain CHANGELOG.md
- Tag releases properly
- Document breaking changes

### Database Updates
```php
// Classes/Updates/PersonFieldMigration.php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Updates;

use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

class PersonFieldMigration implements UpgradeWizardInterface
{
    public function getIdentifier(): string
    {
        return 'leseohrenPersonFieldMigration';
    }

    public function getTitle(): string
    {
        return 'Migrate person fields';
    }

    public function getDescription(): string
    {
        return 'Migrates old person field structure to new format';
    }

    public function executeUpdate(): bool
    {
        // Migration logic here
        return true;
    }

    public function updateNecessary(): bool
    {
        // Check if update is needed
        return false;
    }

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class
        ];
    }
}
```