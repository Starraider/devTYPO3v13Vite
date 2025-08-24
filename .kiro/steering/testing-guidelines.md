# Leseohren Testing Guidelines

## Testing Strategy

### Testing Pyramid
1. **Unit Tests (70%)**: Test individual classes and methods in isolation
2. **Integration Tests (20%)**: Test component interactions
3. **Functional Tests (10%)**: Test complete user workflows

### Test Coverage Goals
- **Minimum**: 80% code coverage
- **Target**: 90% code coverage for critical business logic
- **Domain Models**: 100% coverage for business rules
- **Controllers**: Focus on action methods and validation

## Test Environment Setup

### DDEV Development Environment
This project uses DDEV for local development. All PHPUnit tests should be executed within the DDEV container to ensure proper environment setup and dependencies.

#### Running PHPUnit Tests
```bash
# Run all tests
ddev exec ./vendor/bin/phpunit

# Run specific test file
ddev exec ./vendor/bin/phpunit Tests/Unit/Domain/Model/PersonTest.php

# Run tests with coverage report
ddev exec ./vendor/bin/phpunit --coverage-html coverage/

# Run tests with verbose output
ddev exec ./vendor/bin/phpunit --verbose

# Run specific test method
ddev exec ./vendor/bin/phpunit --filter testMethodName

# Run tests in specific directory
ddev exec ./vendor/bin/phpunit Tests/Functional/
```

#### Test Database Setup
DDEV automatically provides a test database environment. Tests should use the TYPO3 testing framework which handles database setup and teardown.

#### Why Use DDEV for Testing?
- **Consistent Environment**: Same PHP version, extensions, and configuration as production
- **Database Access**: Proper MySQL/MariaDB setup with test database
- **TYPO3 Dependencies**: All TYPO3 core dependencies available
- **Isolation**: Tests run in isolated container environment
- **Performance**: Optimized container setup for testing

## Unit Testing

### Domain Model Testing
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

    /**
     * @test
     */
    public function getFullnameTrimsWhitespace(): void
    {
        $this->subject->setFirstname('  John  ');
        $this->subject->setLastname('  Doe  ');
        
        self::assertEquals('John Doe', $this->subject->getFullname());
    }

    /**
     * @test
     */
    public function isActiveReturnsTrueForActiveStatus(): void
    {
        $this->subject->setStatus(Person::STATUS_ACTIVE);
        
        self::assertTrue($this->subject->isActive());
    }

    /**
     * @test
     */
    public function isActiveReturnsFalseForPausedStatus(): void
    {
        $this->subject->setStatus(Person::STATUS_PAUSED);
        
        self::assertFalse($this->subject->isActive());
    }

    /**
     * @test
     */
    public function isFuehrungszeugnisExpiredReturnsTrueWhenNoDate(): void
    {
        self::assertTrue($this->subject->isFuehrungszeugnisExpired());
    }

    /**
     * @test
     */
    public function isFuehrungszeugnisExpiredReturnsTrueWhenExpired(): void
    {
        $expiredDate = new \DateTime('-6 years');
        $this->subject->setFuehrungszeugnisDate($expiredDate);
        
        self::assertTrue($this->subject->isFuehrungszeugnisExpired());
    }

    /**
     * @test
     */
    public function isFuehrungszeugnisExpiredReturnsFalseWhenValid(): void
    {
        $validDate = new \DateTime('-2 years');
        $this->subject->setFuehrungszeugnisDate($validDate);
        
        self::assertFalse($this->subject->isFuehrungszeugnisExpired());
    }

    /**
     * @test
     */
    public function getAgeReturnsNullWhenNoBirthday(): void
    {
        self::assertNull($this->subject->getAge());
    }

    /**
     * @test
     */
    public function getAgeReturnsCorrectAge(): void
    {
        $birthday = new \DateTime('-25 years');
        $this->subject->setBirthday($birthday);
        
        self::assertEquals(25, $this->subject->getAge());
    }
}
```

### Repository Testing
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Unit\Domain\Repository;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use SKom\Leseohren\Domain\Repository\PersonRepository;

class PersonRepositoryTest extends UnitTestCase
{
    protected PersonRepository $subject;
    protected QueryInterface $query;
    protected QueryResultInterface $queryResult;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->query = $this->createMock(QueryInterface::class);
        $this->queryResult = $this->createMock(QueryResultInterface::class);
        
        $this->subject = $this->getMockBuilder(PersonRepository::class)
            ->onlyMethods(['createQuery'])
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->subject->method('createQuery')->willReturn($this->query);
    }

    /**
     * @test
     */
    public function findByStatusCreatesCorrectQuery(): void
    {
        $status = Person::STATUS_ACTIVE;
        
        $this->query->expects(self::once())
            ->method('matching')
            ->with(self::anything())
            ->willReturn($this->query);
            
        $this->query->expects(self::once())
            ->method('execute')
            ->willReturn($this->queryResult);
        
        $result = $this->subject->findByStatus($status);
        
        self::assertSame($this->queryResult, $result);
    }
}
```

