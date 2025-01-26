<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Unit\Domain\Model;

use SKom\Leseohren\Domain\Model\Person;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use SKom\Leseohren\Domain\Model\Present;
use SKom\Leseohren\Domain\Model\Blackboard;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Sven Kalbhenn <sven@skom.de>
 */
class PersonTest extends UnitTestCase
{
    /**
     * @var Person|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            Person::class,
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
    public function getFirstnameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getFirstname()
        );
    }

    /**
     * @test
     */
    public function setFirstnameForStringSetsFirstname(): void
    {
        $this->subject->setFirstname('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('firstname'));
    }

    /**
     * @test
     */
    public function getLastnameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getLastname()
        );
    }

    /**
     * @test
     */
    public function setLastnameForStringSetsLastname(): void
    {
        $this->subject->setLastname('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('lastname'));
    }

    /**
     * @test
     */
    public function getDonationsReturnsInitialValueForPresent(): void
    {
        $newObjectStorage = new ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getDonations()
        );
    }

    /**
     * @test
     */
    public function setDonationsForObjectStorageContainingPresentSetsDonations(): void
    {
        $Donation = new Present();
        $objectStorageHoldingExactlyOneDonations = new ObjectStorage();
        $objectStorageHoldingExactlyOneDonations->attach($Donation);
        $this->subject->setDonations($objectStorageHoldingExactlyOneDonations);

        self::assertEquals($objectStorageHoldingExactlyOneDonations, $this->subject->_get('Donations'));
    }

    /**
     * @test
     */
    public function addDonationToObjectStorageHoldingDonations(): void
    {
        $Donation = new Present();
        $DonationsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $DonationsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($Donation));
        $this->subject->_set('Donations', $DonationsObjectStorageMock);

        $this->subject->addDonation($Donation);
    }

    /**
     * @test
     */
    public function removeDonationFromObjectStorageHoldingDonations(): void
    {
        $Donation = new Present();
        $DonationsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $DonationsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($Donation));
        $this->subject->_set('Donations', $DonationsObjectStorageMock);

        $this->subject->removeDonation($Donation);
    }

    /**
     * @test
     */
    public function getBlackboardsReturnsInitialValueForBlackboard(): void
    {
        $newObjectStorage = new ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getBlackboards()
        );
    }

    /**
     * @test
     */
    public function setBlackboardsForObjectStorageContainingBlackboardSetsBlackboards(): void
    {
        $Blackboard = new Blackboard();
        $objectStorageHoldingExactlyOneBlackboards = new ObjectStorage();
        $objectStorageHoldingExactlyOneBlackboards->attach($Blackboard);
        $this->subject->setBlackboards($objectStorageHoldingExactlyOneBlackboards);

        self::assertEquals($objectStorageHoldingExactlyOneBlackboards, $this->subject->_get('Blackboards'));
    }

    /**
     * @test
     */
    public function addBlackboardToObjectStorageHoldingBlackboards(): void
    {
        $Blackboard = new Blackboard();
        $BlackboardsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $BlackboardsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($Blackboard));
        $this->subject->_set('Blackboards', $BlackboardsObjectStorageMock);

        $this->subject->addBlackboard($Blackboard);
    }

    /**
     * @test
     */
    public function removeBlackboardFromObjectStorageHoldingBlackboards(): void
    {
        $Blackboard = new Blackboard();
        $BlackboardsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $BlackboardsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($Blackboard));
        $this->subject->_set('Blackboards', $BlackboardsObjectStorageMock);

        $this->subject->removeBlackboard($Blackboard);
    }
}
