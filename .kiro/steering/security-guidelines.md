# Leseohren Security Guidelines

## Security Overview

### Security Principles
- **Defense in Depth**: Multiple layers of security controls
- **Least Privilege**: Users and processes have minimum necessary permissions
- **Input Validation**: All input is validated and sanitized
- **Data Protection**: Sensitive data is encrypted and access-controlled
- **GDPR Compliance**: Full compliance with data protection regulations

### Threat Model
- **Data Breaches**: Unauthorized access to volunteer personal data
- **Injection Attacks**: SQL injection, XSS, CSRF attacks
- **File Upload Attacks**: Malicious file uploads
- **Session Hijacking**: Unauthorized session access
- **Privilege Escalation**: Unauthorized access to admin functions

## Input Validation and Sanitization

### Server-Side Validation
Always validate input on the server side using TYPO3's validation framework:

```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;

class Person extends AbstractEntity
{
    #[Validate(['validator' => 'NotEmpty'])]
    #[Validate(['validator' => 'StringLength', 'options' => ['minimum' => 1, 'maximum' => 255]])]
    protected $lastname = '';

    #[Validate(['validator' => 'EmailAddress'])]
    protected $email = '';

    #[Validate(['validator' => 'DateTime'])]
    protected $birthday = null;

    #[Validate(['validator' => 'RegularExpression', 'options' => ['regularExpression' => '/^[+]?[0-9\s\-\(\)]+$/']])]
    protected $phoneMobile = '';
}
```

### Custom Validators
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Validation\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class IbanValidator extends AbstractValidator
{
    protected function isValid($value): void
    {
        if (empty($value)) {
            return;
        }

        // IBAN validation logic
        if (!$this->isValidIban($value)) {
            $this->addError('Invalid IBAN format', 1234567890);
        }
    }

    private function isValidIban(string $iban): bool
    {
        // Remove spaces and convert to uppercase
        $iban = strtoupper(str_replace(' ', '', $iban));
        
        // Basic format check
        if (!preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]+$/', $iban)) {
            return false;
        }
        
        // Length check (varies by country)
        $lengths = [
            'DE' => 22, 'AT' => 20, 'CH' => 21, 'FR' => 27, 'IT' => 27
        ];
        
        $country = substr($iban, 0, 2);
        if (isset($lengths[$country]) && strlen($iban) !== $lengths[$country]) {
            return false;
        }
        
        // Checksum validation (mod 97)
        return $this->validateIbanChecksum($iban);
    }

    private function validateIbanChecksum(string $iban): bool
    {
        // Move first 4 characters to end
        $rearranged = substr($iban, 4) . substr($iban, 0, 4);
        
        // Replace letters with numbers (A=10, B=11, etc.)
        $numeric = '';
        for ($i = 0; $i < strlen($rearranged); $i++) {
            $char = $rearranged[$i];
            if (ctype_alpha($char)) {
                $numeric .= (ord($char) - ord('A') + 10);
            } else {
                $numeric .= $char;
            }
        }
        
        // Calculate mod 97
        return bcmod($numeric, '97') === '1';
    }
}
```

### Output Sanitization
Always escape output in Fluid templates:

```html
<!-- Automatic escaping (default) -->
<p>{person.notes}</p>

<!-- Explicit escaping -->
<p>{person.notes -> f:format.htmlentities()}</p>

<!-- Raw output (only when necessary and safe) -->
<p>{person.description -> f:format.raw()}</p>

<!-- URL encoding -->
<a href="mailto:{person.email -> f:format.urlencode()}">{person.email}</a>
```

## Authentication and Authorization

### TYPO3 Backend Security
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PersonController extends ActionController
{
    public function listAction(): ResponseInterface
    {
        // Check backend user authentication
        $context = GeneralUtility::makeInstance(Context::class);
        if (!$context->getPropertyFromAspect('backend.user', 'isLoggedIn')) {
            throw new \TYPO3\CMS\Core\Error\Http\UnauthorizedActionException();
        }

        // Check specific permissions
        if (!$this->getBackendUser()->check('tables_select', 'tx_leseohren_domain_model_person')) {
            throw new \TYPO3\CMS\Core\Error\Http\ForbiddenException();
        }

        return $this->htmlResponse();
    }

    protected function getBackendUser(): \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
```

