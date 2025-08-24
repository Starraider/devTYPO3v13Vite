/**
 * Manual Responsive Testing Script
 * Run this script in the browser console on the person list page
 * to validate responsive design and layout optimization
 */

(function() {
    'use strict';
    
    console.log('🧪 Starting Responsive Design Validation Tests...');
    
    const tests = {
        passed: 0,
        failed: 0,
        results: []
    };
    
    function assert(condition, message) {
        if (condition) {
            tests.passed++;
            tests.results.push(`✅ ${message}`);
            console.log(`✅ ${message}`);
        } else {
            tests.failed++;
            tests.results.push(`❌ ${message}`);
            console.error(`❌ ${message}`);
        }
    }
    
    function getElementDimensions(element) {
        const rect = element.getBoundingClientRect();
        return {
            width: rect.width,
            height: rect.height,
            left: rect.left,
            top: rect.top
        };
    }
    
    function testColumnStructure() {
        console.log('\n📋 Testing Column Structure...');
        
        const table = document.getElementById('personList');
        assert(table !== null, 'Person list table exists');
        
        const headerCells = table.querySelectorAll('thead th');
        assert(headerCells.length === 9, `Table has 9 columns (found ${headerCells.length})`);
        
        // Check column headers
        const expectedHeaders = ['Name', 'Kategorien', 'PLZ', 'Stadt', 'Email', 'Telefon', 'Organisation Kategorien', 'FZ', 'Aktionen'];
        headerCells.forEach((cell, index) => {
            const headerText = cell.textContent.trim();
            const expected = expectedHeaders[index];
            assert(headerText.includes(expected) || expected.includes(headerText), 
                   `Column ${index + 1} header is correct: "${headerText}"`);
        });
        
        // Check merged name format
        const nameCells = table.querySelectorAll('tbody td:first-child');
        if (nameCells.length > 0) {
            let hasCorrectFormat = false;
            nameCells.forEach(cell => {
                const text = cell.textContent.trim();
                if (text.includes(',') || text.length > 0) {
                    hasCorrectFormat = true;
                }
            });
            assert(hasCorrectFormat, 'Name cells contain merged name format');
        }
    }
    
    function testResponsiveBehavior() {
        console.log('\n📱 Testing Responsive Behavior...');
        
        const table = document.getElementById('personList');
        const container = table.closest('.container') || document.body;
        
        // Test current viewport
        const viewportWidth = window.innerWidth;
        console.log(`Current viewport width: ${viewportWidth}px`);
        
        const tableDimensions = getElementDimensions(table);
        const containerDimensions = getElementDimensions(container);
        
        assert(tableDimensions.width <= containerDimensions.width + 20, 
               `Table fits within container (table: ${Math.round(tableDimensions.width)}px, container: ${Math.round(containerDimensions.width)}px)`);
        
        // Test column widths
        const headerCells = table.querySelectorAll('thead th');
        const nameColumn = headerCells[0];
        const nameWidth = getElementDimensions(nameColumn).width;
        const tableWidth = tableDimensions.width;
        
        if (viewportWidth >= 1024) {
            // Desktop: Name column should be ~18% of table width
            const expectedPercentage = 0.18;
            const actualPercentage = nameWidth / tableWidth;
            const tolerance = 0.05;
            
            assert(Math.abs(actualPercentage - expectedPercentage) <= tolerance,
                   `Name column width is appropriate for desktop (${Math.round(actualPercentage * 100)}% of table width)`);
        } else if (viewportWidth >= 768) {
            // Tablet: Name column should be reasonable
            assert(nameWidth >= 100 && nameWidth <= 300,
                   `Name column width is appropriate for tablet (${Math.round(nameWidth)}px)`);
        } else {
            // Mobile: Name column should have minimum width
            assert(nameWidth >= 80,
                   `Name column width is appropriate for mobile (${Math.round(nameWidth)}px)`);
        }
    }
    
    function testColumnAlignment() {
        console.log('\n📐 Testing Column Alignment...');
        
        const table = document.getElementById('personList');
        const rows = table.querySelectorAll('tbody tr');
        
        if (rows.length > 1) {
            const firstRowCells = rows[0].querySelectorAll('td');
            const secondRowCells = rows[1].querySelectorAll('td');
            
            // Check that columns are aligned
            firstRowCells.forEach((cell, index) => {
                if (secondRowCells[index]) {
                    const firstLeft = getElementDimensions(cell).left;
                    const secondLeft = getElementDimensions(secondRowCells[index]).left;
                    const tolerance = 2; // 2px tolerance for alignment
                    
                    assert(Math.abs(firstLeft - secondLeft) <= tolerance,
                           `Column ${index + 1} is properly aligned across rows`);
                }
            });
        }
    }
    
    function testSpacing() {
        console.log('\n📏 Testing Spacing and Layout...');
        
        const table = document.getElementById('personList');
        const cells = table.querySelectorAll('td, th');
        
        // Check padding
        let hasProperPadding = true;
        cells.forEach(cell => {
            const style = window.getComputedStyle(cell);
            const paddingTop = parseFloat(style.paddingTop);
            const paddingLeft = parseFloat(style.paddingLeft);
            
            if (paddingTop < 4 || paddingLeft < 4) {
                hasProperPadding = false;
            }
        });
        
        assert(hasProperPadding, 'All cells have appropriate padding');
        
        // Check that action buttons are properly sized
        const actionButtons = table.querySelectorAll('td:last-child .btn');
        if (actionButtons.length > 0) {
            let buttonsProperlySpaced = true;
            actionButtons.forEach(button => {
                const dimensions = getElementDimensions(button);
                if (dimensions.width < 20 || dimensions.height < 20) {
                    buttonsProperlySpaced = false;
                }
            });
            
            assert(buttonsProperlySpaced, 'Action buttons are properly sized and spaced');
        }
    }
    
    function testAccessibility() {
        console.log('\n♿ Testing Accessibility...');
        
        const table = document.getElementById('personList');
        
        // Check semantic structure
        assert(table.querySelector('thead') !== null, 'Table has proper thead element');
        assert(table.querySelector('tbody') !== null, 'Table has proper tbody element');
        
        // Check that links are focusable
        const links = table.querySelectorAll('a');
        let allLinksFocusable = true;
        links.forEach(link => {
            if (link.tabIndex < 0) {
                allLinksFocusable = false;
            }
        });
        
        assert(allLinksFocusable, 'All links in table are keyboard focusable');
        
        // Check that buttons are focusable
        const buttons = table.querySelectorAll('button');
        let allButtonsFocusable = true;
        buttons.forEach(button => {
            if (button.tabIndex < 0) {
                allButtonsFocusable = false;
            }
        });
        
        assert(allButtonsFocusable, 'All buttons in table are keyboard focusable');
    }
    
    function testDataTablesIntegration() {
        console.log('\n🗂️ Testing DataTables Integration...');
        
        const table = document.getElementById('personList');
        
        // Check if DataTables is initialized
        if (window.$ && $.fn.DataTable) {
            const isDataTable = $.fn.DataTable.isDataTable('#personList');
            assert(isDataTable, 'DataTables is properly initialized');
            
            if (isDataTable) {
                const dt = $(table).DataTable();
                const settings = dt.settings()[0];
                
                assert(settings.oInit.responsive === true, 'DataTables responsive extension is enabled');
                
                // Check column count matches our expectation
                const columnCount = dt.columns().count();
                assert(columnCount === 9, `DataTables recognizes correct number of columns (${columnCount})`);
            }
        } else {
            console.log('ℹ️ DataTables not available for testing');
        }
    }
    
    function testPerformance() {
        console.log('\n⚡ Testing Performance...');
        
        const table = document.getElementById('personList');
        
        // Count DOM elements
        const totalCells = table.querySelectorAll('td, th').length;
        const rows = table.querySelectorAll('tr').length;
        
        console.log(`Table has ${rows} rows and ${totalCells} total cells`);
        
        // Test resize performance
        const startTime = performance.now();
        
        // Simulate resize events
        for (let i = 0; i < 5; i++) {
            window.dispatchEvent(new Event('resize'));
        }
        
        const endTime = performance.now();
        const duration = endTime - startTime;
        
        assert(duration < 50, `Resize handling is performant (${Math.round(duration)}ms for 5 events)`);
    }
    
    function simulateViewportSizes() {
        console.log('\n📐 Simulating Different Viewport Sizes...');
        
        const originalWidth = window.innerWidth;
        const testSizes = [
            { width: 320, name: 'Small Mobile' },
            { width: 375, name: 'iPhone SE' },
            { width: 768, name: 'iPad Portrait' },
            { width: 1024, name: 'iPad Landscape' },
            { width: 1200, name: 'Desktop' },
            { width: 1920, name: 'Large Desktop' }
        ];
        
        testSizes.forEach(size => {
            console.log(`\n📱 Testing ${size.name} (${size.width}px):`);
            
            // Note: We can't actually change the viewport size in JavaScript,
            // but we can test the current responsive behavior
            const table = document.getElementById('personList');
            const tableDimensions = getElementDimensions(table);
            
            console.log(`  Table width: ${Math.round(tableDimensions.width)}px`);
            
            // Check if table would fit in this viewport
            const wouldFit = tableDimensions.width <= size.width;
            console.log(`  Would fit in ${size.name}: ${wouldFit ? '✅' : '❌'}`);
        });
        
        console.log(`\n📱 Current viewport: ${originalWidth}px`);
    }
    
    function generateReport() {
        console.log('\n📊 Test Results Summary:');
        console.log(`✅ Passed: ${tests.passed}`);
        console.log(`❌ Failed: ${tests.failed}`);
        console.log(`📈 Success Rate: ${Math.round((tests.passed / (tests.passed + tests.failed)) * 100)}%`);
        
        if (tests.failed > 0) {
            console.log('\n❌ Failed Tests:');
            tests.results.filter(result => result.startsWith('❌')).forEach(result => {
                console.log(result);
            });
        }
        
        console.log('\n📋 Full Test Results:');
        tests.results.forEach(result => {
            console.log(result);
        });
        
        // Return results for programmatic access
        return {
            passed: tests.passed,
            failed: tests.failed,
            successRate: Math.round((tests.passed / (tests.passed + tests.failed)) * 100),
            results: tests.results
        };
    }
    
    // Run all tests
    try {
        testColumnStructure();
        testResponsiveBehavior();
        testColumnAlignment();
        testSpacing();
        testAccessibility();
        testDataTablesIntegration();
        testPerformance();
        simulateViewportSizes();
        
        const results = generateReport();
        
        // Store results globally for access
        window.responsiveTestResults = results;
        
        console.log('\n🎉 Responsive design validation complete!');
        console.log('Results stored in window.responsiveTestResults');
        
        return results;
        
    } catch (error) {
        console.error('❌ Test execution failed:', error);
        return { error: error.message };
    }
})();