### Controller Testing
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Unit\Controller;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use SKom\Leseohren\Controller\PersonController;
use SKom\Leseohren\Domain\Repository\PersonRepository;
use SKom\Leseohren\Domain\Model\Person;

class PersonControllerTest extends UnitTestCase
{
    protected PersonController $subject;
    protected PersonRepository $personRepository;
    protected ViewInterface $view;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->personRepository = $this->createMock(PersonRepository::class);
        $this->view = $this->createMock(ViewInterface::class);
        
        $this->subject = new PersonController($this->personRepository);
        $this->subject->_set('view', $this->view);
    }

    /**
     * @test
     */
    public function listActionAssignsPeopleToView(): void
    {
        $people = $this->createMock(QueryResultInterface::class);
        
        $this->personRepository->expects(self::once())
            ->method('findAll')
            ->willReturn($people);
            
        $this->view->expects(self::once())
            ->method('assign')
            ->with('people', $people);
        
        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsPersonToView(): void
    {
        $person = new Person();
        
        $this->view->expects(self::once())
            ->method('assign')
            ->with('person', $person);
        
        $this->subject->showAction($person);
    }
}
```

## Functional Testing

### Database Testing
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Functional\Domain\Repository;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use SKom\Leseohren\Domain\Repository\PersonRepository;
use SKom\Leseohren\Domain\Model\Person;

class PersonRepositoryTest extends FunctionalTestCase
{
    protected $testExtensionsToLoad = [
        'typo3conf/ext/leseohren',
    ];

    protected PersonRepository $personRepository;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->importDataSet(__DIR__ . '/Fixtures/persons.xml');
        
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->personRepository = $objectManager->get(PersonRepository::class);
    }

    /**
     * @test
     */
    public function findByStatusReturnsActivePersons(): void
    {
        $activePersons = $this->personRepository->findByStatus(Person::STATUS_ACTIVE);
        
        self::assertCount(2, $activePersons);
    }

    /**
     * @test
     */
    public function upcomingBirthdaysReturnsPersonsWithBirthdaysInRange(): void
    {
        $upcomingBirthdays = $this->personRepository->upcomingBirthdays(7);
        
        self::assertCount(1, $upcomingBirthdays);
    }
}
```

### Test Fixtures
```xml
<!-- Tests/Functional/Domain/Repository/Fixtures/persons.xml -->
<?xml version="1.0" encoding="utf-8"?>
<dataset>
    <tx_leseohren_domain_model_person>
        <uid>1</uid>
        <pid>1</pid>
        <firstname>John</firstname>
        <lastname>Doe</lastname>
        <email>john.doe@example.com</email>
        <status>0</status>
        <birthday>1990-01-15</birthday>
    </tx_leseohren_domain_model_person>
    
    <tx_leseohren_domain_model_person>
        <uid>2</uid>
        <pid>1</pid>
        <firstname>Jane</firstname>
        <lastname>Smith</lastname>
        <email>jane.smith@example.com</email>
        <status>0</status>
        <birthday>1985-12-25</birthday>
    </tx_leseohren_domain_model_person>
    
    <tx_leseohren_domain_model_person>
        <uid>3</uid>
        <pid>1</pid>
        <firstname>Bob</firstname>
        <lastname>Johnson</lastname>
        <email>bob.johnson@example.com</email>
        <status>1</status>
        <birthday>1975-06-10</birthday>
    </tx_leseohren_domain_model_person>
</dataset>
```

### Controller Functional Testing
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Functional\Controller;

