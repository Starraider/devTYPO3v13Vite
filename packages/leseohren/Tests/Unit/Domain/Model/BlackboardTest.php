<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Unit\Domain\Model;

use SKom\Leseohren\Domain\Model\Blackboard;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Sven Kalbhenn <sven@skom.de>
 */
class BlackboardTest extends UnitTestCase
{
    /**
     * @var Blackboard|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            Blackboard::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle(): void
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('title'));
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription(): void
    {
        $this->subject->setDescription('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('description'));
    }

    /**
     * @test
     */
    public function getStartDateReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getStartDate()
        );
    }

    /**
     * @test
     */
    public function setStartDateForDateTimeSetsStartDate(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setStartDate($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('startDate'));
    }

    /**
     * @test
     */
    public function getEndDateReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getEndDate()
        );
    }

    /**
     * @test
     */
    public function setEndDateForDateTimeSetsEndDate(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setEndDate($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('endDate'));
    }
}
