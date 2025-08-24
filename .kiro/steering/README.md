# Leseohren Steering Documents

This directory contains comprehensive steering documents that guide development work on the Leseohren volunteer management system. These documents provide context, standards, and best practices for all development activities.

## Document Overview

### 📋 [Project Overview](project-overview.md)
**Purpose**: High-level project context and technology stack overview
**Use when**: Starting new work, onboarding team members, understanding project scope
**Key topics**: Business domain, technology stack, core features, file structure

### 💻 [Coding Standards](coding-standards.md)
**Purpose**: Code quality standards and conventions
**Use when**: Writing any code, conducting code reviews, setting up development environment
**Key topics**: PHP standards, naming conventions, frontend standards, security practices

### 🏗️ [Domain Model Guide](domain-model-guide.md)
**Purpose**: Understanding the business domain and data relationships
**Use when**: Working with domain models, repositories, business logic, data relationships
**Key topics**: Core entities, relationships, validation rules, repository patterns

### 🎨 [Frontend Development Guide](frontend-development-guide.md)
**Purpose**: Frontend development standards and component architecture
**Use when**: Building user interfaces, working with templates, styling components
**Key topics**: Design system, Fluid templates, SCSS architecture, JavaScript patterns

### 🔧 [TYPO3 Best Practices](typo3-best-practices.md)
**Purpose**: TYPO3-specific development guidelines and patterns
**Use when**: Working with TYPO3 extensions, TCA configuration, TypoScript, Extbase
**Key topics**: Extension structure, TCA configuration, Extbase patterns, performance optimization

### 🧪 [Testing Guidelines](testing-guidelines.md)
**Purpose**: Testing strategy and implementation guidelines
**Use when**: Writing tests, setting up CI/CD, ensuring code quality
**Key topics**: Unit testing, functional testing, test fixtures, continuous integration

### 🗄️ [Database Schema Guide](database-schema-guide.md)
**Purpose**: Database design principles and schema documentation
**Use when**: Working with database structure, migrations, performance optimization
**Key topics**: Table structures, relationships, indexing, migration scripts

### 🔒 [Security Guidelines](security-guidelines.md)
**Purpose**: Security best practices and implementation guidelines
**Use when**: Handling user input, file uploads, authentication, data protection
**Key topics**: Input validation, GDPR compliance, encryption, security testing

## How to Use These Documents

### For New Features
1. Start with **Project Overview** to understand the context
2. Review **Domain Model Guide** for data relationships
3. Follow **Coding Standards** for implementation
4. Use **Frontend Development Guide** for UI components
5. Apply **Security Guidelines** for secure implementation
6. Implement **Testing Guidelines** for quality assurance

### For Bug Fixes
1. Check **Domain Model Guide** for business logic understanding
2. Follow **Coding Standards** for consistent fixes
3. Apply **Security Guidelines** if security-related
4. Use **Testing Guidelines** to prevent regressions

### For Code Reviews
1. Verify adherence to **Coding Standards**
2. Check **Security Guidelines** compliance
3. Ensure **TYPO3 Best Practices** are followed
4. Validate **Testing Guidelines** implementation

### For System Maintenance
1. Use **Database Schema Guide** for schema changes
2. Follow **TYPO3 Best Practices** for updates
3. Apply **Security Guidelines** for security updates
4. Reference **Testing Guidelines** for validation

### For Browser Testing
1. Access test environment at `https://leseohrendb.ddev.site/test-pages/*`
2. Use **Testing Guidelines** for browser-based testing procedures
3. Follow **Frontend Development Guide** for responsive testing
4. Execute manual test scripts via browser MCP

## Document Maintenance

### Updating Documents
- Keep documents current with project evolution
- Update when new patterns or standards are established
- Review and update after major TYPO3 version upgrades
- Incorporate lessons learned from development experience

### Version Control
- All steering documents are version controlled with the project
- Changes should be reviewed and approved by the team
- Document significant changes in commit messages
- Consider backward compatibility when updating standards

## Quick Reference

### Common Patterns

#### Creating a New Domain Model
1. Follow **Domain Model Guide** for entity design
2. Use **Database Schema Guide** for table structure
3. Apply **Coding Standards** for implementation
4. Implement **Testing Guidelines** for validation
5. Follow **Security Guidelines** for data protection

#### Building a New Controller
1. Use **TYPO3 Best Practices** for controller structure
2. Apply **Coding Standards** for code quality
3. Follow **Security Guidelines** for input validation
4. Implement **Testing Guidelines** for functionality testing

#### Creating Frontend Components
1. Follow **Frontend Development Guide** for component design
2. Use **Coding Standards** for consistent styling
3. Apply **Security Guidelines** for XSS prevention
4. Ensure accessibility compliance per guidelines

### Key Principles
- **Security First**: Always consider security implications
- **TYPO3 Standards**: Follow TYPO3 conventions and best practices
- **Code Quality**: Maintain high code quality standards
- **Testing**: Comprehensive testing for reliability
- **Documentation**: Keep code and processes well-documented
- **Performance**: Consider performance implications in all decisions

## Getting Help

### Internal Resources
- Review relevant steering documents for guidance
- Check existing code for established patterns
- Consult team members for clarification

### External Resources
- [TYPO3 Documentation](https://docs.typo3.org/)
- [TYPO3 Extension Development](https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ExtensionArchitecture/Index.html)
- [Bootstrap Documentation](https://getbootstrap.com/docs/)
- [PHP Standards](https://www.php-fig.org/psr/)

## Contributing to Steering Documents

### Process
1. Identify need for new or updated guidance
2. Draft changes or new content
3. Review with team for accuracy and completeness
4. Update relevant documents
5. Communicate changes to development team

### Standards for Steering Documents
- Clear and actionable guidance
- Practical examples and code snippets
- Consistent formatting and structure
- Regular updates to maintain relevance
- Cross-references between related documents

---

**Last Updated**: December 2024  
**Maintained By**: Development Team  
**Project**: Leseohren Volunteer Management System