<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Functional\DataTable;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Test DataTable functionality for Person List with merged name column
 */
class PersonListDataTableTest extends FunctionalTestCase
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
    public function personListRendersWithCorrectTableStructure(): void
    {
        $response = $this->executeFrontendRequest(
            $this->buildRequest('/')
        );
        
        self::assertEquals(200, $response->getStatusCode());
        
        $content = (string)$response->getBody();
        
        // Verify table exists with correct ID
        self::assertStringContainsString('id="personList"', $content);
        
        // Verify table has correct classes
        self::assertStringContainsString('class="table table-striped display"', $content);
        
        // Verify correct number of columns (9 total: name, categories, zip, city, email, phone, org_categories, fz, actions)
        self::assertStringContainsString('<th>', $content);
        
        // Count th elements to verify column structure
        $thCount = substr_count($content, '<th>') + substr_count($content, '<th ');
        self::assertEquals(9, $thCount, 'Table should have exactly 9 columns after merging firstname and lastname');
    }

    /**
     * @test
     */
    public function personListRendersNameColumnCorrectly(): void
    {
        $response = $this->executeFrontendRequest(
            $this->buildRequest('/')
        );
        
        $content = (string)$response->getBody();
        
        // Verify name column header exists
        self::assertStringContainsString('tx_leseohren_domain_model_person.name', $content);
        
        // Verify merged name format is used in template
        self::assertStringContainsString('{person.lastname}', $content);
        self::assertStringContainsString('{person.firstname}', $content);
        
        // Verify conditional logic for name display
        self::assertStringContainsString('<f:if condition="{person.lastname}">', $content);
        self::assertStringContainsString('<f:if condition="{person.firstname}">', $content);
    }

    /**
     * @test
     */
    public function dataTablesJavaScriptIsIncluded(): void
    {
        $response = $this->executeFrontendRequest(
            $this->buildRequest('/')
        );
        
        $content = (string)$response->getBody();
        
        // Verify DataTables entry point is included
        self::assertStringContainsString('DataTables.entry.js', $content);
        
        // Verify Vite asset collector is used
        self::assertStringContainsString('vac:asset.vite', $content);
    }

    /**
     * @test
     */
    public function personListHandlesEmptyDataCorrectly(): void
    {
        // Test with no persons in database
        $this->importDataSet(__DIR__ . '/Fixtures/empty_persons.xml');
        
        $response = $this->executeFrontendRequest(
            $this->buildRequest('/')
        );
        
        self::assertEquals(200, $response->getStatusCode());
        
        $content = (string)$response->getBody();
        
        // Verify table structure exists even with no data
        self::assertStringContainsString('id="personList"', $content);
        self::assertStringContainsString('<thead>', $content);
        self::assertStringContainsString('<tbody>', $content);
    }

    /**
     * @test
     */
    public function personListRendersPersonDataCorrectly(): void
    {
        $response = $this->executeFrontendRequest(
            $this->buildRequest('/')
        );
        
        $content = (string)$response->getBody();
        
        // Verify person data is rendered in table rows
        self::assertStringContainsString('<tbody>', $content);
        self::assertStringContainsString('<tr>', $content);
        
        // Verify link structure for person names
        self::assertStringContainsString('f:link.action action="show"', $content);
        self::assertStringContainsString('arguments="{person : person}"', $content);
    }

    /**
     * @test
     */
    public function personListIncludesAllRequiredColumns(): void
    {
        $response = $this->executeFrontendRequest(
            $this->buildRequest('/')
        );
        
        $content = (string)$response->getBody();
        
        // Verify all expected column headers are present
        $expectedColumns = [
            'tx_leseohren_domain_model_person.name', // Name (merged)
            'Kategorien', // Categories
            'tx_leseohren_domain_model_person.zip', // ZIP
            'tx_leseohren_domain_model_person.city', // City
            'tx_leseohren_domain_model_person.email', // Email
            'Telefon', // Phone
            'Organisation Kategorien', // Organization Categories
            'FZ', // Führungszeugnis
            'Aktionen' // Actions
        ];
        
        foreach ($expectedColumns as $column) {
            self::assertStringContainsString($column, $content, "Column '{$column}' should be present in table");
        }
    }

    /**
     * @test
     */
    public function personListExcludesOldFirstnameLastnameColumns(): void
    {
        $response = $this->executeFrontendRequest(
            $this->buildRequest('/')
        );
        
        $content = (string)$response->getBody();
        
        // Verify old separate firstname/lastname columns are not present
        self::assertStringNotContainsString('tx_leseohren_domain_model_person.firstname', $content);
        self::assertStringNotContainsString('tx_leseohren_domain_model_person.lastname', $content);
        
        // Verify we don't have separate firstname/lastname table cells
        $pattern = '/<td[^>]*>\s*<f:link\.action[^>]*>\s*\{person\.firstname\}/';
        self::assertDoesNotMatchRegularExpression($pattern, $content);
        
        $pattern = '/<td[^>]*>\s*<f:link\.action[^>]*>\s*\{person\.lastname\}/';
        self::assertDoesNotMatchRegularExpression($pattern, $content);
    }

    /**
     * @test
     */
    public function personListMaintainsBootstrapStyling(): void
    {
        $response = $this->executeFrontendRequest(
            $this->buildRequest('/')
        );
        
        $content = (string)$response->getBody();
        
        // Verify Bootstrap classes are maintained
        self::assertStringContainsString('table table-striped', $content);
        self::assertStringContainsString('btn btn-primary', $content);
        self::assertStringContainsString('container', $content);
        
        // Verify responsive classes
        self::assertStringContainsString('display', $content); // DataTables responsive class
    }

    /**
     * @test
     */
    public function personListIncludesNewPersonButton(): void
    {
        $response = $this->executeFrontendRequest(
            $this->buildRequest('/')
        );
        
        $content = (string)$response->getBody();
        
        // Verify new person button exists
        self::assertStringContainsString('f:link.action action="new"', $content);
        self::assertStringContainsString('tx_leseohren_domain_model_person.newPerson', $content);
        self::assertStringContainsString('bi-person-fill-add', $content);
    }

    private function buildRequest(string $path): \TYPO3\CMS\Core\Http\ServerRequest
    {
        return new \TYPO3\CMS\Core\Http\ServerRequest(
            'http://localhost' . $path,
            'GET'
        );
    }
}