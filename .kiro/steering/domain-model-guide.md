# Leseohren Domain Model Guide

## Core Domain Entities

### Person (Volunteer)
The central entity representing volunteers in the system.

**Key Properties:**
- Personal info: `firstname`, `lastname`, `title`, `job`, `birthday`
- Contact: `email`, `phone_landline`, `phone_mobile`, `street1`, `street2`, `zip`, `city`
- Status: `status` (0=active, 1=paused, 2=retired), `statuschange_date`
- Documents: `file_fuehrungszeugnis`, `fuehrungszeugnis_date`, `file_mandat`
- Preferences: `languages`, `preference_agegroup`, `preference_organization_type`
- Membership: `membership_type`, `membership_fee`, `payment_method`, `iban`

**Status Constants:**
```php
public const STATUS_ACTIVE = 0;
public const STATUS_PAUSED = 1;
public const STATUS_RETIRED = 2;
```

**Key Business Rules:**
- Criminal background check (Führungszeugnis) expires after 5 years
- Status changes should be tracked with dates
- Email addresses must be unique and valid
- Active volunteers can register for events

### Organization
Represents institutions where volunteers provide reading services.

**Key Properties:**
- Basic info: `name`, `street1`, `street2`, `zip`, `city`, `district`
- Contact: `phone1`, `phone2`, `email`, `url`, `whatsapp`
- Operations: `opening_hours`, `reading_times`, `lastcontact`
- Relationships: `contact_person`, `vlpaten` (volunteer mentors)

**Business Rules:**
- Each organization should have at least one contact person
- Multiple volunteers can be assigned to one organization
- Track last contact date for relationship management

### Event
Represents training sessions, meetings, and volunteer activities.

**Key Properties:**
- Basic info: `title`, `description`, `start_date`, `end_date`, `location`
- Capacity: `maxparticipants`
- Management: `reminder_sent`, `speaker` (volunteers who present)

**Business Rules:**
- Events can have multiple speakers (volunteers)
- Registration is limited by `maxparticipants`
- Waitlist functionality when events are full
- Automated reminders can be sent

### Registration
Links volunteers to events they're registered for.

**Key Properties:**
- `person` (volunteer), `event`
- `registration_date`, `onwaitlist`

**Business Rules:**
- One registration per person per event
- Waitlist management when events are full
- Registration date tracking for analytics

### Gift & Present
Gift catalog and tracking system for volunteer recognition.

**Gift (Catalog):**
- `title`, `description`

**Present (Given Gifts):**
- `gift` (reference to catalog), `person` (recipients)
- `gift_date`, `given` (delivery status)

**Business Rules:**
- Track what gifts are available vs. what's been given
- Multiple people can receive the same gift
- Track delivery status and dates

### Blackboard
Internal communication and announcement system.

**Key Properties:**
- `title`, `description`
- `start_date`, `end_date` (visibility period)
- `person` (targeted recipients)

**Business Rules:**
- Announcements can be targeted to specific volunteers
- Time-limited visibility with start/end dates
- Support for rich text descriptions

### Category
Hierarchical classification system for flexible organization.

**Key Properties:**
- `title`, `description`
- `parent` (for hierarchy)

**Business Rules:**
- Support parent-child relationships
- Can be applied to persons, organizations, events
- Used for filtering and organization

## Relationships

### Many-to-Many Relationships
- **Person ↔ Organization**: Volunteers can work with multiple organizations
- **Person ↔ Event**: Volunteers can register for multiple events
- **Person ↔ Category**: Volunteers can have multiple categories
- **Event ↔ Category**: Events can have multiple categories

### One-to-Many Relationships
- **Person → Registration**: One person can have many event registrations
- **Event → Registration**: One event can have many registrations
- **Gift → Present**: One gift type can be given multiple times
- **Category → Category**: Parent-child category relationships

### File Relationships
- **Person → FileReference**: For documents (Führungszeugnis, Mandat, others)
- Use TYPO3 FAL (File Abstraction Layer) for file management

## Data Validation Rules

### Person Validation
```php
// Required fields
#[Validate(['validator' => 'NotEmpty'])]
protected $lastname = '';

// Email validation
#[Validate(['validator' => 'EmailAddress'])]
protected $email = '';

// Date validation
#[Validate(['validator' => 'DateTime'])]
protected $birthday = null;
```

### Business Logic Validation
- Führungszeugnis expiry: 5 years from issue date
- Status transitions: Active → Paused → Retired (with proper dates)
- Event capacity: Cannot exceed `maxparticipants`
- Email uniqueness: Prevent duplicate email addresses

## Repository Patterns

### Common Query Methods
```php
// Find by status
public function findByStatus(int $status): QueryResultInterface

// Find by category
public function findByCategory(Category $category): QueryResultInterface

// Find by date range
public function findByDateRange(\DateTime $start, \DateTime $end): QueryResultInterface
```

### Person-Specific Queries
```php
// Dashboard functionality
public function upcomingBirthdays(int $days = 7): QueryResultInterface
public function upcomingStatusChange(int $days = 7): QueryResultInterface
public function expiredFuehrungszeugnis(int $days = 14): QueryResultInterface
```

### Event-Specific Queries
```php
public function findUpcomingEvents(): QueryResultInterface
public function findEventsBySpeaker(Person $speaker): QueryResultInterface
public function findAvailableEvents(): QueryResultInterface // Not full
```

## Model Methods

### Person Model Helper Methods
```php
public function getFullname(): string
public function getAge(): ?int
public function isActive(): bool
public function isFuehrungszeugnisExpired(): bool
public function canRegisterForEvents(): bool
```

### Event Model Helper Methods
```php
public function isFull(): bool
public function getAvailableSpots(): int
public function isUpcoming(): bool
public function hasWaitlist(): bool
```

## Data Migration Considerations

### Legacy Data Import
- Handle data from older systems
- Validate and clean imported data
- Map old field names to new structure
- Preserve historical data integrity

### Data Transformation
- Convert date formats appropriately
- Handle character encoding issues
- Normalize phone number formats
- Validate email addresses during import

## Performance Considerations

### Lazy Loading
- Use lazy loading for file references
- Implement lazy loading for large collections
- Optimize query performance with proper indexing

### Caching Strategy
- Cache frequently accessed data
- Use TYPO3 caching framework
- Implement cache invalidation on updates

### Database Optimization
- Index frequently queried fields (email, status, dates)
- Use compound indexes for complex queries
- Monitor query performance and optimize as needed