use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class PersonControllerTest extends FunctionalTestCase
{
    protected $testExtensionsToLoad = [
        'typo3conf/ext/leseohren',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->importDataSet(__DIR__ . '/Fixtures/pages.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/persons.xml');
        
        $this->setUpFrontendRootPage(1, [
            'EXT:leseohren/Configuration/TypoScript/setup.typoscript'
        ]);
    }

    /**
     * @test
     */
    public function listActionReturnsPersonList(): void
    {
        $response = $this->executeFrontendRequest(
            new InternalRequest('http://localhost/persons')
        );
        
        self::assertEquals(200, $response->getStatusCode());
        
        $content = (string)$response->getBody();
        self::assertStringContainsString('John Doe', $content);
        self::assertStringContainsString('Jane Smith', $content);
    }

    /**
     * @test
     */
    public function showActionReturnsPersonDetails(): void
    {
        $response = $this->executeFrontendRequest(
            new InternalRequest('http://localhost/persons/1')
        );
        
        self::assertEquals(200, $response->getStatusCode());
        
        $content = (string)$response->getBody();
        self::assertStringContainsString('John Doe', $content);
        self::assertStringContainsString('john.doe@example.com', $content);
    }
}
```

## Integration Testing

### Service Integration
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Integration\Service;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use SKom\Leseohren\Service\PersonService;
use SKom\Leseohren\Domain\Model\Person;

class PersonServiceTest extends FunctionalTestCase
{
    protected $testExtensionsToLoad = [
        'typo3conf/ext/leseohren',
    ];

    protected PersonService $personService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->personService = $this->get(PersonService::class);
    }

    /**
     * @test
     */
    public function createPersonWithValidDataSucceeds(): void
    {
        $personData = [
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'test.user@example.com',
            'status' => Person::STATUS_ACTIVE
        ];
        
        $person = $this->personService->createPerson($personData);
        
        self::assertInstanceOf(Person::class, $person);
        self::assertEquals('Test User', $person->getFullname());
        self::assertEquals('test.user@example.com', $person->getEmail());
    }

    /**
     * @test
     */
    public function createPersonWithInvalidEmailThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $personData = [
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'invalid-email',
            'status' => Person::STATUS_ACTIVE
        ];
        
        $this->personService->createPerson($personData);
    }
}
```

## Frontend Testing

### JavaScript Unit Tests
```javascript
// Tests/JavaScript/PersonList.test.js
describe('PersonList', () => {
    let personList;
    
    beforeEach(() => {
        document.body.innerHTML = `
            <table id="personTable">
                <thead>
                    <tr><th>Name</th><th>Email</th></tr>
                </thead>
                <tbody>
                    <tr><td>John Doe</td><td>john@example.com</td></tr>
                </tbody>
            </table>
        `;
        
        personList = new PersonList();
    });
    
    test('initializes DataTable correctly', () => {
        expect($.fn.DataTable.isDataTable('#personTable')).toBe(true);
    });
    
    test('applies correct configuration', () => {
        const table = $('#personTable').DataTable();
        const settings = table.settings()[0];
        
        expect(settings.oInit.responsive).toBe(true);
        expect(settings.oInit.pageLength).toBe(25);
    });
});
```

### End-to-End Testing
```javascript
// Tests/E2E/person-management.spec.js
const { test, expect } = require('@playwright/test');

test.describe('Person Management', () => {
    test('can create a new person', async ({ page }) => {
        await page.goto('/typo3/module/web/list');
        
        // Navigate to person list
        await page.click('text=Persons');
        
        // Click new person button
        await page.click('text=New Person');
        
        // Fill form
        await page.fill('[name="tx_leseohren_web_leseohrenleseohren[newPerson][firstname]"]', 'Test');
        await page.fill('[name="tx_leseohren_web_leseohrenleseohren[newPerson][lastname]"]', 'User');
        await page.fill('[name="tx_leseohren_web_leseohrenleseohren[newPerson][email]"]', 'test@example.com');
        
        // Submit form
        await page.click('input[type="submit"]');
        
        // Verify success
        await expect(page.locator('.alert-success')).toContainText('Person created successfully');
        await expect(page.locator('h1')).toContainText('Test User');
    });
    
    test('validates required fields', async ({ page }) => {
        await page.goto('/persons/new');
        
        // Submit empty form
        await page.click('input[type="submit"]');
        
        // Check validation errors
        await expect(page.locator('.invalid-feedback')).toBeVisible();
        await expect(page.locator('.invalid-feedback')).toContainText('This field is required');
    });
});
```

### Browser-Based Testing with MCP

#### Test Environment Access
The Leseohren application provides dedicated test pages accessible via the browser MCP at:
```
https://leseohrendb.ddev.site/test-pages/*
```

#### Available Test Pages
- **Person List Testing**: `https://leseohrendb.ddev.site/test-pages/person`


