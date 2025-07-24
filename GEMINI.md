# Gemini Project Guide: Leseohren DB

This document outlines the key principles, technologies, and coding standards for the Leseohren DB project.

## About the Project

This project is a website based on TYPO3. The core functionality is provided by a TYPO3 extension located in `packages/leseohren`, which serves as a database for entities like persons, companies, and events. The project also includes other extensions for specific functionalities and a Vite-based sitepackage for the frontend.

The development environment is managed by DDEV.

## Tech Stack

-   **Backend:** TYPO3 (latest LTS), PHP 8.2+
-   **Frontend:** Vite, SCSS, Bootstrap (latest), JavaScript
-   **Database:** MariaDB (via DDEV)
-   **Dependency Management:** Composer (PHP), npm/yarn (JS)
-   **Code Quality:** Rector for PHP refactoring.

## File Structure & Scope

-   **Primary focus:** All development work should be contained within the `packages/` directory.
-   **Main Extension:** `packages/leseohren/`
-   **Sitepackage:** `packages/skombase13/`
-   **Configuration:** TYPO3 configuration is located in `config/`.
-   **Do not modify files outside of the `packages` directory unless explicitly instructed.**

## Key Principles

-   **Plan First:** Always use sequential thinking to create a detailed plan before implementing changes.
-   **Concise & Technical:** Responses should be technical, accurate, and to the point.
-   **Modularity:** Prefer iteration and modularization over code duplication.
-   **Descriptive Naming:** Use clear and descriptive names for files, functions, and variables.
-   **Preserve Existing Code:** Do not remove or alter unrelated code or functionality.
-   **Compatibility:** Ensure all changes are compatible with the specified framework and language versions.
-   **Edge Cases & Assertions:** Actively consider and handle potential edge cases. Use assertions to validate assumptions.
-   **Security:** Always consider the security implications of any code change.

## PHP / TYPO3 Development

-   **Coding Standard:** Follow PSR-12 for all PHP code.
-   **Strict Typing:** Use `declare(strict_types=1);` in all PHP files.
-   **Documentation:** Provide DocBlocks for all classes, methods, and properties.
-   **Core APIs:** Utilize TYPO3 Core functions and APIs whenever possible.
-   **Database:** Use the Doctrine QueryBuilder for all database interactions. Do not write raw SQL queries.
-   **Extbase & Fluid:** Create plugins using the Extbase framework and the Fluid templating engine. For database records, create a corresponding domain model and repository.
-   **Configuration:** Use TypoScript for configuration.
-   **Internationalization:** Use TYPO3's XLIFF workflow for translations.
-   **Security:** Follow all TYPO3 Security guidelines, especially for data validation and sanitization.
-   **Logging:** Use TYPO3's logging features for debugging.

## Frontend Development (HTML/SCSS/Bootstrap)

-   **Styling:** Use SCSS for all styles.
-   **Naming Convention:** Use the BEM (Block Element Modifier) methodology for CSS class names.
-   **Specificity:** Use class selectors over ID selectors. Avoid using `!important`.
-   **HTML:** Write semantic HTML5 (e.g., `<header>`, `<main>`, `<section>`) to improve accessibility and SEO. Avoid deprecated elements.
-   **Bootstrap:**
    -   Leverage the Bootstrap grid system (`container`, `row`, `col`) for all layouts.
    -   Use Bootstrap components and utility classes extensively to maintain consistency and reduce custom CSS.
    -   Customize the theme by modifying Bootstrap's Sass variables, not by overriding CSS rules.

## Accessibility (A11y)

-   **Semantic HTML:** Use landmarks (e.g., `<nav>`, `<main>`) and semantic elements correctly.
-   **ARIA:** Use ARIA roles and attributes to enhance accessibility where native HTML is insufficient.
-   **Keyboard Navigation:** Ensure all interactive elements are fully navigable and operable via the keyboard.
-   **Focus States:** Provide clear and visible focus styles for all interactive elements.
-   **Color Contrast:** Ensure text has sufficient color contrast to be easily readable.
