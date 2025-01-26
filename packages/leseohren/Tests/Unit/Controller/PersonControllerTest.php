<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Unit\Controller;

use SKom\Leseohren\Controller\PersonController;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use SKom\Leseohren\Domain\Repository\PersonRepository;
use SKom\Leseohren\Domain\Model\Person;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 *
 * @author Sven Kalbhenn <sven@skom.de>
 */
class PersonControllerTest extends UnitTestCase
{
    /**
     * @var PersonController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(PersonController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllpeopleFromRepositoryAndAssignsThemToView(): void
    {
        $allpeople = $this->getMockBuilder(ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $personRepository = $this->getMockBuilder(PersonRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $personRepository->expects(self::once())->method('findAll')->will(self::returnValue($allpeople));
        $this->subject->_set('personRepository', $personRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('people', $allpeople);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenPersonToView(): void
    {
        $person = new Person();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('person', $person);

        $this->subject->showAction($person);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenPersonToPersonRepository(): void
    {
        $person = new Person();

        $personRepository = $this->getMockBuilder(PersonRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $personRepository->expects(self::once())->method('add')->with($person);
        $this->subject->_set('personRepository', $personRepository);

        $this->subject->createAction($person);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenPersonToView(): void
    {
        $person = new Person();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('person', $person);

        $this->subject->editAction($person);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenPersonInPersonRepository(): void
    {
        $person = new Person();

        $personRepository = $this->getMockBuilder(PersonRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $personRepository->expects(self::once())->method('update')->with($person);
        $this->subject->_set('personRepository', $personRepository);

        $this->subject->updateAction($person);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenPersonFromPersonRepository(): void
    {
        $person = new Person();

        $personRepository = $this->getMockBuilder(PersonRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $personRepository->expects(self::once())->method('remove')->with($person);
        $this->subject->_set('personRepository', $personRepository);

        $this->subject->deleteAction($person);
    }
}