#### Using Browser MCP for Testing
```javascript
// Example: Testing responsive design via browser MCP
// Navigate to test page
await page.goto('https://leseohrendb.ddev.site/test-pages/person');

// Run responsive validation script
await page.evaluate(() => {
    // Paste responsive test script from Tests/Manual/ResponsiveTestScript.js
    // Script will automatically validate responsive behavior
});

// Check results
const testResults = await page.evaluate(() => window.responsiveTestResults);
expect(testResults.successRate).toBeGreaterThan(90);
```

#### Manual Testing Workflow
1. **Access Test Environment**: Navigate to `https://leseohrendb.ddev.site/test-pages/`
2. **Select Test Page**: Choose appropriate test page for your testing scenario
3. **Run Test Scripts**: Use browser console to execute manual test scripts
4. **Validate Results**: Review test output and validate against requirements
5. **Document Findings**: Record any issues or improvements needed

#### Test Data Management
Test pages include pre-populated test data for consistent testing:
- Sample persons with various name formats
- Different organization types and categories
- Events with various participant counts
- Edge cases (long names, special characters, etc.)

#### Browser Compatibility Testing
Use the browser MCP to test across different browsers and devices:
```bash
# Test in different browsers via MCP
# Chrome, Firefox, Safari, Edge all supported
# Mobile and desktop viewports available
```
```

## Test Data Management

### Test Fixtures
Create reusable test data:
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Fixtures;

use SKom\Leseohren\Domain\Model\Person;

class PersonFixture
{
    public static function createActivePerson(): Person
    {
        $person = new Person();
        $person->setFirstname('John');
        $person->setLastname('Doe');
        $person->setEmail('john.doe@example.com');
        $person->setStatus(Person::STATUS_ACTIVE);
        $person->setBirthday(new \DateTime('1990-01-15'));
        
        return $person;
    }
    
    public static function createPausedPerson(): Person
    {
        $person = new Person();
        $person->setFirstname('Jane');
        $person->setLastname('Smith');
        $person->setEmail('jane.smith@example.com');
        $person->setStatus(Person::STATUS_PAUSED);
        $person->setBirthday(new \DateTime('1985-12-25'));
        
        return $person;
    }
}
```

### Database Fixtures
```xml
<!-- Tests/Fixtures/Database/persons.xml -->
<?xml version="1.0" encoding="utf-8"?>
<dataset>
    <pages>
        <uid>1</uid>
        <title>Test Page</title>
        <doktype>1</doktype>
    </pages>
    
    <tx_leseohren_domain_model_person>
        <uid>1</uid>
        <pid>1</pid>
        <firstname>John</firstname>
        <lastname>Doe</lastname>
        <email>john.doe@example.com</email>
        <status>0</status>
        <birthday>631152000</birthday>
        <tstamp>1577836800</tstamp>
        <crdate>1577836800</crdate>
    </tx_leseohren_domain_model_person>
</dataset>
```

## Continuous Integration

### DDEV Testing Best Practices

#### Local Development Testing
```bash
# Start DDEV environment
ddev start

# Install dependencies (if needed)
ddev composer install

# Run all tests
ddev exec ./vendor/bin/phpunit

# Run tests with specific configuration
ddev exec ./vendor/bin/phpunit -c phpunit.xml

# Run tests with coverage (requires xdebug)
ddev xdebug on
ddev exec ./vendor/bin/phpunit --coverage-html coverage/
ddev xdebug off

# Run specific test suites
ddev exec ./vendor/bin/phpunit --testsuite="Unit Tests"
ddev exec ./vendor/bin/phpunit --testsuite="Functional Tests"
```

#### DDEV Test Environment Variables
```bash
# Set test-specific environment variables in DDEV
ddev config --web-environment-add="TYPO3_TESTING_FRAMEWORK_ENTRYPOINT=Tests/Functional/FunctionalTestsBootstrap.php"
ddev config --web-environment-add="typo3DatabaseName=leseohren_test"
```

#### Database Testing in DDEV
```bash
# Access test database
ddev mysql -d leseohren_test

# Reset test database
ddev exec ./vendor/bin/typo3 database:updateschema

# Import test fixtures
ddev exec ./vendor/bin/typo3 database:import Tests/Fixtures/test_data.sql
```

#### Debugging Tests in DDEV
```bash
# Enable Xdebug for test debugging
ddev xdebug on

# Run single test with debugging
ddev exec ./vendor/bin/phpunit --filter testMethodName Tests/Unit/Domain/Model/PersonTest.php

# Disable Xdebug after debugging
ddev xdebug off
```

