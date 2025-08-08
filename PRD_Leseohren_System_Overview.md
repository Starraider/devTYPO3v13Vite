# Leseohren System - Product Requirements Document (PRD)

## 1. Executive Summary

### 1.1 Project Overview
**Leseohren** is a comprehensive volunteer management system built on TYPO3 CMS, designed to manage reading service volunteers, organizations, events, and related administrative tasks. The system serves as a central database for coordinating volunteer reading services across multiple organizations and locations.

### 1.2 Business Context
- **Primary Purpose**: Management of volunteer reading services ("Leseohren" = reading ears)
- **Target Users**: Volunteer coordinators, administrators, and volunteers
- **Domain**: Non-profit volunteer services, reading assistance programs
- **Technology Stack**: TYPO3 CMS, PHP 8.3+, Bootstrap, SCSS, JavaScript

### 1.3 Key Value Propositions
- Centralized volunteer management and coordination
- Event planning and registration system
- Automated reminder and notification system
- Comprehensive reporting and dashboard functionality
- Multi-organization support with role-based access

## 2. System Architecture

### 2.1 Technology Stack
- **Backend**: TYPO3 CMS (Latest LTS)
- **Frontend**: Bootstrap 5, SCSS, JavaScript
- **Database**: MySQL/MariaDB with Doctrine QueryBuilder
- **Build System**: Vite for asset compilation
- **Development**: PHP 8.3+, Composer for dependency management

### 2.2 Extension Structure
```
packages/
├── leseohren/           # Main extension
├── skombase13/          # Base sitepackage
└── migration_extend/    # Migration utilities
```

### 2.3 Core Components
- **Domain Models**: Person, Organization, Event, Registration, Gift, Present, Blackboard, Category
- **Controllers**: CRUD operations for all entities
- **Repositories**: Data access layer with custom queries
- **ViewHelpers**: Custom Fluid templating helpers
- **Templates**: Fluid-based frontend templates

## 3. Functional Requirements

### 3.1 Core Entities

#### 3.1.1 Person Management
- **Volunteer Profiles**: Complete volunteer information including personal details, contact information, preferences
- **Status Tracking**: Active, paused, retired status management
- **Document Management**: Criminal background checks (Führungszeugnis), mandates, other documents
- **Preferences**: Language skills, age group preferences, organization type preferences
- **Membership Management**: Membership types, fees, payment methods

#### 3.1.2 Organization Management
- **Organization Profiles**: Complete organization information
- **Contact Management**: Multiple contact persons per organization
- **Location Management**: Addresses, districts, opening hours
- **Volunteer Assignment**: Linking volunteers to organizations
- **Communication Tracking**: Last contact dates, notes

#### 3.1.3 Event Management
- **Event Creation**: Title, description, dates, location
- **Speaker Management**: Assigning volunteers as event speakers
- **Participant Limits**: Maximum participant management
- **Registration System**: Event registration with waitlist functionality
- **Reminder System**: Automated reminder notifications

#### 3.1.4 Registration System
- **Event Registration**: Volunteers can register for events
- **Waitlist Management**: Automatic waitlist when events are full
- **Registration Tracking**: Registration dates and status

#### 3.1.5 Gift/Present Management
- **Gift Catalog**: Manage available gifts/presents
- **Present Tracking**: Track gifts given to volunteers
- **Date Management**: Gift dates and delivery status

#### 3.1.6 Blackboard System
- **Announcement Board**: Internal communication system
- **Person Assignment**: Link announcements to specific volunteers
- **Date Management**: Start and end dates for announcements

### 3.2 Dashboard Functionality

#### 3.2.1 Birthday Management
- **Upcoming Birthdays**: Display volunteers with upcoming birthdays
- **Configurable Warning Period**: Customizable notification periods
- **Category Filtering**: Filter by volunteer categories

#### 3.2.2 Status Change Management
- **Status Warnings**: Alert for upcoming status changes
- **Expired Documents**: Track expired criminal background checks
- **Automated Notifications**: Configurable warning periods

#### 3.2.3 Holiday Tracking
- **Easter Date Management**: Track Easter dates for planning
- **Christmas Countdown**: Days until Christmas display
- **Holiday Planning**: Support for holiday-related scheduling

### 3.3 Administrative Features

