# Design Document

## Overview

This design document outlines the implementation approach for merging the "Last name" and "First name" columns in the person list view into a single "Name" column. The solution involves modifying the Fluid template, updating the DataTable JavaScript configuration, and ensuring proper localization support.

## Architecture

### Current State Analysis

**Template Structure:**
- File: `packages/leseohren/Resources/Private/Templates/Person/List.html`
- Current columns: lastname (index 0), firstname (index 1), categories (index 2), etc.
- DataTable ID: `#personList`

**DataTable Configuration:**
- File: `packages/leseohren/Resources/Public/JavaScript/myDataTables.js`
- Current column indexes: 0-9 (lastname=0, firstname=1, categories=2, zip=3, city=4, email=5, phone=6, org_categories=7, fz=8, actions=9)
- SearchPanes enabled for lastname (index 0) and firstname (index 1)
- Export configuration includes columns [1, 2, 3, 4, 5, 6, 7]

### Target State Design

**New Template Structure:**
- Merge columns 0 and 1 into single "Name" column
- New column indexes: name (index 0), categories (index 1), zip (index 2), city (index 3), email (index 4), phone (index 5), org_categories (index 6), fz (index 7), actions (index 8)
- Display format: "lastname, firstname" with proper handling of missing values

## Components and Interfaces

### 1. Fluid Template Modifications

**File:** `packages/leseohren/Resources/Private/Templates/Person/List.html`

**Changes Required:**
```html
<!-- Current structure -->
<th><f:translate key="tx_leseohren_domain_model_person.lastname" /></th>
<th><f:translate key="tx_leseohren_domain_model_person.firstname" /></th>

<!-- New structure -->
<th><f:translate key="tx_leseohren_domain_model_person.name" /></th>
```

**Data Cell Implementation:**
```html
<!-- Current structure -->
<td><f:link.action action="show" arguments="{person : person}">{person.lastname}</f:link.action></td>
<td><f:link.action action="show" arguments="{person : person}">{person.firstname}</f:link.action></td>

<!-- New structure -->
<td>
    <f:link.action action="show" arguments="{person : person}">
        <f:if condition="{person.lastname}">
            <f:then>
                {person.lastname}<f:if condition="{person.firstname}">, {person.firstname}</f:if>
            </f:then>
            <f:else>
                {person.firstname}
            </f:else>
        </f:if>
    </f:link.action>
</td>
```

### 2. DataTable Configuration Updates

**File:** `packages/leseohren/Resources/Public/JavaScript/myDataTables.js`

**Column Index Mapping:**
```javascript
// Old indexes -> New indexes
// 0 (lastname) + 1 (firstname) -> 0 (name)
// 2 (categories) -> 1 (categories)
// 3 (zip) -> 2 (zip)
// 4 (city) -> 3 (city)
// 5 (email) -> 4 (email)
// 6 (phone) -> 5 (phone)
// 7 (org_categories) -> 6 (org_categories)
// 8 (fz) -> 7 (fz)
// 9 (actions) -> 8 (actions)
```

**Updated Configuration:**
```javascript
let tablePersonList = new DataTable('#personList', {
    // ... existing config
    layout: {
        topStart: {
            buttons: [
                {
                    extend: 'pdfHtml5',
                    // ... existing config
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6], // Updated column indexes
                    },
                },
                // ... other buttons
            ],
        },
        // ... rest of layout
    },
    columnDefs: [
        {
            searchPanes: { show: false }, // No search pane for name column
            targets: [0], // Name column
        },
        {
            searchPanes: { show: true, orthogonal: { filter: 'spFilter' } },
            targets: [1], // Categories (was index 2)
            // ... existing render function
        },
        {
            searchPanes: { show: true },
            targets: [2], // ZIP (was index 3)
        },
        {
            searchPanes: { show: true },
            targets: [3], // City (was index 4)
        },
        {
            searchPanes: { show: false },
            targets: [4], // Email (was index 5)
        },
        {
            searchPanes: { show: false },
            targets: [5], // Phone (was index 6)
        },
        {
            searchPanes: { show: true, orthogonal: { filter: 'spFilter' } },
            targets: [6], // Org Categories (was index 7)
            // ... existing render function
        },
        {
            orderable: false,
            searchPanes: { show: false },
            targets: [7], // FZ (was index 8)
        },
        {
            orderable: false,
            searchPanes: { show: false },
            targets: [8], // Actions (was index 9)
        },
    ],
});
```