### PHPUnit Configuration
```xml
<!-- phpunit.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<phpunit
    bootstrap="vendor/typo3/testing-framework/Resources/Core/Build/UnitTestsBootstrap.php"
    colors="true"
    convertErrorsToExceptions="true"
    convertWarningsToExceptions="true"
    forceCoversAnnotation="false"
    processIsolation="false"
    stopOnError="false"
    stopOnFailure="false"
    stopOnIncomplete="false"
    stopOnSkipped="false"
    verbose="false"
>
    <testsuites>
        <testsuite name="Unit Tests">
            <directory>Tests/Unit/</directory>
        </testsuite>
        <testsuite name="Functional Tests">
            <directory>Tests/Functional/</directory>
        </testsuite>
    </testsuites>
    
    <filter>
        <whitelist>
            <directory suffix=".php">Classes/</directory>
        </whitelist>
    </filter>
</phpunit>
```

### GitHub Actions Workflow
```yaml
# .github/workflows/tests.yml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    strategy:
      matrix:
        php-version: [8.1, 8.2, 8.3]
        typo3-version: [12.4, 13.4]
    
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: ${{ matrix.php-version }}
          extensions: mbstring, xml, ctype, iconv, intl, pdo_sqlite, mysql
          
      - name: Install dependencies
        run: |
          composer require typo3/cms-core:^${{ matrix.typo3-version }} --no-update
          composer install --prefer-dist --no-progress
          
      - name: Run unit tests
        run: vendor/bin/phpunit --testsuite="Unit Tests"
        
      - name: Run functional tests
        run: vendor/bin/phpunit --testsuite="Functional Tests"

# Note: For local development, always use DDEV:
# ddev exec ./vendor/bin/phpunit --testsuite="Unit Tests"
# ddev exec ./vendor/bin/phpunit --testsuite="Functional Tests"
```

## Test Documentation

### Test Coverage Reports
Generate and review coverage reports:
```bash
# Generate coverage report (use DDEV for local development)
ddev xdebug on
ddev exec ./vendor/bin/phpunit --coverage-html coverage/
ddev xdebug off

# For CI/CD environments
vendor/bin/phpunit --coverage-html coverage/

# View coverage report
open coverage/index.html
```

### Test Documentation
Document test scenarios and expected behaviors:
```markdown
# Test Scenarios

## Person Management

### Creating a Person
- ✅ Valid data creates person successfully
- ✅ Invalid email shows validation error
- ✅ Missing lastname shows validation error
- ✅ Duplicate email shows error

### Person Status Changes
- ✅ Active to paused transition works
- ✅ Paused to retired transition works
- ✅ Status change date is recorded
- ✅ Invalid status transitions are prevented

### Document Management
- ✅ Führungszeugnis upload works
- ✅ Invalid file types are rejected
- ✅ File size limits are enforced
- ✅ Expiry date calculation is correct
```
#
# Quick Reference: DDEV Testing Commands

### Essential Commands
```bash
# Start DDEV environment
ddev start

# Run all tests
ddev exec ./vendor/bin/phpunit

# Run specific test file
ddev exec ./vendor/bin/phpunit Tests/Unit/Domain/Model/PersonTest.php

# Run with coverage (enable Xdebug first)
ddev xdebug on
ddev exec ./vendor/bin/phpunit --coverage-html coverage/
ddev xdebug off

# Run specific test suite
ddev exec ./vendor/bin/phpunit --testsuite="Unit Tests"
ddev exec ./vendor/bin/phpunit --testsuite="Functional Tests"

# Run with verbose output
ddev exec ./vendor/bin/phpunit --verbose

# Run specific test method
ddev exec ./vendor/bin/phpunit --filter testMethodName
```

### Important Notes
- **Always use DDEV**: Run tests inside DDEV container for consistent environment
- **Database Setup**: DDEV provides proper test database configuration
- **Xdebug**: Enable only when needed for debugging or coverage reports
- **CI/CD**: GitHub Actions uses direct `vendor/bin/phpunit` commands
- **Performance**: DDEV container provides optimized testing environment

### Troubleshooting
```bash
# If tests fail due to database issues
ddev exec ./vendor/bin/typo3 database:updateschema

# If composer dependencies are missing
ddev composer install

# If DDEV is not running
ddev start

# Check DDEV status
ddev status
```