### Frontend Access Control
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

class PersonDashboardController extends ActionController
{
    public function initializeAction(): void
    {
        // Check if user is logged in
        if (!$this->request->hasArgument('user') || !$this->isValidUser()) {
            $this->redirect('login', 'Auth');
        }
    }

    private function isValidUser(): bool
    {
        $context = GeneralUtility::makeInstance(Context::class);
        return $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');
    }
}
```

## File Upload Security

### Secure File Upload Configuration
```php
// TCA configuration
'file_fuehrungszeugnis' => [
    'exclude' => true,
    'label' => 'Criminal Background Check',
    'config' => [
        'type' => 'file',
        'allowed' => 'pdf,jpg,jpeg,png', // Restrict file types
        'maxitems' => 1,
        'max_size' => 5000, // 5MB limit
        'appearance' => [
            'createNewRelationLinkTitle' => 'Add file'
        ],
        'behaviour' => [
            'allowLanguageSynchronization' => true
        ],
        'overrideChildTca' => [
            'types' => [
                \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                    'showitem' => '
                        --palette--;;imageoverlayPalette,
                        --palette--;;filePalette'
                ],
                \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                    'showitem' => '
                        --palette--;;filePalette'
                ],
            ],
        ],
    ],
],
```

### File Validation Service
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Service;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FileValidationService
{
    private const ALLOWED_EXTENSIONS = ['pdf', 'jpg', 'jpeg', 'png'];
    private const MAX_FILE_SIZE = 5242880; // 5MB
    private const ALLOWED_MIME_TYPES = [
        'application/pdf',
        'image/jpeg',
        'image/png'
    ];

    public function validateFile(File $file): array
    {
        $errors = [];

        // Check file extension
        if (!in_array(strtolower($file->getExtension()), self::ALLOWED_EXTENSIONS)) {
            $errors[] = 'File type not allowed';
        }

        // Check file size
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            $errors[] = 'File size exceeds limit';
        }

        // Check MIME type
        if (!in_array($file->getMimeType(), self::ALLOWED_MIME_TYPES)) {
            $errors[] = 'Invalid file format';
        }

        // Check for malicious content
        if ($this->containsMaliciousContent($file)) {
            $errors[] = 'File contains suspicious content';
        }

        return $errors;
    }

    private function containsMaliciousContent(File $file): bool
    {
        $content = $file->getContents();
        
        // Check for script tags, PHP code, etc.
        $maliciousPatterns = [
            '/<script[^>]*>.*?<\/script>/is',
            '/<\?php/i',
            '/<%.*?%>/is',
            '/javascript:/i',
            '/vbscript:/i',
            '/onload=/i',
            '/onerror=/i'
        ];

        foreach ($maliciousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }
}
```

## SQL Injection Prevention

### Use QueryBuilder
Always use TYPO3's QueryBuilder for database queries:

