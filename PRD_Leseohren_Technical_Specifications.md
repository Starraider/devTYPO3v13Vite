# Leseohren Technical Specifications - Product Requirements Document (PRD)

## 1. Technical Architecture Overview

### 1.1 System Architecture
The Leseohren system is built as a TYPO3 extension following the MVC (Model-View-Controller) pattern with Extbase framework integration.

### 1.2 Technology Stack Details
- **PHP Version**: 8.3+ with strict typing enabled
- **TYPO3 Version**: Latest LTS (v12+)
- **Database**: MySQL 8.0+ / MariaDB 10.5+
- **Frontend Framework**: Bootstrap 5.x
- **Build System**: Vite 4.x
- **CSS Preprocessor**: SCSS
- **JavaScript**: ES6+ with module support
- **Template Engine**: Fluid (TYPO3's templating system)

## 2. Database Schema Design

### 2.1 Core Tables

#### 2.1.1 Person Table (tx_leseohren_domain_model_person)
```sql
-- Core personal information
uid, pid, tstamp, crdate, cruser_id, deleted, hidden, starttime, endtime
gender (int) -- 0=female, 1=male, 2=diverse
firstname (varchar)
lastname (varchar) -- NOT NULL
title (varchar)
job (varchar)
birthday (datetime)

-- Contact information
street1, street2 (varchar)
zip, city, district (varchar)
phone_landline, phone_mobile (varchar)
email (varchar)
whatsapp (varchar)

-- Volunteer-specific fields
awareness (int)
notes (text)
status (int) -- 0=active, 1=paused, 2=retired
statuschange_date, statusbegin_date, statusend_date (datetime)
travel_options (int)
languages (text) -- JSON array
preference_agegroup (text) -- JSON array
preference_organization_type (text) -- JSON array

-- Membership information
membership_type (int)
membership_fee (varchar)
payment_method (int)
mandatsreferenz (varchar)
iban, swift, account_owner, bankname (varchar)
paypal (varchar)
memberorg (varchar)

-- Document management
file_fuehrungszeugnis (int) -- File reference
fuehrungszeugnis_checked (bool)
fuehrungszeugnis_date (datetime)
file_mandat, file_others (int) -- File references

-- Relationships
categories (text) -- JSON array of category UIDs
```

#### 2.1.2 Organization Table (tx_leseohren_domain_model_organization)
```sql
-- Core organization information
uid, pid, tstamp, crdate, cruser_id, deleted, hidden, starttime, endtime
name (varchar) -- NOT NULL

-- Contact information
street1, street2 (varchar)
zip, city, district (varchar)
phone1, phone2 (varchar)
email (varchar)
url (varchar)
whatsapp (varchar)

-- Organization-specific fields
lastcontact (datetime)
opening_hours (text)
notes (text)
reading_times (text)
vp_languages (text)
vp_number (int)

-- Relationships
contact_person (int) -- Person UID
vlpaten (text) -- JSON array of Person UIDs
categories (text) -- JSON array of category UIDs
```

#### 2.1.3 Event Table (tx_leseohren_domain_model_event)
```sql
-- Core event information
uid, pid, tstamp, crdate, cruser_id, deleted, hidden, starttime, endtime
title (varchar) -- NOT NULL
description (text)
start_date, end_date (datetime)
location (varchar)
maxparticipants (int)
reminder_sent (varchar) -- NOT NULL

-- Relationships
speaker (text) -- JSON array of Person UIDs
categories (text) -- JSON array of category UIDs
```

#### 2.1.4 Registration Table (tx_leseohren_domain_model_registration)
```sql
-- Registration information
uid, pid, tstamp, crdate, cruser_id, deleted, hidden, starttime, endtime
registration_date (datetime) -- NOT NULL
onwaitlist (bool)

-- Relationships
person (int) -- Person UID
event (int) -- Event UID
```

#### 2.1.5 Gift Table (tx_leseohren_domain_model_gift)
```sql
-- Gift catalog
uid, pid, tstamp, crdate, cruser_id, deleted, hidden, starttime, endtime
title (varchar) -- NOT NULL
description (text)
```

#### 2.1.6 Present Table (tx_leseohren_domain_model_present)
```sql
-- Gift tracking
uid, pid, tstamp, crdate, cruser_id, deleted, hidden, starttime, endtime
gift_date (datetime) -- NOT NULL
given (bool)

-- Relationships
person (text) -- JSON array of Person UIDs
gift (int) -- Gift UID
```

#### 2.1.7 Blackboard Table (tx_leseohren_domain_model_blackboard)
```sql
-- Announcement board
uid, pid, tstamp, crdate, cruser_id, deleted, hidden, starttime, endtime
title (varchar) -- NOT NULL
description (text)
start_date, end_date (datetime)

-- Relationships
person (text) -- JSON array of Person UIDs
```

#### 2.1.8 Category Table (tx_leseohren_domain_model_category)
```sql
-- Hierarchical categories
uid, pid, tstamp, crdate, cruser_id, deleted, hidden, starttime, endtime
title (varchar) -- NOT NULL
description (text)
parent (int) -- Parent category UID
```

#### 2.1.9 Easterdate Table (tx_leseohren_domain_model_easterdate)
```sql
-- Easter date tracking
uid, pid, tstamp, crdate, cruser_id, deleted, hidden, starttime, endtime
easterdate (datetime) -- NOT NULL
```

## 3. Domain Model Specifications

### 3.1 Person Model
```php
class Person extends AbstractEntity
{
    // Core properties
    protected $gender = 0;
    protected $firstname = '';
    protected $lastname = '';
    protected $title = '';
    protected $job = '';
    protected $birthday = null;

    // Contact information
    protected $street1 = '';
    protected $street2 = '';
    protected $zip = '';
    protected $city = '';
    protected $district = '';
    protected $phoneLandline = '';
    protected $phoneMobile = '';
    protected $email = '';
    protected $whatsapp = '';

    // Volunteer-specific properties
    protected $awareness = 0;
    protected $notes = '';
    protected $status = 0;
    protected $statuschangeDate = null;
    protected $statusbeginDate = null;
    protected $statusendDate = null;
    protected $travelOptions = 0;
    protected $languages = [];
    protected $preferenceAgegroup = [];
    protected $preferenceOrganizationType = [];

    // Membership properties
    protected $membershipType = 0;
    protected $membershipFee = '';
    protected $paymentMethod = 0;
    protected $mandatsreferenz = '';
    protected $iban = '';
    protected $swift = '';
    protected $accountOwner = '';
    protected $bankname = '';
    protected $paypal = '';
    protected $memberorg = '';

    // Document properties
    protected $fileFuehrungszeugnis = null;
    protected $fuehrungszeugnisChecked = false;
    protected $fuehrungszeugnisDate = null;
    protected $fileMandat = null;
    protected $fileOthers = null;

    // Relationships
    public $categories;
    public $donations;
    public $registrations;
    public $blackboards;
    public $organizations;
}
```

### 3.2 Event Model
```php
class Event extends AbstractEntity
{
    protected $title = '';
    protected $description = '';
    protected $startDate = null;
    protected $endDate = null;
    protected $location = '';
    protected $maxparticipants = 0;
    protected $reminderSent = '';

    // Relationships
    public $categories;
    protected $speaker = null;
}
```

## 4. Controller Specifications

### 4.1 Base Controller Structure
All controllers extend `TYPO3\CMS\Extbase\Mvc\Controller\ActionController` and implement:

- **Dependency Injection**: Constructor-based dependency injection
- **Response Handling**: Return `ResponseInterface` objects
- **Validation**: Use TYPO3 validation annotations
- **Error Handling**: Proper exception handling and logging

### 4.2 Controller Methods

#### 4.2.1 PersonController
```php
class PersonController extends ActionController
{
    // CRUD operations
    public function indexAction(): ResponseInterface
    public function showAction(Person $person): ResponseInterface
    public function newAction(): ResponseInterface
    public function createAction(Person $newPerson): ResponseInterface
    public function editAction(Person $person): ResponseInterface
    public function updateAction(Person $person): ResponseInterface
    public function deleteAction(Person $person): ResponseInterface

    // Custom actions
    public function listAction(): ResponseInterface
    public function searchAction(): ResponseInterface
}
```

#### 4.2.2 PersonDashboardController
```php
class PersonDashboardController extends ActionController
{
    public function birthdaysAction(): ResponseInterface
    public function statuschangeAction(): ResponseInterface
}
```

#### 4.2.3 HolidayController
```php
class HolidayController extends ActionController
{
    public function indexAction(): ResponseInterface
}
```

## 5. Repository Specifications

### 5.1 Base Repository Structure
All repositories extend `TYPO3\CMS\Extbase\Persistence\Repository` and implement:

- **Query Builder**: Use Doctrine QueryBuilder for complex queries
- **Custom Methods**: Implement business-specific query methods
- **Caching**: Implement appropriate caching strategies
- **Performance**: Optimize queries for large datasets

### 5.2 Custom Repository Methods

#### 5.2.1 PersonRepository
```php
class PersonRepository extends Repository
{
    public function upcomingBirthdays(int $days = 7): QueryResultInterface
    public function upcomingStatusChange(int $days = 7): QueryResultInterface
    public function expiredFuehrungszeugnis(int $days = 14): QueryResultInterface
    public function findByCategory(Category $category): QueryResultInterface
    public function findByStatus(int $status): QueryResultInterface
}
```

#### 5.2.2 EventRepository
```php
class EventRepository extends Repository
{
    public function findUpcomingEvents(): QueryResultInterface
    public function findEventsBySpeaker(Person $speaker): QueryResultInterface
    public function findEventsByDateRange(\DateTime $start, \DateTime $end): QueryResultInterface
}
```

## 6. Frontend Specifications

### 6.1 Template Structure
```
Resources/Private/Templates/
├── Person/
│   ├── Index.html
│   ├── List.html
│   ├── Show.html
│   ├── Edit.html
│   └── New.html
├── Event/
├── Organization/
├── Registration/
├── Gift/
├── Present/
├── Blackboard/
└── Main.html
```

### 6.2 Partial Templates
```
Resources/Private/Partials/
├── Person/
│   ├── FormFields.html
│   ├── Properties.html
│   ├── AddressCard.html
│   └── AccordionRight.html
├── Event/
├── Organization/
└── FormErrors.html
```

### 6.3 Layout Templates
```
Resources/Private/Layouts/
└── Default.html
```

### 6.4 Fluid Template Features
- **ViewHelpers**: Custom ViewHelpers for business logic
- **Form Handling**: TYPO3 form handling with validation
- **Pagination**: DataTables integration for large datasets
- **Responsive Design**: Bootstrap-based responsive layouts

## 7. Asset Management

### 7.1 SCSS Structure
```
Resources/Private/Scss/
├── abstracts/
│   ├── _variables.scss
│   ├── _css-vars.scss
│   └── _bem-mixin.scss
├── base/
│   └── _typography.scss
├── components/
│   ├── _buttons.scss
│   └── _modals.scss
├── layout/
│   └── _container.scss
├── plugins/
│   └── leseohren/
│       ├── _leseohren-personen.scss
│       ├── _leseohren-events.scss
│       └── _leseohren-blackboards.scss
└── Main.entry.scss
```

### 7.2 JavaScript Structure
```
Resources/Private/
├── DataTables.entry.js
├── Datepicker.entry.js
└── ext.leseohren.entry.js
```

### 7.3 Vite Configuration
```javascript
// vite.config.js
export default {
  build: {
    rollupOptions: {
      input: {
        'ext.leseohren': 'packages/leseohren/Resources/Private/ext.leseohren.entry.js',
        'DataTables': 'packages/leseohren/Resources/Private/DataTables.entry.js',
        'Datepicker': 'packages/leseohren/Resources/Private/Datepicker.entry.js'
      }
    }
  }
}
```

## 8. Configuration Specifications

### 8.1 TypoScript Configuration
```typoscript
# Configuration/TypoScript/setup.typoscript
plugin.tx_leseohren {
    view {
        templateRootPaths {
            0 = EXT:leseohren/Resources/Private/Templates/
        }
        partialRootPaths {
            0 = EXT:leseohren/Resources/Private/Partials/
        }
        layoutRootPaths {
            0 = EXT:leseohren/Resources/Private/Layouts/
        }
    }

    persistence {
        storagePid = {$plugin.tx_leseohren.persistence.storagePid}
    }

    features {
        skipDefaultArguments = 1
    }

    mvc {
        callDefaultActionIfActionCantBeResolved = 1
    }
}
```

### 8.2 TCA Configuration
```php
// Configuration/TCA/tx_leseohren_domain_model_person.php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person',
        'label' => 'lastname',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'firstname,lastname,email',
        'iconfile' => 'EXT:leseohren/Resources/Public/Icons/tx_leseohren_domain_model_person.svg'
    ],
    'types' => [
        '1' => ['showitem' => '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_ttc.xlf:palette.general;general,firstname,lastname,email'],
    ],
    'palettes' => [
        'general' => ['showitem' => ''],
    ],
    'columns' => [
        'firstname' => [
            'exclude' => true,
            'label' => 'LLL:EXT:leseohren/Resources/Private/Language/locallang_db.xlf:tx_leseohren_domain_model_person.firstname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        // ... additional fields
    ],
];
```

## 9. Security Specifications

### 9.1 Input Validation
- **Server-side Validation**: All inputs validated using TYPO3 validation framework
- **SQL Injection Prevention**: Use prepared statements and QueryBuilder
- **XSS Prevention**: Output encoding in templates
- **CSRF Protection**: TYPO3 built-in CSRF protection

### 9.2 Access Control
- **Backend Access**: TYPO3 backend user permissions
- **Frontend Access**: Role-based access control
- **File Upload Security**: Restricted file types and sizes
- **Data Privacy**: GDPR-compliant data handling

## 10. Performance Specifications

### 10.1 Database Optimization
- **Indexing**: Proper database indexes on frequently queried fields
- **Query Optimization**: Efficient queries with minimal joins
- **Caching**: TYPO3 caching framework integration
- **Pagination**: DataTables pagination for large datasets

### 10.2 Frontend Performance
- **Asset Optimization**: Minified CSS and JavaScript
- **Image Optimization**: Optimized images and icons
- **Lazy Loading**: Implement lazy loading for large datasets
- **CDN Integration**: Support for CDN asset delivery

## 11. Testing Specifications

### 11.1 Unit Testing
- **PHPUnit**: Unit tests for all domain models
- **Test Coverage**: Minimum 80% code coverage
- **Mock Objects**: Use mock objects for external dependencies
- **Test Data**: Comprehensive test data sets

### 11.2 Functional Testing
- **TYPO3 Testing Framework**: Integration with TYPO3 testing
- **Browser Testing**: Automated browser testing
- **Performance Testing**: Load testing for critical paths

## 12. Deployment Specifications

### 12.1 Environment Configuration
```yaml
# config/sites/main/config.yaml
base: 'https://example.com/'
baseVariants: []
errorHandling: []
languages:
  -
    title: 'Deutsch'
    enabled: true
    languageId: 0
    base: '/'
    fallbackType: strict
    fallbacks: ''
    fallbackLanguageIds: ''
    typo3Language: default
    locale: de_DE.UTF-8
    iso-639-1: de
    navigationTitle: ''
    hreflang: ''
    direction: ''
    flag: de-DE
    browserLanguageRedirect: true
```

### 12.2 Build Process
```json
// package.json
{
  "scripts": {
    "build": "vite build",
    "dev": "vite",
    "watch": "vite build --watch"
  }
}
```

---

**Document Version**: 1.0
**Last Updated**: December 2024
**Author**: Sven Kalbhenn (sven@skom.de)
**Project**: Leseohren Technical Specifications
