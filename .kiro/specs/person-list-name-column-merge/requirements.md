# Requirements Document

## Introduction

This feature improves the person list view by merging the separate "Last name" and "First name" columns into a single "Name" column. This consolidation will provide a cleaner, more compact table layout while maintaining all necessary information and functionality. The merged column will display names in the format "Last name, First name" which is a common and professional presentation format.

## Requirements

### Requirement 1

**User Story:** As a system administrator, I want to see volunteer names in a single consolidated column in the person list, so that the table is more compact and easier to scan.

#### Acceptance Criteria

1. WHEN viewing the person list THEN the system SHALL display a single "Name" column instead of separate "Last name" and "First name" columns
2. WHEN displaying names in the merged column THEN the system SHALL format them as "Last name, First name"
3. WHEN a person has both first name and last name THEN the system SHALL display them separated by a comma and space
4. WHEN a person has only a last name THEN the system SHALL display only the last name without a comma
5. WHEN a person has only a first name THEN the system SHALL display only the first name without a comma
6. WHEN clicking on a name in the merged column THEN the system SHALL navigate to the person's detail page

### Requirement 2

**User Story:** As a system administrator, I want the merged name column to maintain all existing functionality, so that I can still access person details and perform actions without any loss of features.

#### Acceptance Criteria

1. WHEN clicking on any part of the name text THEN the system SHALL navigate to the person's show page
2. WHEN the table is sorted by the name column THEN the system SHALL sort alphabetically by last name first, then by first name
3. WHEN searching in the DataTable THEN the system SHALL search both first name and last name content within the merged column
4. WHEN the name is too long for the column width THEN the system SHALL handle text overflow appropriately
5. WHEN the table is responsive on mobile devices THEN the merged name column SHALL display properly
6. WHEN the firstname column is removed THEN the system SHALL remove any firstname-specific filtering or search functionality

### Requirement 3

**User Story:** As a system administrator, I want the table layout to be optimized after merging the name columns, so that the remaining columns have better spacing and the overall table is more readable.

#### Acceptance Criteria

1. WHEN the name columns are merged THEN the system SHALL redistribute the available table width among remaining columns
2. WHEN viewing the table on different screen sizes THEN the system SHALL maintain responsive behavior
3. WHEN the table contains many rows THEN the system SHALL maintain consistent column alignment
4. WHEN printing the table THEN the merged name column SHALL display properly in print format
5. WHEN exporting table data THEN the merged name format SHALL be preserved in exports
6. WHEN DataTable filtering is applied THEN the system SHALL remove firstname-specific filter options and adjust remaining filters accordingly

### Requirement 4

**User Story:** As a system administrator, I want any DataTable filtering and search functionality to be properly adjusted after removing the firstname column, so that the table filtering remains functional and intuitive.

#### Acceptance Criteria

1. WHEN the firstname column is removed THEN the system SHALL remove any column-specific filters for firstname
2. WHEN the lastname column is converted to a merged name column THEN the system SHALL remove any column-specific filters for lastname
3. WHEN the merged name column is created THEN the system SHALL NOT provide individual column filtering for the name column
4. WHEN DataTable configuration references firstname or lastname columns THEN the system SHALL update all references to account for the merged column
5. WHEN JavaScript DataTable initialization occurs THEN the system SHALL adjust column indexes and configurations to account for the removed firstname column
6. WHEN global DataTable search is used THEN the system SHALL still search the merged name column content for both firstname and lastname

### Requirement 5

**User Story:** As a system administrator, I want the column header to be properly localized, so that the interface remains consistent with the application's internationalization standards.

#### Acceptance Criteria

1. WHEN viewing the person list THEN the system SHALL display a localized header for the merged name column
2. WHEN the system language is German THEN the column header SHALL display "Name"
3. WHEN the system language is English THEN the column header SHALL display "Name"
4. WHEN adding new language translations THEN the system SHALL support localized column headers
5. WHEN the column header is clicked for sorting THEN the system SHALL provide appropriate visual feedback