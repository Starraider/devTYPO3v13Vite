# TYPO3 Leseohren Project Rules

## 📋 **Table of Contents**

1. [🎯 Project Overview](#-project-overview)
2. [🔧 Application Stack & Technology](#-application-stack--technology)
3. [📝 Sequential Thinking Process](#-sequential-thinking-process)
4. [🏗️ PHP & TYPO3 Best Practices](#️-php--typo3-best-practices)
5. [🎨 Frontend Development](#-frontend-development)
6. [🎭 Fluid Templating Best Practices](#-fluid-templating-best-practices)
7. [♿ Accessibility Requirements](#-accessibility-requirements)
8. [📁 Directory Structure](#-directory-structure)
9. [🔐 Security Guidelines](#-security-guidelines)
10. [🧪 Testing Strategy](#-testing-strategy)
11. [📚 Documentation Standards](#-documentation-standards)
12. [🚀 Performance Guidelines](#-performance-guidelines)
13. [🔄 Development Workflow](#-development-workflow)
14. [⚠️ Important Constraints](#️-important-constraints)
15. [🎯 Success Metrics](#-success-metrics)

---

## 🎯 **Project Overview**

Short Do/Don't
- Do: Align every change with project mission and stakeholders.
- Don't: Add features that don’t serve core goals or introduce scope creep.

The **TYPO3 Leseohren Project** is a comprehensive database management system built on TYPO3 CMS v13, designed to manage reading mentor programs and related organizational data. This project provides a modern, scalable solution with robust data management capabilities.

### **Core Mission**
- Provide a robust, user-friendly database for managing reading mentor programs
- Organize and track persons, organizations, events, and related activities
- Offer a modern web interface with responsive design and accessibility features
- Maintain data integrity and security while ensuring easy maintenance and scalability

---

## 🔧 **Application Stack & Technology**

Short Do/Don't
- Do: Use TYPO3 v13, PHP 8.3+, Vite, Bootstrap 5, Composer, and NPM as defined.
- Don't: Introduce alternative stacks or bypass TYPO3 APIs.

### **Core Technologies**
- **Backend**: TYPO3 CMS v13 (Latest LTS) with PHP 8.3+
- **Frontend**: Bootstrap 5 with SCSS, modern JavaScript (ES6+)
- **Build System**: Vite for fast development and optimized production builds
- **Database**: TYPO3's Doctrine QueryBuilder with proper database abstraction
- **Templating**: Fluid templating engine with Extbase framework

### **Development Environment**
- **DDEV**: Local development environment with Docker
  - **IMPORTANT**: Always use DDEV for test runs and result verification. Never run PHP's built-in server directly (`php -S`)
- **Composer**: PHP dependency management
- **NPM**: Frontend package management
- **Git**: Version control with semantic versioning

### **Package Structure**
```
packages/
├── leseohren/          # Main application extension (MVC, domain logic)
├── skombase13/         # Base site package (templates, SCSS, configurations)
└── extbase_upload/     # File upload extension
```

---

## 📝 **Sequential Thinking Process**

Short Do/Don't
- Do: Follow the 4-step process before coding; write a minimal plan and test notes.
- Don't: Jump into implementation without requirements and integration analysis.

**CRITICAL: Always use Sequential Thinking before starting any programming task.**

### **Step 1: Problem Analysis**
1. **Understand Requirements**: What problem are we solving?
2. **Identify Stakeholders**: Who will use and maintain this?
3. **Define Success Criteria**: How do we know when it's complete?

### **Step 2: Technical Analysis**
1. **Architecture Considerations**: How does this fit existing architecture?
2. **Dependencies Analysis**: What existing code does this depend on?
3. **Data Flow Analysis**: What data flows are involved?

### **Step 3: Implementation Planning**
1. **Break Down Tasks**: What sub-tasks are required?
2. **Identify Issues**: What could go wrong? Edge cases?
3. **Resource Requirements**: What skills/tools are needed?

### **Step 4: Testing Strategy**
1. **Test Cases**: What scenarios need testing?
2. **Integration Points**: How will this integrate with existing systems?

---

## 🏗️ **PHP & TYPO3 Best Practices**

Short Do/Don't
- Do: Use strict types, PSR coding style, Extbase, TYPO3 APIs, QueryBuilder.
- Don't: Use raw SQL, bypass repositories, or output unescaped data in Fluid.

### **PHP Development Standards**
- **PHP Version**: Use PHP 8.3+ features (strict types, readonly properties, enums)
- **Coding Standard**: Follow PSR-2 for consistent formatting
- **Type Safety**: Always use strict types and proper type declarations
- **Documentation**: Complete DocBlocks for all classes, methods, and properties

### **TYPO3-Specific Guidelines**
- **Extbase Framework**: Use for all plugin development and MVC architecture
- **Domain-Driven Design**: Clear separation between domain models and application logic
- **TYPO3 APIs**: Always use TYPO3 core APIs instead of direct database access
- **QueryBuilder**: Use Doctrine QueryBuilder for all database operations
- **Security**: Input validation, output sanitization, and proper CSRF protection

### **Error Handling & Logging**
- **Exception Handling**: Proper try-catch blocks with meaningful error messages
- **Logging**: Use TYPO3's logging framework for debugging and monitoring
- **Validation**: Server-side validation for all user inputs
- **Edge Cases**: Handle null values, empty arrays, and unexpected data types

### **File Organization**
```
Classes/
├── Controller/         # Extbase controllers
├── Domain/
│   ├── Model/          # Domain models
│   └── Repository/     # Data repositories
├── ViewHelpers/        # Custom Fluid ViewHelpers
└── Utility/           # Helper classes
```

---

## 🎨 **Frontend Development**

Short Do/Don't
- Do: Keep SCSS modular (abstracts, base, components, layout), use BEM and Vite.
- Don't: Inline large CSS/JS or modify Bootstrap core files.

### **SCSS Architecture**
```
Resources/Private/Scss/
├── Main.entry.scss     # Main entry point
├── abstracts/          # Variables, mixins, functions
├── base/              # Typography, reset styles
├── components/        # Reusable UI components (buttons, cards, modals)
├── layout/           # Navigation, footer, containers
├── plugins/          # TYPO3 plugin styles
└── vendor/           # Third-party library styles
```

### **Bootstrap Integration**
- **Bootstrap 5**: Use Bootstrap components while maintaining customizability
- **BEM Methodology**: Follow BEM naming conventions for custom components
- **Responsive Design**: Mobile-first approach with proper breakpoints
- **CSS Custom Properties**: Use for theming and dynamic styles

### **JavaScript Standards**
- **ES6+ Modules**: Modern module syntax with proper imports/exports
- **Vite Integration**: Use Vite for fast development and optimized builds
- **Component-Based**: Modular, reusable JavaScript components
- **Performance**: Minimize DOM manipulation and use efficient selectors

---

## 🎭 **Fluid Templating Best Practices**

Short Do/Don't
- Do: Use layouts, templates, partials, and ViewHelpers; keep HTML semantic and secure.
- Don't: Mix business logic in templates or disable escaping blindly.

### **Template Organization**
- **Layouts**: Base page structures with consistent navigation and footer
- **Templates**: Page-specific content templates
- **Partials**: Reusable template components
- **ViewHelpers**: Custom functionality for templates

### **Fluid Coding Standards**
- **Semantic HTML5**: Proper use of semantic elements (article, section, nav)
- **Accessibility**: ARIA labels, proper heading hierarchy, alt attributes
- **Internationalization**: Use XLIFF files for all text content
- **Security**: Always escape output with proper ViewHelpers
- **Validation**: Validate Fluid syntax and test template rendering

### **Template Structure**
```html
<f:layout name="Default" />
<f:section name="Content">
    <div class="content-wrapper">
        <!-- Semantic, accessible content -->
    </div>
</f:section>
```

---

## ♿ **Accessibility Requirements**

Short Do/Don't
- Do: Ensure keyboard accessibility, color contrast, alt text, and focus states.
- Don't: Convey information by color alone or trap focus.

### **WCAG 2.1 AA Compliance**
- **Semantic HTML**: Use proper heading hierarchy (h1-h6)
- **Keyboard Navigation**: All interactive elements must be keyboard accessible
- **Color Contrast**: Minimum 4.5:1 ratio for normal text, 3:1 for large text
- **Alt Text**: Descriptive alternative text for all images
- **Focus Management**: Visible focus indicators for all interactive elements

### **Testing & Validation**
- **Screen Readers**: Test with screen reader software
- **Keyboard Only**: Navigate entire site using only keyboard
- **Color Blindness**: Test with color blindness simulators
- **Automated Testing**: Use accessibility testing tools (axe-core, Lighthouse)

---

## 📁 **Directory Structure**

Short Do/Don't
- Do: Follow the documented structure for root and extensions; keep files where they belong.
- Don't: Scatter configuration or assets across arbitrary directories.

### **Root Project Structure**
```
leseohrendb/
├── .ddev/              # DDEV configuration
├── config/             # TYPO3 site configuration
├── packages/           # Custom extensions and site packages
├── public/             # Web root (index.php, fileadmin)
├── var/                # Cache, logs, temporary files
├── vendor/             # Composer dependencies
├── composer.json       # PHP dependencies
├── package.json        # Node.js dependencies
└── vite.config.js      # Vite configuration
```

### **Extension Structure (packages/leseohren/)**
```
leseohren/
├── Classes/
│   ├── Controller/     # Extbase controllers
│   ├── Domain/         # Models and repositories
│   └── ViewHelpers/    # Custom Fluid ViewHelpers
├── Configuration/
│   ├── TCA/           # Table configuration arrays
│   ├── TypoScript/    # TypoScript configuration
│   └── Yaml/          # YAML configurations
├── Resources/
│   ├── Private/       # Templates, SCSS, JavaScript
│   └── Public/        # Compiled assets, images
├── Tests/             # Unit and functional tests
├── composer.json      # Extension dependencies
├── ext_emconf.php     # Extension metadata
├── ext_localconf.php  # Extension configuration
└── ext_tables.sql     # Database schema
```

---

## 🔐 **Security Guidelines**

Short Do/Don't
- Do: Validate input, encode output, use CSRF tokens, and least-privilege access.
- Don't: Trust client input, echo raw variables, or build SQL via string concatenation.

### **Input Validation & Output Encoding**
- **Server-Side Validation**: Never trust client-side validation alone
- **Type Checking**: Validate data types and ranges
- **SQL Injection Prevention**: Use QueryBuilder with parameters
- **XSS Prevention**: Proper output encoding in Fluid templates
- **CSRF Protection**: Use TYPO3's built-in CSRF tokens

### **Authentication & Authorization**
- **User Management**: Use TYPO3's built-in user management
- **Role-Based Access**: Implement proper permission checks
- **Session Security**: Secure session configuration
- **Password Security**: Use TYPO3's password hashing

---

## 🧪 **Testing Strategy**

Short Do/Don't
- Do: Write tests for logic-heavy code and critical paths; run tests before release.
- Don't: Rely only on manual testing or leave regressions unguarded.

### **Testing Levels**
- **Unit Tests**: Test individual classes and methods
- **Functional Tests**: Test complete workflows
- **Integration Tests**: Test component interactions
- **Accessibility Tests**: Validate WCAG compliance

### **Testing Tools**
- **PHPUnit**: PHP unit testing framework
- **TYPO3 Testing Framework**: TYPO3-specific testing utilities
- **Browser Testing**: Selenium or similar for frontend testing
- **Performance Testing**: Load testing for critical functionality

---

## 📚 **Documentation Standards**

Short Do/Don't
- Do: Maintain PHPDoc, README, and changelogs; document public APIs and decisions.
- Don't: Merge code without minimal inline docs for complex logic.

### **Code Documentation**
- **DocBlocks**: Complete PHPDoc for all classes and methods
- **README Files**: Extension-specific documentation
- **Inline Comments**: Explain complex logic and business rules
- **API Documentation**: Document public interfaces and methods

### **Project Documentation**
- **Architecture Documents**: High-level system design
- **Deployment Guides**: Setup and configuration instructions
- **User Manuals**: End-user documentation
- **Change Logs**: Version history and feature documentation

---

## 🚀 **Performance Guidelines**

Short Do/Don't
- Do: Cache smartly, optimize queries, compress assets, and lazy-load images.
- Don't: Run N+1 queries or ship unminified, render-blocking assets.

### **Backend Performance**
- **Database Optimization**: Proper indexing and query optimization
- **Caching Strategy**: Use TYPO3's caching framework effectively
- **Memory Management**: Avoid memory leaks and optimize memory usage
- **Code Efficiency**: Profile and optimize critical code paths

### **Frontend Performance**
- **Asset Optimization**: Minimize and compress CSS/JavaScript
- **Image Optimization**: Proper image formats and sizes
- **Lazy Loading**: Implement for images and non-critical content
- **CDN Usage**: Consider CDN for static assets

---

## 🔄 **Development Workflow**

Short Do/Don't
- Do: Use feature branches and semantic versioning.
- Don't: Commit directly to main or merge without CI checks.

### **Version Control**
- **Git Flow**: Use structured branching strategy
- **Commit Messages**: Clear, descriptive commit messages
- **Release Management**: Semantic versioning and proper tagging

### **Quality Assurance**
- **Code Standards**: Consistent coding standards enforcement
- **Automated Testing**: Run tests before deployment
- **Security Audits**: Regular security assessments
- **Performance Monitoring**: Continuous performance tracking

---

## ⚠️ **Important Constraints**

Short Do/Don't
- Do: Preserve existing functionality and backward compatibility.
- Don't: Break public interfaces or change DB schema without migrations.

### **Development Rules**
- **Don't Remove Existing Functionality**: Preserve existing structures unless explicitly required
- **Handle Edge Cases**: Consider and handle potential error scenarios
- **Use TYPO3 APIs**: Leverage built-in TYPO3 functions when available
- **Maintain Backwards Compatibility**: Ensure upgrades don't break existing functionality

### **File Management**
- **No Binary Files**: Never commit large binary files to repository
- **SVG Images**: Use SVG format for icons and simple graphics
- **Asset Organization**: Keep assets organized in appropriate directories
- **Naming Conventions**: Use consistent, descriptive file names

---

## 🎯 **Success Metrics**

Short Do/Don't
- Do: Measure performance, accessibility, and quality; capture user feedback.
- Don't: Declare success without objective metrics or stakeholder validation.

### **Technical Metrics**
- **Performance**: Page load times under 3 seconds
- **Accessibility**: WCAG 2.1 AA compliance
- **Code Quality**: Maintainable, well-documented codebase
- **Security**: Zero critical security vulnerabilities

### **User Experience Metrics**
- **Usability**: Intuitive interface with minimal learning curve
- **Responsiveness**: Consistent experience across all devices
- **Efficiency**: Streamlined workflows for common tasks
- **Satisfaction**: Positive user feedback and adoption rates

---

This comprehensive set of rules ensures consistent, high-quality development practices for the TYPO3 Leseohren project while maintaining security, accessibility, and performance standards.
