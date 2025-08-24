# Leseohren Frontend Development Guide

## Design System

### Visual Design Principles
- **Clean and Professional**: Minimalist design focusing on functionality
- **Accessibility First**: WCAG 2.1 AA compliance mandatory
- **Responsive Design**: Mobile-first approach with Bootstrap 5
- **Consistent Branding**: Unified visual language across all interfaces

### Color Palette
```scss
// Primary colors
$primary: #0d6efd;
$secondary: #6c757d;
$success: #198754;
$warning: #ffc107;
$danger: #dc3545;
$info: #0dcaf0;

// Status-specific colors
$status-active: $success;
$status-paused: $warning;
$status-retired: $secondary;
```

### Typography
- Use system fonts for optimal performance
- Clear typographic hierarchy for information organization
- High contrast ratios for accessibility
- Support for German and English characters

## Component Architecture

### Bootstrap 5 Integration
- Use Bootstrap 5 components as base
- Extend with custom SCSS for Leseohren-specific styling
- Maintain responsive behavior across all components
- Follow Bootstrap's utility-first approach where appropriate

### Custom Components

#### Data Tables
```html
<table class="table table-striped" id="personTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Dynamic content -->
    </tbody>
</table>
```

**Features:**
- Sortable columns
- Search functionality
- Pagination for large datasets
- Bulk actions
- Export options (CSV, Excel)

#### Status Badges
```html
<span class="badge bg-{status-color}">
    <f:translate key="status.{status}" />
</span>
```

#### Action Buttons
```html
<div class="btn-group" role="group">
    <a href="{showUrl}" class="btn btn-sm btn-outline-primary">
        <i class="bi bi-eye"></i>
    </a>
    <a href="{editUrl}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-pencil"></i>
    </a>
    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal">
        <i class="bi bi-trash"></i>
    </button>
</div>
```

## Fluid Template Structure

### Layout Template
```html
<!-- Resources/Private/Layouts/Default.html -->
<!DOCTYPE html>
<html lang="{site.language.locale}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{pageTitle}</title>
    <f:asset.css identifier="leseohren-styles" />
    <f:asset.script identifier="leseohren-scripts" />
</head>
<body>
    <div class="leseohren-container">
        <f:render partial="Navigation/MainNavigation" />
        <main class="leseohren-main">
            <div class="container">
                <f:render partial="FlashMessages" />
                <f:render section="Main" />
            </div>
        </main>
        <f:render partial="Footer" />
    </div>
</body>
</html>
```

### Template Sections
- **Main**: Primary content area
- **Header**: Page-specific header content
- **Sidebar**: Optional sidebar content
- **Scripts**: Page-specific JavaScript

### Partial Templates
- **Navigation/MainNavigation**: Main site navigation
- **FlashMessages**: System messages and alerts
- **Person/FormFields**: Reusable form components
- **Person/Properties**: Display person information
- **Modals/DeleteConfirmation**: Confirmation dialogs

## Form Development

### Form Structure
```html
<f:form action="create" object="{newPerson}" class="needs-validation" novalidate="true">
    <div class="row">
        <div class="col-md-6">
            <f:form.textfield property="firstname" class="form-control" 
                             placeholder="{f:translate(key: 'person.firstname')}" />
            <f:form.validationResults for="newPerson.firstname">
                <f:if condition="{validationResults.flattenedErrors}">
                    <div class="invalid-feedback d-block">
                        <f:for each="{validationResults.flattenedErrors}" as="errors">
                            <f:for each="{errors}" as="error">
                                {error.message}
                            </f:for>
                        </f:for>
                    </div>
                </f:if>
            </f:form.validationResults>
        </div>
    </div>
    
    <div class="form-actions">
        <f:form.submit value="{f:translate(key: 'save')}" class="btn btn-primary" />
        <a href="{f:uri.action(action: 'list')}" class="btn btn-secondary">
            {f:translate(key: 'cancel')}
        </a>
    </div>
</f:form>
```

### Form Validation
- Use TYPO3 server-side validation
- Implement client-side validation with Bootstrap
- Show clear error messages
- Preserve user input on validation errors

### File Upload Forms
```html
<f:form.upload property="fileFuehrungszeugnis" class="form-control" 
               accept=".pdf,.jpg,.jpeg,.png" />
```

## JavaScript Architecture

### Module Structure
```javascript
// Resources/Private/JavaScript/PersonList.js
class PersonList {
    constructor() {
        this.initializeDataTable();
        this.bindEvents();
    }

    initializeDataTable() {
        $('#personTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'asc']],
            language: {
                url: '/path/to/german.json'
            }
        });
    }

    bindEvents() {
        // Event handlers
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new PersonList();
});
```

### DataTables Integration
```javascript
// DataTables configuration for Leseohren
const dataTableConfig = {
    responsive: true,
    pageLength: 25,
    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
    order: [[0, 'asc']],
    language: {
        url: '/typo3conf/ext/leseohren/Resources/Public/JavaScript/datatables-german.json'
    },
    columnDefs: [
        { orderable: false, targets: -1 } // Disable sorting on actions column
    ]
};
```

## SCSS Architecture