```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;

class PersonRepository extends Repository
{
    public function findByEmailSecure(string $email): ?Person
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_leseohren_domain_model_person');

        $result = $queryBuilder
            ->select('*')
            ->from('tx_leseohren_domain_model_person')
            ->where(
                $queryBuilder->expr()->eq('email', $queryBuilder->createNamedParameter($email))
            )
            ->andWhere(
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT))
            )
            ->execute()
            ->fetchAssociative();

        return $result ? $this->mapRowToPerson($result) : null;
    }

    public function findByStatusAndDateRange(int $status, \DateTime $startDate, \DateTime $endDate): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_leseohren_domain_model_person');

        $result = $queryBuilder
            ->select('*')
            ->from('tx_leseohren_domain_model_person')
            ->where(
                $queryBuilder->expr()->eq('status', $queryBuilder->createNamedParameter($status, \PDO::PARAM_INT)),
                $queryBuilder->expr()->gte('birthday', $queryBuilder->createNamedParameter($startDate->getTimestamp(), \PDO::PARAM_INT)),
                $queryBuilder->expr()->lte('birthday', $queryBuilder->createNamedParameter($endDate->getTimestamp(), \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT))
            )
            ->execute()
            ->fetchAllAssociative();

        return array_map([$this, 'mapRowToPerson'], $result);
    }
}
```

## Cross-Site Scripting (XSS) Prevention

### Template Security
```html
<!-- Safe: Automatic HTML encoding -->
<p>Name: {person.firstname} {person.lastname}</p>

<!-- Safe: Explicit HTML encoding -->
<p>Notes: {person.notes -> f:format.htmlentities()}</p>

<!-- Safe: URL encoding for URLs -->
<a href="mailto:{person.email -> f:format.urlencode()}">{person.email}</a>

<!-- Dangerous: Raw output (avoid unless absolutely necessary) -->
<div>{richTextContent -> f:format.raw()}</div>

<!-- Safe: Conditional raw output with validation -->
<f:if condition="{f:security.ifHasRole(role: 'admin')}">
    <div>{adminContent -> f:format.raw()}</div>
</f:if>
```

### Content Security Policy (CSP)
```php
// Configuration/ContentSecurityPolicies.php
<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Directive;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Mutation;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationCollection;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Scope;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceKeyword;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceScheme;
use TYPO3\CMS\Core\Type\Map;

return Map::fromEntries([
    Scope::backend(),
    new MutationCollection(
        new Mutation(
            MutationMode::Extend,
            Directive::ScriptSrc,
            SourceKeyword::self,
            SourceKeyword::unsafeInline, // Only if necessary
        ),
        new Mutation(
            MutationMode::Extend,
            Directive::StyleSrc,
            SourceKeyword::self,
            SourceKeyword::unsafeInline,
        ),
        new Mutation(
            MutationMode::Extend,
            Directive::ImgSrc,
            SourceKeyword::self,
            SourceScheme::data,
        ),
    ),
]);
```

## Cross-Site Request Forgery (CSRF) Protection

### Form Protection
```html
<!-- TYPO3 automatically includes CSRF tokens in forms -->
<f:form action="create" object="{newPerson}">
    <f:form.textfield property="firstname" />
    <f:form.textfield property="lastname" />
    <f:form.submit value="Save" />
</f:form>

<!-- Manual CSRF token for AJAX requests -->
<script>
const csrfToken = '{f:security.csrfToken()}';

fetch('/api/person/update', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-Token': csrfToken
    },
    body: JSON.stringify(data)
});
</script>
```

### Controller CSRF Validation
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Controller;

