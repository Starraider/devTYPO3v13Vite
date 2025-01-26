<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Unit\Controller;

use SKom\Leseohren\Controller\EventController;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use SKom\Leseohren\Domain\Repository\EventRepository;
use SKom\Leseohren\Domain\Model\Event;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 *
 * @author Sven Kalbhenn <sven@skom.de>
 */
class EventControllerTest extends UnitTestCase
{
    /**
     * @var EventController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(EventController::class))
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
    public function listActionFetchesAllEventsFromRepositoryAndAssignsThemToView(): void
    {
        $allEvents = $this->getMockBuilder(ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $eventRepository = $this->getMockBuilder(EventRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $eventRepository->expects(self::once())->method('findAll')->will(self::returnValue($allEvents));
        $this->subject->_set('eventRepository', $eventRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('events', $allEvents);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenEventToView(): void
    {
        $event = new Event();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('event', $event);

        $this->subject->showAction($event);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenEventToEventRepository(): void
    {
        $event = new Event();

        $eventRepository = $this->getMockBuilder(EventRepository::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $eventRepository->expects(self::once())->method('add')->with($event);
        $this->subject->_set('eventRepository', $eventRepository);

        $this->subject->createAction($event);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenEventToView(): void
    {
        $event = new Event();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('event', $event);

        $this->subject->editAction($event);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenEventInEventRepository(): void
    {
        $event = new Event();

        $eventRepository = $this->getMockBuilder(EventRepository::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $eventRepository->expects(self::once())->method('update')->with($event);
        $this->subject->_set('eventRepository', $eventRepository);

        $this->subject->updateAction($event);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenEventFromEventRepository(): void
    {
        $event = new Event();

        $eventRepository = $this->getMockBuilder(EventRepository::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $eventRepository->expects(self::once())->method('remove')->with($event);
        $this->subject->_set('eventRepository', $eventRepository);

        $this->subject->deleteAction($event);
    }
}
