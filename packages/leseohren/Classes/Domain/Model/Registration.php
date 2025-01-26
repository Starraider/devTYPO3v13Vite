<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * This file is part of the "Leseohren" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Sven Kalbhenn <sven@skom.de>, SKom
 */
/**
 * Registration
 */
class Registration extends AbstractEntity
{
    /**
     * @var Person
     */
    public $person;

    /**
     * event
     *
     * @var Event
     */
    public $event;

    /**
     * registration_date
     *
     * @var \DateTime
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected $registrationDate = null;

    /**
     * onwaitlist
     *
     * @var bool
     */
    protected $onwaitlist = false;



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
        //$this->person = $this->person ?: new ObjectStorage();
    }

    // /**
    //  * Adds a Person
    //  *
    //  * @param Person $person The Person to be added
    //  * @return void
    //  */
    // public function addPerson(Person $person): void
    // {
    //     $this->person->attach($person);
    // }

    // /**
    //  * Removes a Person
    //  *
    //  * @param Person $personToRemove The Person to be removed
    //  * @return void
    //  */
    // public function removePerson(Person $personToRemove): void
    // {
    //     $this->person->detach($personToRemove);
    // }

    // /**
    //  * Returns the person
    //  *
    //  * @return ObjectStorage<Person>
    //  */
    // public function getPerson()
    // {
    //     return $this->person;
    // }

    // /**
    //  * Set person
    //  * @param ObjectStorage<Person> $person
    //  * @return void
    //  */
    // public function setPerson(ObjectStorage $person): void
    // {
    //     $this->person = $person;
    // }

    /**
     * Returns the registration_date
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Sets the registration_date
     *
     * @return void
     */
    public function setRegistrationDate(\DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    /**
     * Returns the onwaitlist
     *
     * @return bool
     */
    public function getOnwaitlist()
    {
        return $this->onwaitlist;
    }

    /**
     * Sets the onwaitlist
     *
     * @return void
     */
    public function setOnwaitlist(bool $onwaitlist): void
    {
        $this->onwaitlist = $onwaitlist;
    }

    /**
     * Returns the boolean state of onwaitlist
     *
     * @return bool
     */
    public function isOnwaitlist()
    {
        return $this->onwaitlist;
    }

    /**
     * Returns the event
     *
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Sets the event
     *
     * @return void
     */
    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }

    /**
     * Returns the person
     *
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Sets the person
     *
     * @return void
     */
    public function setPerson(Person $person): void
    {
        $this->person = $person;
    }
}
