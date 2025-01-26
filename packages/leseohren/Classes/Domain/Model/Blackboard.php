<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * This file is part of the "Leseohren" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Sven Kalbhenn <sven@skom.de>, SKom
 */
/**
 * Blackboard
 */
class Blackboard extends AbstractEntity
{
    /**
     * @var ObjectStorage<Person>
     */
    public $person;

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
     * __construct
     */
    public function __construct()
    {
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     *
     * @return void
     */
    public function initializeObject(): void
    {
        $this->person = $this->person ?: new ObjectStorage();
    }

    /**
     * Adds a Person
     *
     * @param Person $person The Person to be added
     * @return void
     */
    public function addPerson(Person $person): void
    {
        $this->person->attach($person);
    }

    /**
     * Removes a Person
     *
     * @param Person $personToRemove The Person to be removed
     * @return void
     */
    public function removePerson(Person $personToRemove): void
    {
        $this->person->detach($personToRemove);
    }

    /**
     * Returns the person
     *
     * @return ObjectStorage<Person>
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set person
     * @param ObjectStorage<Person> $person
     * @return void
     */
    public function setPerson(ObjectStorage $person): void
    {
        $this->person = $person;
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
}
