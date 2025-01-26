<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Unit\Domain\Model;

use SKom\Leseohren\Domain\Model\Present;
use SKom\Leseohren\Domain\Model\Gift;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Sven Kalbhenn <sven@skom.de>
 */
class PresentTest extends UnitTestCase
{
    /**
     * @var Present|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            Present::class,
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
    public function getGiftDateReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getGift_date()
        );
    }

    /**
     * @test
     */
    public function setGiftDateForDateTimeSetsGift_date(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setGift_date($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('gift_date'));
    }

    /**
     * @test
     */
    public function getGivenReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getGiven());
    }

    /**
     * @test
     */
    public function setGivenForBoolSetsGiven(): void
    {
        $this->subject->setGiven(true);

        self::assertEquals(true, $this->subject->_get('given'));
    }

    /**
     * @test
     */
    public function getGiftReturnsInitialValueForGift(): void
    {
        self::assertEquals(
            null,
            $this->subject->getGift()
        );
    }

    /**
     * @test
     */
    public function setGiftForGiftSetsGift(): void
    {
        $giftFixture = new Gift();
        $this->subject->setGift($giftFixture);

        self::assertEquals($giftFixture, $this->subject->_get('gift'));
    }
}
