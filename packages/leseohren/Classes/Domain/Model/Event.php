<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\Category;

/**
 * This file is part of the "Leseohren" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Sven Kalbhenn <sven@skom.de>, SKom
 */
/**
 * Event
 */
class Event extends AbstractEntity
{
    /**
     * @var ObjectStorage<Category>
     */
    public $categories;

    /**
     * title
     *
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected $title = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * startDate
     *
     * @var \DateTime
     */
    protected $startDate = null;

    /**
     * endDate
     *
     * @var \DateTime
     */
    protected $endDate = null;

    /**
     * location
     *
     * @var string
     */
    protected $location = '';

    /**
     * Speaker
     *
     * @var ObjectStorage<Person>
     */
    #[Lazy]
    protected $speaker = null;

    /**
     * maxparticipants
     *
     * @var int
     */
    protected $maxparticipants = 0;

    /**
     * reminderSent
     *
     * @var bool
     */
    protected $reminderSent = false;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->categories = new ObjectStorage();
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    public function initializeObject(): void
    {
        $this->speaker = $this->speaker ?: new ObjectStorage();
    }

    /**
     * Add category to an event
     */
    public function addCategory(Category $category): void
    {
        $this->categories->attach($category);
    }

    /**
     * Set categories
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * Get categories
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * Remove category from event
     */
    public function removeCategory(Category $category): void
    {
        $this->categories->detach($category);
    }

    /**
     * Returns the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the extendedtitle
     *
     * @return string
     */
    public function getExtendedTitle()
    {
        return $this->startDate->format('d.m.Y') . ': ' . $this->title;
    }

    /**
     * Returns the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns the startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Sets the startDate
     *
     * @return void
     */
    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * Returns the endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Sets the endDate
     *
     * @return void
     */
    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * Returns the location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Sets the location
     *
     * @return void
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    /**
     * Adds a Speaker
     *
     * @return void
     */
    public function addSpeaker(Person $speaker): void
    {
        $this->speaker->attach($speaker);
    }

    /**
     * Removes a Speaker
     *
     * @param Person $speakerToRemove The Speaker to be removed
     * @return void
     */
    public function removeSpeaker(Person $speakerToRemove): void
    {
        $this->speaker->detach($speakerToRemove);
    }

    /**
     * Returns the Speaker
     *
     * @return ObjectStorage<Person>
     */
    public function getSpeaker()
    {
        return $this->speaker;
    }

    /**
     * Sets the Speaker
     *
     * @param ObjectStorage<Person> $speaker
     * @return void
     */
    public function setSpeaker(ObjectStorage $speaker): void
    {
        $this->speaker = $speaker;
    }

    /**
     * Returns the maxparticipants
     *
     * @return int
     */
    public function getMaxparticipants()
    {
        return $this->maxparticipants;
    }

    /**
     * Sets the maxparticipants
     *
     * @return void
     */
    public function setMaxparticipants(int $maxparticipants): void
    {
        $this->maxparticipants = $maxparticipants;
    }

    /**
     * Returns the reminderSent
     *
     * @return string
     */
    public function getReminderSent()
    {
        return $this->reminderSent;
    }

    /**
     * Sets the reminderSent
     *
     * @return void
     */
    public function setReminderSent(bool $reminderSent): void
    {
        $this->reminderSent = $reminderSent;
    }

}
