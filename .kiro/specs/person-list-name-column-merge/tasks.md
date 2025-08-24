# Implementation Plan

- [x] 1. Add localization support for merged name column
  - Create new translation key for "Name" column header in locallang_db.xlf
  - Add German translation for the name column header
  - Ensure translation key follows TYPO3 naming conventions
  - _Requirements: 5.1, 5.2, 5.3, 5.4_

- [x] 2. Update Fluid template to merge name columns
  - Modify Person/List.html template to replace separate lastname and firstname columns
  - Implement conditional logic to display "lastname, firstname" format
  - Handle edge cases for missing firstname or lastname values
  - Ensure proper HTML escaping and link functionality is maintained
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 1.6, 2.1_

- [x] 3. Update DataTable JavaScript configuration
  - Modify myDataTables.js to adjust column indexes after removing firstname column
  - Remove search panes configuration for lastname and firstname columns
  - Update export configuration to use new column indexes
  - Ensure categories and organization categories columns maintain their search pane functionality
  - _Requirements: 2.2, 2.3, 2.6, 4.1, 4.2, 4.3, 4.4, 4.5_

- [x] 4. Test template functionality with various name scenarios
  - Test display with both firstname and lastname present
  - Test display with only lastname present
  - Test display with only firstname present
  - Verify link navigation to person detail page works correctly
  - Test responsive behavior on different screen sizes
  - _Requirements: 1.3, 1.4, 1.5, 1.6, 2.1, 2.4, 2.5, 3.2, 3.3_

- [x] 5. Test DataTable functionality and search capabilities
  - Verify table sorting works correctly on merged name column
  - Test global search functionality includes both firstname and lastname content
  - Verify search panes are removed for name column and maintained for other columns
  - Test export functionality (PDF, CSV, Copy) with updated column structure
  - Verify print functionality displays merged names correctly
  - _Requirements: 2.2, 2.3, 2.6, 3.4, 3.5, 4.6_

- [x] 6. Validate responsive design and layout optimization
  - Test table layout on mobile devices and tablets
  - Verify column width distribution is optimized after removing firstname column
  - Ensure table maintains proper alignment with merged name column
  - Test that remaining columns have appropriate spacing
  - _Requirements: 2.5, 3.1, 3.2, 3.3_