### 3. Localization Updates

**File:** `packages/leseohren/Resources/Private/Language/locallang_db.xlf`

**New Translation Key:**
```xml
<trans-unit id="tx_leseohren_domain_model_person.name">
    <source>Name</source>
    <target>Name</target>
</trans-unit>
```

**File:** `packages/leseohren/Resources/Private/Language/de.locallang_db.xlf` (if exists)
```xml
<trans-unit id="tx_leseohren_domain_model_person.name">
    <source>Name</source>
    <target>Name</target>
</trans-unit>
```

## Data Models

### Name Display Logic

**Business Rules:**
1. If both lastname and firstname exist: "lastname, firstname"
2. If only lastname exists: "lastname"
3. If only firstname exists: "firstname"
4. If neither exists: empty string

**Sorting Behavior:**
- Primary sort: lastname (alphabetical)
- Secondary sort: firstname (alphabetical)
- Empty values sort last

**Search Behavior:**
- Global search includes both firstname and lastname content
- Search matches partial strings in either name component
- Case-insensitive matching

## Error Handling

### Template Error Handling

**Missing Data Scenarios:**
```html
<f:if condition="{person.lastname}">
    <f:then>
        {person.lastname}<f:if condition="{person.firstname}">, {person.firstname}</f:if>
    </f:then>
    <f:else>
        <f:if condition="{person.firstname}">
            <f:then>{person.firstname}</f:then>
            <f:else>
                <span class="text-muted"><f:translate key="tx_leseohren.no_name" /></span>
            </f:else>
        </f:if>
    </f:else>
</f:if>
```

### DataTable Error Handling

**Column Index Validation:**
- Ensure all column references are updated consistently
- Add console warnings for debugging if needed
- Graceful degradation if column configuration is incorrect

## Testing Strategy

### Template Testing
1. **Data Scenarios:**
   - Person with both firstname and lastname
   - Person with only lastname
   - Person with only firstname
   - Person with neither name (edge case)

2. **Functionality Testing:**
   - Click navigation to person detail page
   - Responsive behavior on different screen sizes
   - Print and export functionality

### DataTable Testing
1. **Configuration Testing:**
   - Verify column indexes are correct
   - Test sorting functionality
   - Test search functionality
   - Test export functionality

2. **Search Panes Testing:**
   - Verify name column has no search pane
   - Verify other columns maintain search panes
   - Test category filtering still works



## Performance Considerations

### Template Performance
- Minimal impact: removing one column, adding conditional logic
- No additional database queries required
- Fluid template caching remains effective

### DataTable Performance
- Reduced column count improves rendering performance
- Fewer search panes reduce memory usage
- Export operations slightly faster with fewer columns

### Search Performance
- Global search performance unchanged
- Reduced search pane filtering improves performance
- Column-specific filtering removed for name reduces complexity

## Migration Strategy

### Deployment Steps
1. **Template Update:** Modify Person/List.html template
2. **JavaScript Update:** Update myDataTables.js configuration
3. **Localization Update:** Add new translation keys
4. **Testing:** Verify functionality in staging environment
5. **Production Deployment:** Deploy all changes together

### Rollback Plan
- Keep backup of original template and JavaScript files
- Revert changes in reverse order if issues occur
- No database changes required, so rollback is straightforward

### Compatibility Considerations
- No breaking changes to backend functionality
- No changes to person model or repository
- Existing bookmarks and links remain functional
- Export formats change but remain compatible

## Security Considerations

### XSS Prevention
- All name data is already properly escaped in Fluid templates
- No additional user input processing required
- Existing TYPO3 security measures remain in place

### Data Privacy
- No changes to data storage or access patterns
- Same personal information displayed, just formatted differently
- GDPR compliance maintained through existing mechanisms

## Accessibility Considerations

### Screen Reader Support
- Maintain proper table header associations
- Ensure column sorting announcements work correctly
- Preserve keyboard navigation functionality

### Visual Design
- Maintain consistent visual hierarchy
- Ensure adequate color contrast for all text
- Preserve responsive design behavior

### Keyboard Navigation
- All interactive elements remain keyboard accessible
- Tab order preserved and logical
- Sorting and filtering remain keyboard accessible