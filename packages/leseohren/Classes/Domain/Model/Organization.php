<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Domain\Model\Category;
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
 * Organisation
 */
class Organization extends AbstractEntity
{
    /**
     * @var ObjectStorage<Category>
     */
    public $categories;

    /**
     * Name der Organisation
     *
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected $name = '';

    /**
     * street1
     *
     * @var string
     */
    protected $street1 = '';

    /**
     * street2
     *
     * @var string
     */
    protected $street2 = '';

    /**
     * zip
     *
     * @var string
     */
    protected $zip = '';

    /**
     * city
     *
     * @var string
     */
    protected $city = '';

    /**
     * district
     *
     * @var string
     */
    protected $district = '';

    /**
     * phone1
     *
     * @var string
     */
    protected $phone1 = '';

    /**
     * phone2
     *
     * @var string
     */
    protected $phone2 = '';

    /**
     * email
     *
     * @var string
     */
    protected $email = '';

    /**
     * url
     *
     * @var string
     */
    protected $url = '';

    /**
     * whatsapp
     *
     * @var string
     */
    protected $whatsapp = '';

    /**
     * lastcontact
     *
     * @var \DateTime
     */
    protected $lastcontact = null;

    /**
     * openingHours
     *
     * @var string
     */
    protected $openingHours = '';

    /**
     * notes
     *
     * @var string
     */
    protected $notes = '';

    /**
     * readingTimes
     *
     * @var string
     */
    protected $readingTimes = '';

    /**
     * vpLanguages
     *
     * @var string
     */
    protected $vpLanguages = '';

    /**
     * vpNumber
     *
     * @var int
     */
    protected $vpNumber = 0;

    /**
     * Kontaktperson
     *
     * @var Person|null
     */
    #[Lazy]
    protected $contactPerson = null;

    /**
     * vlpaten
     *
     * @var ObjectStorage<Person>
     */
    #[Lazy]
    protected $vlpaten = null;

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
        $this->vlpaten = $this->vlpaten ?: new ObjectStorage();
    }

    /**
     * Add category to a blog
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
     * Remove category from organisation
     */
    public function removeCategory(Category $category): void
    {
        $this->categories->detach($category);
    }

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns the street1
     *
     * @return string
     */
    public function getStreet1()
    {
        return $this->street1;
    }

    /**
     * Sets the street1
     *
     * @return void
     */
    public function setStreet1(string $street1): void
    {
        $this->street1 = $street1;
    }

    /**
     * Returns the street2
     *
     * @return string
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * Sets the street2
     *
     * @return void
     */
    public function setStreet2(string $street2): void
    {
        $this->street2 = $street2;
    }

    /**
     * Returns the zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets the zip
     *
     * @return void
     */
    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    /**
     * Returns the city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @return void
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * Returns the district
     *
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Sets the district
     *
     * @return void
     */
    public function setDistrict(string $district): void
    {
        $this->district = $district;
    }

    /**
     * Returns the phone1
     *
     * @return string
     */
    public function getPhone1()
    {
        return $this->phone1;
    }

    /**
     * Sets the phone1
     *
     * @return void
     */
    public function setPhone1(string $phone1): void
    {
        $this->phone1 = $phone1;
    }

    /**
     * Returns the phone2
     *
     * @return string
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * Sets the phone2
     *
     * @return void
     */
    public function setPhone2(string $phone2): void
    {
        $this->phone2 = $phone2;
    }

    /**
     * Returns the email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     *
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Returns the url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the url
     *
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * Returns the whatsapp
     *
     * @return string
     */
    public function getWhatsapp()
    {
        return $this->whatsapp;
    }

    /**
     * Sets the whatsapp
     *
     * @return void
     */
    public function setWhatsapp(string $whatsapp): void
    {
        $this->whatsapp = $whatsapp;
    }

    /**
     * Returns the lastcontact
     *
     * @return \DateTime|null
     */
    public function getLastcontact(): ?\DateTime
    {
        return $this->lastcontact;
    }

    /**
     * Sets the lastcontact
     *
     * @param \DateTime|null $lastcontact
     * @return void
     */
    public function setLastcontact(?\DateTime $lastcontact): void
    {
        $this->lastcontact = $lastcontact;
    }

    /**
     * Returns the openingHours
     *
     * @return string
     */
    public function getOpeningHours()
    {
        return $this->openingHours;
    }

    /**
     * Sets the openingHours
     *
     * @return void
     */
    public function setOpeningHours(string $openingHours): void
    {
        $this->openingHours = $openingHours;
    }

    /**
     * Returns the notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Sets the notes
     *
     * @return void
     */
    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    /**
     * Returns the readingTimes
     *
     * @return string
     */
    public function getReadingTimes()
    {
        return $this->readingTimes;
    }

    /**
     * Sets the readingTimes
     *
     * @return void
     */
    public function setReadingTimes(string $readingTimes): void
    {
        $this->readingTimes = $readingTimes;
    }

    /**
     * Returns the vpLanguages
     *
     * @return string
     */
    public function getVpLanguages()
    {
        return explode(',', $this->vpLanguages);
    }

    /**
     * Sets the vpLanguages
     *
     * @param array $vpLanguages
     * @return void
     */
    public function setVpLanguages(array $vpLanguages): void
    {
        $this->vpLanguages = implode(',', $vpLanguages);
    }

    /**
     * Returns the vpNumber
     *
     * @return int
     */
    public function getVpNumber()
    {
        return $this->vpNumber;
    }

    /**
     * Sets the vpNumber
     *
     * @return void
     */
    public function setVpNumber(int $vpNumber): void
    {
        $this->vpNumber = $vpNumber;
    }

    /**
     * Returns the contactPerson
     *
     * @return Person|null
     */
    public function getContactPerson(): ?Person
    {
        if ($this->contactPerson instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $this->contactPerson->_loadRealInstance();
        }
        return $this->contactPerson;
    }

    /**
     * Sets the contactPerson
     *
     * @param Person|null $contactPerson
     * @return void
     */
    public function setContactPerson(?Person $contactPerson): void
    {
        $this->contactPerson = $contactPerson;
    }

    /**
     * Adds a vlpaten
     *
     * @return void
     */
    public function addVlpaten(Person $vlpaten): void
    {
        $this->vlpaten->attach($vlpaten);
    }

    /**
     * Removes a vlpaten
     *
     * @param Person $vlpatenToRemove The vlpaten to be removed
     * @return void
     */
    public function removeVlpaten(Person $vlpatenToRemove): void
    {
        $this->vlpaten->detach($vlpatenToRemove);
    }

    /**
     * Returns the vlpaten
     *
     * @return ObjectStorage<Person>
     */
    public function getVlpaten()
    {
        return $this->vlpaten;
    }

    /**
     * Sets the vlpaten
     *
     * @param ObjectStorage<Person> $vlpaten
     * @return void
     */
    public function setVlpaten(ObjectStorage $vlpaten): void
    {
        $this->vlpaten = $vlpaten;
    }
}
