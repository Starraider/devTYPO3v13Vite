# Leseohren Coding Standards

## PHP Standards

### Code Style
- Follow PSR-12 coding standard
- Use strict typing: `declare(strict_types=1);`
- Use meaningful variable and method names
- Add comprehensive PHPDoc comments for all classes and methods

### Example Class Structure
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * Person Model
 *
 * Represents a volunteer in the Leseohren system.
 */
class Person extends AbstractEntity
{
    /**
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected $lastname = '';

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }
}
```

### Naming Conventions
- **Classes**: PascalCase (e.g., `PersonController`)
- **Methods**: camelCase (e.g., `getFullname()`)
- **Properties**: camelCase (e.g., `$firstName`)
- **Constants**: UPPER_SNAKE_CASE (e.g., `STATUS_ACTIVE`)
- **Database fields**: snake_case (e.g., `first_name`)

### TYPO3 Specific Standards
- Use dependency injection in controllers
- Return `ResponseInterface` from controller actions
- Use TYPO3 validation annotations
- Follow Extbase repository patterns
- Use proper TCA configuration

## Frontend Standards

### HTML/Fluid Templates
- Use semantic HTML5 elements
- Implement proper accessibility attributes (ARIA labels, roles)
- Follow Bootstrap 5 component structure
- Use TYPO3 Fluid ViewHelpers appropriately
- Implement proper form validation and error handling

### SCSS Structure
```scss
// Follow BEM methodology for CSS classes
.person-list {
    &__header {
        display: flex;
        justify-content: space-between;
    }
    
    &__table {
        margin-top: 1rem;
    }
    
    &--loading {
        opacity: 0.5;
    }
}
```

### JavaScript Standards
- Use ES6+ features
- Implement proper error handling
- Use async/await for asynchronous operations
- Follow modular architecture
- Add comprehensive comments for complex logic

## Database Standards

### Table Naming
- Use TYPO3 convention: `tx_extensionkey_domain_model_entityname`
- Example: `tx_leseohren_domain_model_person`

### Field Naming
- Use snake_case for database fields
- Include standard TYPO3 fields: `uid`, `pid`, `tstamp`, `crdate`, `deleted`, `hidden`
- Use descriptive field names (e.g., `fuehrungszeugnis_date` not `fz_date`)

### Relationships
- Use proper TCA relationship configuration
- Implement lazy loading for performance
- Use ObjectStorage for collections

## Security Standards

### Input Validation
- Validate all user inputs server-side
- Use TYPO3 validation framework
- Sanitize output in templates
- Implement proper CSRF protection

### File Handling
- Restrict file upload types and sizes
- Store uploaded files securely
- Validate file contents, not just extensions
- Use TYPO3 FAL (File Abstraction Layer)

### Data Protection
- Implement GDPR-compliant data handling
- Use proper access controls
- Log sensitive operations
- Encrypt sensitive data where appropriate

## Testing Standards

### Unit Tests
- Write tests for all domain models
- Test business logic thoroughly
- Use PHPUnit with TYPO3 testing framework
- Aim for minimum 80% code coverage

### Functional Tests
- Test controller actions
- Test repository methods
- Test form submissions
- Test file uploads

## Documentation Standards

### Code Documentation
- Document all public methods and properties
- Include parameter and return type information
- Add usage examples for complex methods
- Document business rules and constraints

### Inline Comments
- Explain complex business logic
- Document workarounds and technical debt
- Add TODO comments for future improvements
- Explain non-obvious code decisions

## Performance Standards

### Database Optimization
- Use proper indexing on frequently queried fields
- Implement efficient queries with QueryBuilder
- Use lazy loading for relationships
- Implement caching where appropriate

### Frontend Performance
- Minimize CSS and JavaScript files
- Optimize images and assets
- Use lazy loading for large datasets
- Implement proper caching headers

## Error Handling

### Exception Handling
- Use specific exception types
- Log errors appropriately
- Provide user-friendly error messages
- Implement graceful degradation

### Validation Errors
- Show clear validation messages
- Highlight problematic fields
- Preserve user input on errors
- Provide helpful correction suggestions