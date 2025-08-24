# Leseohren Database Schema Guide

## Database Design Principles

### TYPO3 Standards
- Follow TYPO3 table naming conventions: `tx_extensionkey_domain_model_entityname`
- Include standard TYPO3 fields: `uid`, `pid`, `tstamp`, `crdate`, `cruser_id`, `deleted`, `hidden`
- Use proper field types and constraints
- Implement soft delete with `deleted` field
- Support versioning and workspaces where needed

### Data Integrity
- Use foreign key relationships where appropriate
- Implement proper indexing for performance
- Use NOT NULL constraints for required fields
- Validate data at database level where possible

## Core Tables

### Person Table (tx_leseohren_domain_model_person)

```sql
CREATE TABLE tx_leseohren_domain_model_person (
    -- TYPO3 Standard Fields
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,
    
    -- Personal Information
    gender int(11) DEFAULT '0' NOT NULL,
    firstname varchar(255) DEFAULT '' NOT NULL,
    lastname varchar(255) DEFAULT '' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,
    job varchar(255) DEFAULT '' NOT NULL,
    birthday int(11) unsigned DEFAULT '0' NOT NULL,
    
    -- Contact Information
    street1 varchar(255) DEFAULT '' NOT NULL,
    street2 varchar(255) DEFAULT '' NOT NULL,
    zip varchar(20) DEFAULT '' NOT NULL,
    city varchar(255) DEFAULT '' NOT NULL,
    district varchar(255) DEFAULT '' NOT NULL,
    phone_landline varchar(50) DEFAULT '' NOT NULL,
    phone_mobile varchar(50) DEFAULT '' NOT NULL,
    email varchar(255) DEFAULT '' NOT NULL,
    whatsapp varchar(50) DEFAULT '' NOT NULL,
    
    -- Volunteer Information
    awareness int(11) DEFAULT '0' NOT NULL,
    notes text,
    status int(11) DEFAULT '0' NOT NULL,
    statuschange_date int(11) unsigned DEFAULT '0' NOT NULL,
    statusbegin_date int(11) unsigned DEFAULT '0' NOT NULL,
    statusend_date int(11) unsigned DEFAULT '0' NOT NULL,
    travel_options int(11) DEFAULT '0' NOT NULL,
    languages text,
    preference_agegroup text,
    preference_organization_type text,
    
    -- Membership Information
    membership_type int(11) DEFAULT '0' NOT NULL,
    membership_fee varchar(255) DEFAULT '' NOT NULL,
    payment_method int(11) DEFAULT '0' NOT NULL,
    mandatsreferenz varchar(255) DEFAULT '' NOT NULL,
    iban varchar(34) DEFAULT '' NOT NULL,
    swift varchar(11) DEFAULT '' NOT NULL,
    account_owner varchar(255) DEFAULT '' NOT NULL,
    bankname varchar(255) DEFAULT '' NOT NULL,
    paypal varchar(255) DEFAULT '' NOT NULL,
    memberorg varchar(255) DEFAULT '' NOT NULL,
    
    -- Document Management
    file_fuehrungszeugnis int(11) unsigned DEFAULT '0' NOT NULL,
    fuehrungszeugnis_checked tinyint(4) unsigned DEFAULT '0' NOT NULL,
    fuehrungszeugnis_date int(11) unsigned DEFAULT '0' NOT NULL,
    file_mandat int(11) unsigned DEFAULT '0' NOT NULL,
    file_others int(11) unsigned DEFAULT '0' NOT NULL,
    
    -- Relationships (stored as comma-separated UIDs or JSON)
    categories text,
    
    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY email (email),
    KEY status (status),
    KEY lastname (lastname),
    KEY birthday (birthday),
    KEY fuehrungszeugnis_date (fuehrungszeugnis_date),
    KEY statuschange_date (statuschange_date)
);
```

**Field Descriptions:**
- `gender`: 0=female, 1=male, 2=diverse
- `status`: 0=active, 1=paused, 2=retired
- `languages`: JSON array of language codes
- `preference_agegroup`: JSON array of age group preferences
- `preference_organization_type`: JSON array of organization type preferences
- `categories`: JSON array of category UIDs

### Organization Table (tx_leseohren_domain_model_organization)

```sql
CREATE TABLE tx_leseohren_domain_model_organization (
    -- TYPO3 Standard Fields
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,
    
    -- Organization Information
    name varchar(255) DEFAULT '' NOT NULL,
    street1 varchar(255) DEFAULT '' NOT NULL,
    street2 varchar(255) DEFAULT '' NOT NULL,
    zip varchar(20) DEFAULT '' NOT NULL,
    city varchar(255) DEFAULT '' NOT NULL,
    district varchar(255) DEFAULT '' NOT NULL,
    phone1 varchar(50) DEFAULT '' NOT NULL,
    phone2 varchar(50) DEFAULT '' NOT NULL,
    email varchar(255) DEFAULT '' NOT NULL,
    url varchar(255) DEFAULT '' NOT NULL,
    whatsapp varchar(50) DEFAULT '' NOT NULL,
    
    -- Operational Information
    lastcontact int(11) unsigned DEFAULT '0' NOT NULL,
    opening_hours text,
    notes text,
    reading_times text,
    vp_languages text,
    vp_number int(11) DEFAULT '0' NOT NULL,
    
    -- Relationships
    contact_person int(11) unsigned DEFAULT '0' NOT NULL,
    vlpaten text, -- JSON array of Person UIDs
    categories text, -- JSON array of Category UIDs
    
    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY name (name),
    KEY city (city),
    KEY district (district),
    KEY lastcontact (lastcontact),
    KEY contact_person (contact_person)
);
```