### File Structure
```
Resources/Private/Scss/
├── abstracts/
│   ├── _variables.scss
│   ├── _mixins.scss
│   └── _functions.scss
├── base/
│   ├── _reset.scss
│   ├── _typography.scss
│   └── _base.scss
├── components/
│   ├── _buttons.scss
│   ├── _forms.scss
│   ├── _tables.scss
│   └── _modals.scss
├── layout/
│   ├── _header.scss
│   ├── _navigation.scss
│   ├── _main.scss
│   └── _footer.scss
├── pages/
│   ├── _person-list.scss
│   ├── _person-detail.scss
│   └── _dashboard.scss
└── main.scss
```

### BEM Methodology
```scss
// Block
.person-list {
    padding: 1rem;
    
    // Element
    &__header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    
    &__table {
        margin-top: 1rem;
    }
    
    &__actions {
        display: flex;
        gap: 0.5rem;
    }
    
    // Modifier
    &--loading {
        opacity: 0.5;
        pointer-events: none;
    }
}
```

### Responsive Design
```scss
// Mobile-first approach
.person-card {
    padding: 1rem;
    
    @include media-breakpoint-up(md) {
        padding: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    @include media-breakpoint-up(lg) {
        padding: 2rem;
    }
}
```

## Accessibility Guidelines

### Semantic HTML
- Use proper heading hierarchy (h1, h2, h3...)
- Use semantic elements (nav, main, section, article)
- Provide meaningful alt text for images
- Use proper form labels and fieldsets

### ARIA Attributes
```html
<button class="btn btn-primary" 
        aria-describedby="help-text"
        aria-expanded="false"
        aria-controls="collapse-content">
    Toggle Content
</button>
<div id="help-text" class="form-text">
    This button toggles additional content
</div>
```

### Keyboard Navigation
- Ensure all interactive elements are keyboard accessible
- Provide visible focus indicators
- Implement logical tab order
- Support keyboard shortcuts for power users

### Screen Reader Support
- Use proper ARIA labels and descriptions
- Provide skip links for navigation
- Announce dynamic content changes
- Test with actual screen readers

## Performance Optimization

### Asset Optimization
- Minimize CSS and JavaScript files
- Use Vite for efficient bundling
- Implement lazy loading for images
- Optimize font loading

### JavaScript Performance
- Use event delegation for dynamic content
- Debounce search inputs
- Implement virtual scrolling for large lists
- Cache DOM queries

### CSS Performance
- Avoid deep nesting in SCSS
- Use efficient selectors
- Minimize reflows and repaints
- Implement critical CSS loading

## Internationalization

### Language Files
```xml
<!-- Resources/Private/Language/locallang.xlf -->
<xliff version="1.0">
    <file source-language="en" target-language="de">
        <body>
            <trans-unit id="person.firstname">
                <source>First Name</source>
                <target>Vorname</target>
            </trans-unit>
        </body>
    </file>
</xliff>
```

### Template Usage
```html
<label for="firstname">
    <f:translate key="LLL:EXT:leseohren/Resources/Private/Language/locallang.xlf:person.firstname" />
</label>
```

### Date and Number Formatting
```html
<!-- Date formatting -->
<f:format.date format="d.m.Y">{person.birthday}</f:format.date>

<!-- Number formatting -->
<f:format.number decimals="2">{amount}</f:format.number>
```

## Testing Frontend Components

### Manual Testing Checklist
- [ ] Responsive design on all screen sizes
- [ ] Keyboard navigation works properly
- [ ] Screen reader compatibility
- [ ] Form validation displays correctly
- [ ] JavaScript functionality works without errors
- [ ] Cross-browser compatibility (Chrome, Firefox, Safari, Edge)

### Browser-Based Testing Environment

#### Test Pages Access
Use the browser MCP to access dedicated test pages:
```
Base URL: https://leseohrendb.ddev.site/test-pages/
```

#### Available Test Environments
- **Component Testing**: `https://leseohrendb.ddev.site/test-pages/components`
- **Responsive Design**: `https://leseohrendb.ddev.site/test-pages/responsive`
- **Form Validation**: `https://leseohrendb.ddev.site/test-pages/forms`
- **Table Layouts**: `https://leseohrendb.ddev.site/test-pages/tables`
- **Navigation**: `https://leseohrendb.ddev.site/test-pages/navigation`

#### Testing Workflow
1. **Navigate to Test Page**: Use browser MCP to access specific test environment
2. **Execute Test Scripts**: Run manual test scripts via browser console
3. **Validate Responsive Behavior**: Test across different viewport sizes
4. **Check Cross-Browser Compatibility**: Test in multiple browsers
5. **Document Results**: Record findings and any issues discovered

#### Example Testing Session
```javascript
// Navigate to responsive test page
// https://leseohrendb.ddev.site/test-pages/responsive

// Execute responsive validation script in browser console
// (Copy script from Tests/Manual/ResponsiveTestScript.js)

// Review results
console.log(window.responsiveTestResults);
```

### Automated Testing
- Use browser automation tools for regression testing
- Test form submissions and validations
- Verify responsive breakpoints
- Check accessibility compliance automatically
- Integrate with browser MCP for continuous testing