use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class PersonController extends ActionController
{
    public function createAction(Person $newPerson): ResponseInterface
    {
        // CSRF protection is automatically handled by TYPO3 forms
        // For manual validation:
        $formProtection = FormProtectionFactory::get();
        if (!$formProtection->validateToken($this->request->getArgument('__hmac'), 'tx_leseohren_person')) {
            throw new \TYPO3\CMS\Core\Error\Http\BadRequestException('Invalid CSRF token');
        }

        // Process the person creation
        $this->personRepository->add($newPerson);
        
        return $this->redirect('show', null, null, ['person' => $newPerson]);
    }
}
```

## Data Protection and Privacy

### GDPR Compliance
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Service;

use SKom\Leseohren\Domain\Model\Person;
use SKom\Leseohren\Domain\Repository\PersonRepository;

class DataProtectionService
{
    private PersonRepository $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    /**
     * Export all personal data for GDPR data portability
     */
    public function exportPersonalData(Person $person): array
    {
        return [
            'personal_information' => [
                'firstname' => $person->getFirstname(),
                'lastname' => $person->getLastname(),
                'email' => $person->getEmail(),
                'birthday' => $person->getBirthday()?->format('Y-m-d'),
                'phone_mobile' => $person->getPhoneMobile(),
                'address' => [
                    'street1' => $person->getStreet1(),
                    'street2' => $person->getStreet2(),
                    'zip' => $person->getZip(),
                    'city' => $person->getCity(),
                ]
            ],
            'volunteer_data' => [
                'status' => $person->getStatus(),
                'languages' => $person->getLanguages(),
                'preferences' => $person->getPreferenceAgegroup(),
                'notes' => $person->getNotes(),
            ],
            'export_date' => date('Y-m-d H:i:s'),
            'data_controller' => 'Leseohren Organization'
        ];
    }

    /**
     * Anonymize personal data (GDPR right to be forgotten)
     */
    public function anonymizePersonalData(Person $person): void
    {
        $person->setFirstname('Anonymized');
        $person->setLastname('User');
        $person->setEmail('anonymized@example.com');
        $person->setBirthday(null);
        $person->setPhoneMobile('');
        $person->setPhoneLandline('');
        $person->setStreet1('');
        $person->setStreet2('');
        $person->setZip('');
        $person->setCity('');
        $person->setNotes('Data anonymized on ' . date('Y-m-d'));
        
        $this->personRepository->update($person);
    }

    /**
     * Log data access for audit trail
     */
    public function logDataAccess(Person $person, string $action, int $userId): void
    {
        $logData = [
            'person_uid' => $person->getUid(),
            'action' => $action,
            'user_id' => $userId,
            'timestamp' => time(),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ];

        // Log to TYPO3 system log or custom audit log
        GeneralUtility::sysLog(
            json_encode($logData),
            'leseohren',
            GeneralUtility::SYSLOG_SEVERITY_INFO
        );
    }
}
```

### Data Encryption
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Service;

use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class EncryptionService
{
    private const ENCRYPTION_METHOD = 'AES-256-CBC';

    public function encryptSensitiveData(string $data): string
    {
        $key = $this->getEncryptionKey();
        $iv = random_bytes(16);
        
        $encrypted = openssl_encrypt($data, self::ENCRYPTION_METHOD, $key, 0, $iv);
        
        return base64_encode($iv . $encrypted);
    }

    public function decryptSensitiveData(string $encryptedData): string
    {
        $key = $this->getEncryptionKey();
        $data = base64_decode($encryptedData);
        
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);
        
        return openssl_decrypt($encrypted, self::ENCRYPTION_METHOD, $key, 0, $iv);
    }

    private function getEncryptionKey(): string
    {
        // Use TYPO3's encryption key or environment variable
        return hash('sha256', $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']);
    }

    public function hashPassword(string $password): string
    {
        $hashFactory = GeneralUtility::makeInstance(PasswordHashFactory::class);
        $hashInstance = $hashFactory->getDefaultHashInstance('BE');
        
        return $hashInstance->getHashedPassword($password);
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        $hashFactory = GeneralUtility::makeInstance(PasswordHashFactory::class);
        $hashInstance = $hashFactory->get($hash, 'BE');
        
        return $hashInstance->checkPassword($password, $hash);
    }
}
```

## Session Security

### Secure Session Configuration
```php
// config/system/additional.php
<?php

// Session security settings
$GLOBALS['TYPO3_CONF_VARS']['SYS']['cookieSecure'] = 2; // Force HTTPS
$GLOBALS['TYPO3_CONF_VARS']['SYS']['cookieSameSite'] = 'strict';
$GLOBALS['TYPO3_CONF_VARS']['BE']['lockSSL'] = true;
$GLOBALS['TYPO3_CONF_VARS']['BE']['sessionTimeout'] = 3600; // 1 hour