#### 3.3.1 Category Management
- **Hierarchical Categories**: Parent-child category relationships
- **Flexible Classification**: Categorize volunteers, organizations, events
- **Multi-purpose Usage**: Categories for various entity types

#### 3.3.2 Data Import/Export
- **Migration Support**: Tools for data migration from older systems
- **Data Validation**: Comprehensive validation rules
- **Error Handling**: Robust error handling and logging

## 4. Non-Functional Requirements

### 4.1 Performance
- **Response Time**: Page load times under 3 seconds
- **Scalability**: Support for 1000+ volunteers and 100+ organizations
- **Database Optimization**: Efficient queries with proper indexing

### 4.2 Security
- **Data Protection**: GDPR-compliant data handling
- **Access Control**: Role-based access control
- **Input Validation**: Comprehensive input sanitization
- **Document Security**: Secure file upload and storage

### 4.3 Usability
- **Responsive Design**: Mobile-friendly interface
- **Accessibility**: WCAG 2.1 AA compliance
- **Intuitive Navigation**: Clear and logical user interface
- **Multi-language Support**: German and English localization

### 4.4 Reliability
- **Data Integrity**: Consistent data across all operations
- **Error Recovery**: Graceful error handling
- **Backup Systems**: Regular data backup procedures
- **Monitoring**: System health monitoring and alerting

## 5. User Roles and Permissions

### 5.1 Administrator
- Full system access
- User management
- System configuration
- Data import/export

### 5.2 Volunteer Coordinator
- Volunteer management
- Event organization
- Registration management
- Reporting access

### 5.3 Volunteer
- Profile management
- Event registration
- Document upload
- Communication access

## 6. Integration Requirements

### 6.1 TYPO3 Integration
- **Core Compatibility**: Latest TYPO3 LTS version
- **Extension Standards**: Follow TYPO3 extension development guidelines
- **Backend Integration**: Seamless backend user experience

### 6.2 External Systems
- **Email Integration**: Automated email notifications
- **File Storage**: Secure document storage system
- **Reporting Tools**: Integration with reporting systems

## 7. Data Management

### 7.1 Data Models
- **Person**: Comprehensive volunteer profiles
- **Organization**: Complete organization information
- **Event**: Event planning and management
- **Registration**: Event participation tracking
- **Gift/Present**: Recognition and gift management
- **Blackboard**: Internal communication system
- **Category**: Flexible classification system

### 7.2 Data Relationships
- **Many-to-Many**: Volunteers ↔ Organizations, Volunteers ↔ Events
- **One-to-Many**: Organization → Contact Persons, Event → Registrations
- **Hierarchical**: Category parent-child relationships

### 7.3 Data Validation
- **Required Fields**: Essential information validation
- **Format Validation**: Email, phone, date format validation
- **Business Rules**: Status transitions, date logic validation

## 8. Reporting and Analytics

### 8.1 Standard Reports
- **Volunteer Statistics**: Active, paused, retired counts
- **Event Participation**: Registration and attendance reports
- **Organization Activity**: Organization engagement metrics
- **Document Status**: Expired document tracking

### 8.2 Dashboard Metrics
- **Upcoming Events**: Event calendar and reminders
- **Birthday Alerts**: Upcoming volunteer birthdays
- **Status Changes**: Pending status modifications
- **Document Expiry**: Expiring background checks

## 9. Deployment and Maintenance

### 9.1 Deployment Strategy
- **Environment Management**: Development, staging, production
- **Version Control**: Git-based deployment workflow
- **Database Migrations**: Automated schema updates
- **Asset Compilation**: Vite-based build process

### 9.2 Maintenance Requirements
- **Regular Updates**: TYPO3 core and extension updates
- **Security Patches**: Timely security updates
- **Performance Monitoring**: Regular performance reviews
- **Data Backup**: Automated backup procedures

## 10. Future Enhancements

### 10.1 Planned Features
- **Advanced Reporting**: Business intelligence dashboards
- **Advanced Notifications**: Push notifications and SMS

### 10.2 Scalability Considerations
- **Cloud Deployment**: Cloud-based hosting options
- **Microservices**: Service-oriented architecture
- **Caching**: Advanced caching strategies

---

**Document Version**: 1.0
**Last Updated**: December 2024
**Author**: Sven Kalbhenn (sven@skom.de)
**Project**: Leseohren Volunteer Management System