### Event Table (tx_leseohren_domain_model_event)

```sql
CREATE TABLE tx_leseohren_domain_model_event (
    -- TYPO3 Standard Fields
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,
    
    -- Event Information
    title varchar(255) DEFAULT '' NOT NULL,
    description text,
    start_date int(11) unsigned DEFAULT '0' NOT NULL,
    end_date int(11) unsigned DEFAULT '0' NOT NULL,
    location varchar(255) DEFAULT '' NOT NULL,
    maxparticipants int(11) DEFAULT '0' NOT NULL,
    reminder_sent varchar(255) DEFAULT '' NOT NULL,
    
    -- Relationships
    speaker text, -- JSON array of Person UIDs
    categories text, -- JSON array of Category UIDs
    
    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY title (title),
    KEY start_date (start_date),
    KEY end_date (end_date)
);
```

### Registration Table (tx_leseohren_domain_model_registration)

```sql
CREATE TABLE tx_leseohren_domain_model_registration (
    -- TYPO3 Standard Fields
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,
    
    -- Registration Information
    registration_date int(11) unsigned DEFAULT '0' NOT NULL,
    onwaitlist tinyint(4) unsigned DEFAULT '0' NOT NULL,
    
    -- Relationships
    person int(11) unsigned DEFAULT '0' NOT NULL,
    event int(11) unsigned DEFAULT '0' NOT NULL,
    
    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY person (person),
    KEY event (event),
    KEY registration_date (registration_date),
    UNIQUE KEY person_event (person, event)
);
```

### Gift Table (tx_leseohren_domain_model_gift)

```sql
CREATE TABLE tx_leseohren_domain_model_gift (
    -- TYPO3 Standard Fields
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,
    
    -- Gift Information
    title varchar(255) DEFAULT '' NOT NULL,
    description text,
    
    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY title (title)
);
```

### Present Table (tx_leseohren_domain_model_present)

```sql
CREATE TABLE tx_leseohren_domain_model_present (
    -- TYPO3 Standard Fields
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,
    
    -- Present Information
    gift_date int(11) unsigned DEFAULT '0' NOT NULL,
    given tinyint(4) unsigned DEFAULT '0' NOT NULL,
    
    -- Relationships
    person text, -- JSON array of Person UIDs
    gift int(11) unsigned DEFAULT '0' NOT NULL,
    
    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY gift_date (gift_date),
    KEY gift (gift),
    KEY given (given)
);
```

### Blackboard Table (tx_leseohren_domain_model_blackboard)

```sql
CREATE TABLE tx_leseohren_domain_model_blackboard (
    -- TYPO3 Standard Fields
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,
    
    -- Blackboard Information
    title varchar(255) DEFAULT '' NOT NULL,
    description text,
    start_date int(11) unsigned DEFAULT '0' NOT NULL,
    end_date int(11) unsigned DEFAULT '0' NOT NULL,
    
    -- Relationships
    person text, -- JSON array of Person UIDs
    
    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY title (title),
    KEY start_date (start_date),
    KEY end_date (end_date)
);
```

### Category Table (tx_leseohren_domain_model_category)

```sql
CREATE TABLE tx_leseohren_domain_model_category (
    -- TYPO3 Standard Fields
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,
    sorting int(11) unsigned DEFAULT '0' NOT NULL,
    
    -- Category Information
    title varchar(255) DEFAULT '' NOT NULL,
    description text,
    parent int(11) unsigned DEFAULT '0' NOT NULL,
    
    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY title (title),
    KEY parent_category (parent),
    KEY sorting (sorting)
);
```

### Easter Date Table (tx_leseohren_domain_model_easterdate)

```sql
CREATE TABLE tx_leseohren_domain_model_easterdate (
    -- TYPO3 Standard Fields
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    starttime int(11) unsigned DEFAULT '0' NOT NULL,
    endtime int(11) unsigned DEFAULT '0' NOT NULL,
    
    -- Easter Date Information
    easterdate int(11) unsigned DEFAULT '0' NOT NULL,
    
    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY easterdate (easterdate)
);
```

## Relationship Tables

### Many-to-Many Relationships
For complex many-to-many relationships, TYPO3 uses intermediate tables:

```sql
-- Person-Organization Relationship
CREATE TABLE tx_leseohren_person_organization_mm (
    uid_local int(11) unsigned DEFAULT '0' NOT NULL,
    uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
    sorting int(11) unsigned DEFAULT '0' NOT NULL,
    sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
    
    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);
```

## Indexes and Performance

### Primary Indexes
- All tables have primary key on `uid`
- Parent page index on `pid`
- Soft delete support with `deleted` field

### Business Logic Indexes
```sql
-- Person table indexes
ALTER TABLE tx_leseohren_domain_model_person 
ADD INDEX idx_email (email),
ADD INDEX idx_status (status),
ADD INDEX idx_lastname_firstname (lastname, firstname),
ADD INDEX idx_birthday (birthday),
ADD INDEX idx_fuehrungszeugnis_date (fuehrungszeugnis_date),
ADD INDEX idx_statuschange_date (statuschange_date);

-- Organization table indexes
ALTER TABLE tx_leseohren_domain_model_organization
ADD INDEX idx_name (name),
ADD INDEX idx_city_district (city, district),
ADD INDEX idx_lastcontact (lastcontact);

-- Event table indexes
ALTER TABLE tx_leseohren_domain_model_event
ADD INDEX idx_title (title),
ADD INDEX idx_start_date (start_date),
ADD INDEX idx_end_date (end_date),
ADD INDEX idx_date_range (start_date, end_date);

-- Registration table indexes
ALTER TABLE tx_leseohren_domain_model_registration
ADD INDEX idx_person (person),
ADD INDEX idx_event (event),
ADD INDEX idx_registration_date (registration_date),
ADD UNIQUE INDEX idx_person_event (person, event);
```

### Composite Indexes
For complex queries, create composite indexes:
```sql
-- For dashboard queries
ALTER TABLE tx_leseohren_domain_model_person
ADD INDEX idx_status_birthday (status, birthday),
ADD INDEX idx_status_fuehrungszeugnis (status, fuehrungszeugnis_date);

-- For event management
ALTER TABLE tx_leseohren_domain_model_event
ADD INDEX idx_date_maxparticipants (start_date, maxparticipants);
```

## Data Types and Constraints

### Date Handling
TYPO3 uses Unix timestamps (int) for dates:
```sql
birthday int(11) unsigned DEFAULT '0' NOT NULL,
start_date int(11) unsigned DEFAULT '0' NOT NULL,
```

### Text Fields
- `varchar(255)` for short text fields
- `text` for longer content
- `mediumtext` or `longtext` for very long content

### Boolean Fields
Use `tinyint(4) unsigned` for boolean values:
```sql
hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
given tinyint(4) unsigned DEFAULT '0' NOT NULL,
```

### JSON Fields
Store arrays as JSON in text fields:
```sql
languages text, -- JSON: ["de", "en", "fr"]
categories text, -- JSON: [1, 5, 12]
```

## Migration Scripts

### Initial Schema Creation
```sql
-- ext_tables.sql
CREATE TABLE tx_leseohren_domain_model_person (
    -- Full table definition here
);

-- Add indexes
CREATE INDEX idx_email ON tx_leseohren_domain_model_person (email);
CREATE INDEX idx_status ON tx_leseohren_domain_model_person (status);
```

### Schema Updates
```php
// Classes/Updates/DatabaseSchemaUpdate.php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Updates;

use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

class DatabaseSchemaUpdate implements UpgradeWizardInterface
{
    public function getIdentifier(): string
    {
        return 'leseohrenDatabaseSchemaUpdate';
    }

    public function getTitle(): string
    {
        return 'Update Leseohren database schema';
    }

    public function executeUpdate(): bool
    {
        // Add new fields, indexes, etc.
        return true;
    }
}
```

## Data Validation

### Database Constraints
```sql
-- Email format validation (MySQL 8.0+)
ALTER TABLE tx_leseohren_domain_model_person
ADD CONSTRAINT chk_email 
CHECK (email = '' OR email REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$');

-- Status validation
ALTER TABLE tx_leseohren_domain_model_person
ADD CONSTRAINT chk_status 
CHECK (status IN (0, 1, 2));

-- Date validation
ALTER TABLE tx_leseohren_domain_model_event
ADD CONSTRAINT chk_event_dates 
CHECK (end_date >= start_date);
```

### Application-Level Validation
Implement validation in domain models and TCA configuration.

## Backup and Maintenance

### Regular Maintenance
```sql
-- Optimize tables
OPTIMIZE TABLE tx_leseohren_domain_model_person;
OPTIMIZE TABLE tx_leseohren_domain_model_organization;
OPTIMIZE TABLE tx_leseohren_domain_model_event;

-- Analyze table statistics
ANALYZE TABLE tx_leseohren_domain_model_person;

-- Check table integrity
CHECK TABLE tx_leseohren_domain_model_person;
```

### Backup Strategy
- Regular full database backups
- Transaction log backups for point-in-time recovery
- Test restore procedures regularly
- Document backup and restore procedures