// Additional security headers
$GLOBALS['TYPO3_CONF_VARS']['FE']['additionalHeaders'] = [
    'X-Frame-Options: SAMEORIGIN',
    'X-Content-Type-Options: nosniff',
    'X-XSS-Protection: 1; mode=block',
    'Referrer-Policy: strict-origin-when-cross-origin'
];
```

## Security Monitoring and Logging

### Security Event Logging
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Service;

use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SecurityLogService
{
    private $logger;

    public function __construct()
    {
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
    }

    public function logSecurityEvent(string $event, array $context = []): void
    {
        $this->logger->warning($event, array_merge($context, [
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'timestamp' => date('Y-m-d H:i:s'),
            'request_uri' => $_SERVER['REQUEST_URI'] ?? 'unknown'
        ]));
    }

    public function logFailedLogin(string $username): void
    {
        $this->logSecurityEvent('Failed login attempt', [
            'username' => $username,
            'severity' => 'high'
        ]);
    }

    public function logSuspiciousActivity(string $activity, array $details = []): void
    {
        $this->logSecurityEvent('Suspicious activity detected', array_merge([
            'activity' => $activity,
            'severity' => 'medium'
        ], $details));
    }

    public function logDataAccess(int $personId, string $action): void
    {
        $this->logSecurityEvent('Personal data accessed', [
            'person_id' => $personId,
            'action' => $action,
            'severity' => 'low'
        ]);
    }
}
```

## Security Testing

### Security Test Cases
```php
<?php

declare(strict_types=1);

namespace SKom\Leseohren\Tests\Security;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class SecurityTest extends FunctionalTestCase
{
    protected $testExtensionsToLoad = [
        'typo3conf/ext/leseohren',
    ];

    /**
     * @test
     */
    public function sqlInjectionIsPreventedInPersonSearch(): void
    {
        $maliciousInput = "'; DROP TABLE tx_leseohren_domain_model_person; --";
        
        $personRepository = $this->get(PersonRepository::class);
        $result = $personRepository->findByEmailSecure($maliciousInput);
        
        // Should return null without causing database error
        self::assertNull($result);
        
        // Verify table still exists
        $queryBuilder = $this->getConnectionPool()
            ->getQueryBuilderForTable('tx_leseohren_domain_model_person');
        $count = $queryBuilder->count('uid')->from('tx_leseohren_domain_model_person')->execute()->fetchOne();
        
        self::assertGreaterThanOrEqual(0, $count);
    }

    /**
     * @test
     */
    public function xssIsPreventedInPersonNotes(): void
    {
        $maliciousScript = '<script>alert("XSS")</script>';
        
        $person = new Person();
        $person->setNotes($maliciousScript);
        
        // Template should escape the content
        $view = $this->getStandaloneView();
        $view->assign('person', $person);
        $output = $view->render();
        
        self::assertStringNotContainsString('<script>', $output);
        self::assertStringContainsString('&lt;script&gt;', $output);
    }
}
```

## Security Checklist

### Development Security Checklist
- [ ] All user inputs are validated server-side
- [ ] All outputs are properly escaped in templates
- [ ] SQL queries use prepared statements or QueryBuilder
- [ ] File uploads are restricted and validated
- [ ] CSRF protection is implemented for all forms
- [ ] Authentication and authorization are properly implemented
- [ ] Sensitive data is encrypted at rest
- [ ] Security headers are configured
- [ ] Error messages don't reveal sensitive information
- [ ] Logging captures security events
- [ ] Regular security testing is performed

### Deployment Security Checklist
- [ ] HTTPS is enforced
- [ ] Database credentials are secure
- [ ] File permissions are properly set
- [ ] Debug mode is disabled in production
- [ ] Security updates are applied regularly
- [ ] Backup and recovery procedures are tested
- [ ] Monitoring and alerting are configured
- [ ] Access logs are reviewed regularly