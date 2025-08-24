# Leseohren Project Overview

## Project Context
Leseohren is a comprehensive volunteer management system built on TYPO3 CMS for managing reading service volunteers, organizations, events, and administrative tasks. The system serves as a central database for coordinating volunteer reading services across multiple organizations and locations.

## Technology Stack
- **Backend**: TYPO3 CMS v12+ (Latest LTS)
- **PHP**: 8.3+ with strict typing
- **Database**: MySQL 8.0+ / MariaDB 10.5+
- **Frontend**: Bootstrap 5, SCSS, JavaScript ES6+
- **Build System**: Vite 4.x for asset compilation
- **Template Engine**: Fluid (TYPO3's templating system)

## Core Business Domain
- **Volunteers (Persons)**: Complete volunteer profiles with status tracking, document management, preferences
- **Organizations**: Institutions where volunteers provide reading services
- **Events**: Training sessions, meetings, and volunteer activities
- **Registrations**: Event participation tracking with waitlist functionality
- **Gifts/Presents**: Recognition and gift management for volunteers
- **Blackboard**: Internal communication and announcement system
- **Categories**: Hierarchical classification system for flexible organization

## Key Features
- Volunteer lifecycle management (active, paused, retired status)
- Document management (criminal background checks, mandates)
- Event planning and registration system
- Birthday and status change monitoring
- Multi-organization volunteer assignment
- Automated reminder and notification system
- Comprehensive dashboard with alerts and metrics

## Development Standards
- Follow TYPO3 extension development best practices
- Use Extbase framework with MVC architecture
- Implement domain-driven design principles
- Maintain strict typing and comprehensive validation
- Ensure GDPR compliance for data handling
- Support responsive design and accessibility (WCAG 2.1 AA)

## File Structure
```
packages/leseohren/           # Main extension
├── Classes/                  # PHP classes (MVC)
├── Configuration/            # TYPO3 configuration
├── Resources/               # Templates, assets, language files
└── Tests/                   # Unit and functional tests

packages/skombase13/         # Base sitepackage
packages/extbase_upload/     # File upload extension
```

## Current Status
The system is in active development with core functionality implemented including person management, event system, and dashboard features. The codebase follows modern TYPO3 v12+ standards with dependency injection and proper MVC separation.