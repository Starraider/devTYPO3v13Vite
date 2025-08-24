<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Functional\Template;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use SKom\Leseohren\Domain\Model\Person;

/**
 * Test for Person List template functionality with various name scenarios
 */
class PersonListTemplateTest extends FunctionalTestCase
{
    protected $testExtensionsToLoad = [
        'typo3conf/ext/leseohren',
    ];

    protected StandaloneView $view;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->setTemplatePathAndFilename(
            'EXT:leseohren/Resources/Private/Templates/Person/List.html'
        );
        $this->view->setLayoutRootPaths(['EXT:leseohren/Resources/Private/Layouts/']);
        $this->view->setPartialRootPaths(['EXT:leseohren/Resources/Private/Partials/']);
    }

    /**
     * @test
     */
    public function templateDisplaysPersonWithBothFirstnameAndLastname(): void
    {
        $person = new Person();
        $person->setFirstname('John');
        $person->setLastname('Doe');
        $person->_setProperty('uid', 1);

        $this->view->assign('people', [$person]);
        $output = $this->view->render();

        // Should display "Doe, John" format
        self::assertStringContainsString('Doe, John', $output);
        
        // Should contain proper link structure
        self::assertStringContainsString('<f:link.action action="show" arguments="{person : person}">', $output);
        
        // Should not contain empty name scenarios
        self::assertStringNotContainsString('Doe,</f:if>', $output);
        self::assertStringNotContainsString(', John</f:if>', $output);
    }

    /**
     * @test
     */
    public function templateDisplaysPersonWithOnlyLastname(): void
    {
        $person = new Person();
        $person->setLastname('Smith');
        $person->setFirstname(''); // Empty firstname
        $person->_setProperty('uid', 2);

        $this->view->assign('people', [$person]);
        $output = $this->view->render();

        // Should display only "Smith" without comma
        self::assertStringContainsString('Smith</f:if>', $output);
        
        // Should not contain comma or empty firstname
        self::assertStringNotContainsString('Smith,', $output);
        self::assertStringNotContainsString('Smith, </f:if>', $output);
        
        // Should contain proper link structure
        self::assertStringContainsString('<f:link.action action="show" arguments="{person : person}">', $output);
    }

    /**
     * @test
     */
    public function templateDisplaysPersonWithOnlyFirstname(): void
    {
        $person = new Person();
        $person->setFirstname('Jane');
        $person->setLastname(''); // Empty lastname
        $person->_setProperty('uid', 3);

        $this->view->assign('people', [$person]);
        $output = $this->view->render();

        // Should display only "Jane" (falls back to firstname when no lastname)
        self::assertStringContainsString('Jane</f:else>', $output);
        
        // Should not contain comma
        self::assertStringNotContainsString(', Jane', $output);
        
        // Should contain proper link structure
        self::assertStringContainsString('<f:link.action action="show" arguments="{person : person}">', $output);
    }

    /**
     * @test
     */
    public function templateHandlesPersonWithNoNames(): void
    {
        $person = new Person();
        $person->setFirstname('');
        $person->setLastname('');
        $person->_setProperty('uid', 4);

        $this->view->assign('people', [$person]);
        $output = $this->view->render();

        // Should handle empty names gracefully (falls back to empty firstname)
        self::assertStringContainsString('</f:else>', $output);
        
        // Should still contain link structure
        self::assertStringContainsString('<f:link.action action="show" arguments="{person : person}">', $output);
    }

    /**
     * @test
     */
    public function templateContainsProperLinkNavigation(): void
    {
        $person = new Person();
        $person->setFirstname('Test');
        $person->setLastname('User');
        $person->_setProperty('uid', 5);

        $this->view->assign('people', [$person]);
        $output = $this->view->render();

        // Should contain proper Fluid link action
        self::assertStringContainsString('<f:link.action action="show" arguments="{person : person}">', $output);
        
        // Should wrap the name display in the link
        self::assertStringContainsString('User, Test', $output);
        self::assertStringContainsString('</f:link.action>', $output);
    }

    /**
     * @test
     */
    public function templateContainsResponsiveTableStructure(): void
    {
        $person = new Person();
        $person->setFirstname('Responsive');
        $person->setLastname('Test');
        $person->_setProperty('uid', 6);

        $this->view->assign('people', [$person]);
        $output = $this->view->render();

        // Should contain Bootstrap table classes for responsiveness
        self::assertStringContainsString('class="table table-striped display"', $output);
        
        // Should contain proper table structure
        self::assertStringContainsString('<table id="personList"', $output);
        self::assertStringContainsString('<thead>', $output);
        self::assertStringContainsString('<tbody>', $output);
        
        // Should contain proper column headers
        self::assertStringContainsString('<f:translate key="tx_leseohren_domain_model_person.name" />', $output);
    }

    /**
     * @test
     */
    public function templateHandlesSpecialCharactersInNames(): void
    {
        $person = new Person();
        $person->setFirstname('José');
        $person->setLastname('Müller-Schmidt');
        $person->_setProperty('uid', 7);

        $this->view->assign('people', [$person]);
        $output = $this->view->render();

        // Should display special characters correctly
        self::assertStringContainsString('Müller-Schmidt, José', $output);
        
        // Should maintain proper link structure
        self::assertStringContainsString('<f:link.action action="show" arguments="{person : person}">', $output);
    }

    /**
     * @test
     */
    public function templateHandlesLongNames(): void
    {
        $person = new Person();
        $person->setFirstname('Verylongfirstnamethatmightcauselayoutissues');
        $person->setLastname('Verylonglastnamethatmightalsocauselayoutissues');
        $person->_setProperty('uid', 8);

        $this->view->assign('people', [$person]);
        $output = $this->view->render();

        // Should display long names with proper format
        self::assertStringContainsString('Verylonglastnamethatmightalsocauselayoutissues, Verylongfirstnamethatmightcauselayoutissues', $output);
        
        // Should maintain proper link structure
        self::assertStringContainsString('<f:link.action action="show" arguments="{person : person}">', $output);
    }

    /**
     * @test
     */
    public function templateMaintainsTableStructureWithMultiplePeople(): void
    {
        $people = [];
        
        // Person with both names
        $person1 = new Person();
        $person1->setFirstname('John');
        $person1->setLastname('Doe');
        $person1->_setProperty('uid', 1);
        $people[] = $person1;
        
        // Person with only lastname
        $person2 = new Person();
        $person2->setLastname('Smith');
        $person2->setFirstname('');
        $person2->_setProperty('uid', 2);
        $people[] = $person2;
        
        // Person with only firstname
        $person3 = new Person();
        $person3->setFirstname('Jane');
        $person3->setLastname('');
        $person3->_setProperty('uid', 3);
        $people[] = $person3;

        $this->view->assign('people', $people);
        $output = $this->view->render();

        // Should contain all three different name formats
        self::assertStringContainsString('Doe, John', $output);
        self::assertStringContainsString('Smith</f:if>', $output);
        self::assertStringContainsString('Jane</f:else>', $output);
        
        // Should maintain proper table structure
        $trCount = substr_count($output, '<tr>');
        self::assertGreaterThanOrEqual(4, $trCount); // Header + 3 data rows
        
        // Each person should have proper link
        self::assertEquals(3, substr_count($output, '<f:link.action action="show"'));
    }
}