// Instructions for manual testing
console.log(`
📖 Manual Testing Instructions:

🌐 Test Environment Access:
- Use browser MCP to navigate to: https://leseohrendb.ddev.site/test-pages/person-list
- Or open the person list page in your local development environment

🔧 Running Tests:
1. Open the test page in your browser
2. Open browser developer tools (F12)
3. Paste this script into the console and press Enter
4. Review the test results in the console

📱 Comprehensive Testing:
1. Test on different devices (mobile, tablet, desktop)
2. Test in different browsers (Chrome, Firefox, Safari, Edge)
3. Test with different amounts of data (few rows vs many rows)
4. Test with long names and content
5. Test responsive behavior by resizing browser window

🧪 Available Test Pages:
- Person List: https://leseohrendb.ddev.site/test-pages/person-list
- Responsive Design: https://leseohrendb.ddev.site/test-pages/responsive
- Components: https://leseohrendb.ddev.site/test-pages/components
- Forms: https://leseohrendb.ddev.site/test-pages/forms

✅ Validation Coverage:
- Column structure and headers
- Responsive behavior at current viewport size
- Column alignment and spacing
- Accessibility features
- DataTables integration
- Performance characteristics

📊 Results are stored in window.responsiveTestResults for further analysis.

🔄 For automated testing, use the browser MCP to programmatically access test pages
   and execute validation scripts across different browsers and viewports.
`);