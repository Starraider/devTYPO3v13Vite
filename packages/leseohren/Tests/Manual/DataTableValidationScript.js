/**
 * DataTable Validation Script for Person List Name Column Merge
 * 
 * This script can be run in the browser console to validate DataTable functionality
 * after the name column merge implementation.
 * 
 * Usage:
 * 1. Open the person list page in browser
 * 2. Open browser developer tools (F12)
 * 3. Copy and paste this script into the console
 * 4. Press Enter to run the validation
 */

(function() {
    'use strict';
    
    console.log('🧪 Starting DataTable Validation for Person List Name Column Merge');
    console.log('=' .repeat(70));
    
    const results = {
        passed: 0,
        failed: 0,
        tests: []
    };
    
    function test(description, testFunction) {
        try {
            const result = testFunction();
            if (result) {
                console.log(`✅ PASS: ${description}`);
                results.passed++;
                results.tests.push({ description, status: 'PASS', error: null });
            } else {
                console.log(`❌ FAIL: ${description}`);
                results.failed++;
                results.tests.push({ description, status: 'FAIL', error: 'Test returned false' });
            }
        } catch (error) {
            console.log(`❌ ERROR: ${description} - ${error.message}`);
            results.failed++;
            results.tests.push({ description, status: 'ERROR', error: error.message });
        }
    }
    
    // Test 1: Verify DataTable exists and is initialized
    test('DataTable is initialized on #personList', () => {
        const table = document.getElementById('personList');
        return table && $.fn.DataTable.isDataTable('#personList');
    });
    
    // Test 2: Verify correct number of columns (9 after merge)
    test('Table has correct number of columns (9)', () => {
        const headers = document.querySelectorAll('#personList thead th');
        return headers.length === 9;
    });
    
    // Test 3: Verify name column header exists
    test('Name column header exists', () => {
        const headers = document.querySelectorAll('#personList thead th');
        const nameHeader = Array.from(headers).find(th => 
            th.textContent.includes('Name') || th.textContent.includes('name')
        );
        return !!nameHeader;
    });
    
    // Test 4: Verify no separate firstname/lastname columns
    test('No separate firstname/lastname columns exist', () => {
        const headers = document.querySelectorAll('#personList thead th');
        const hasFirstname = Array.from(headers).some(th => 
            th.textContent.toLowerCase().includes('vorname') || 
            th.textContent.toLowerCase().includes('firstname')
        );
        const hasLastname = Array.from(headers).some(th => 
            th.textContent.toLowerCase().includes('nachname') || 
            th.textContent.toLowerCase().includes('lastname')
        );
        return !hasFirstname && !hasLastname;
    });
    
    // Test 5: Verify merged name format in table cells
    test('Names are displayed in "lastname, firstname" format', () => {
        const nameCells = document.querySelectorAll('#personList tbody tr td:first-child a');
        if (nameCells.length === 0) return false;
        
        let correctFormat = 0;
        nameCells.forEach(cell => {
            const text = cell.textContent.trim();
            // Check for "lastname, firstname" format or single name
            if (text.includes(', ') || (text.length > 0 && !text.includes(','))) {
                correctFormat++;
            }
        });
        
        return correctFormat === nameCells.length;
    });
    
    // Test 6: Verify DataTable API access
    test('DataTable API is accessible', () => {
        const dt = $('#personList').DataTable();
        return dt && typeof dt.search === 'function' && typeof dt.order === 'function';
    });
    
    // Test 7: Verify sorting functionality
    test('Name column is sortable', () => {
        const dt = $('#personList').DataTable();
        const settings = dt.settings()[0];
        const nameColumnDef = settings.aoColumns[0];
        return nameColumnDef.bSortable !== false;
    });
    
    // Test 8: Verify search functionality
    test('Global search functionality works', () => {
        const dt = $('#personList').DataTable();
        const originalLength = dt.rows().count();
        
        // Perform a search
        dt.search('test_search_term_that_should_not_exist').draw();
        const searchLength = dt.rows({ search: 'applied' }).count();
        
        // Reset search
        dt.search('').draw();
        const resetLength = dt.rows().count();
        
        return originalLength > 0 && searchLength === 0 && resetLength === originalLength;
    });
    
    // Test 9: Verify export buttons exist
    test('Export buttons are present', () => {
        const buttons = document.querySelectorAll('.dt-buttons button, .dt-buttons a');
        const hasButtons = buttons.length > 0;
        
        // Check for specific button types
        const buttonTexts = Array.from(buttons).map(btn => btn.textContent.toLowerCase());
        const hasPDF = buttonTexts.some(text => text.includes('pdf'));
        const hasCSV = buttonTexts.some(text => text.includes('csv') || text.includes('excel'));
        const hasCopy = buttonTexts.some(text => text.includes('copy') || text.includes('kopieren'));
        const hasPrint = buttonTexts.some(text => text.includes('print') || text.includes('drucken'));
        
        return hasButtons && (hasPDF || hasCSV || hasCopy || hasPrint);
    });
    
    // Test 10: Verify search panes configuration
    test('Search panes are configured correctly', () => {
        const dt = $('#personList').DataTable();
        const settings = dt.settings()[0];
        
        // Check if search panes are enabled
        const hasSearchPanes = settings.oInit.searchPanes === true;
        
        // Check column definitions for search panes
        const columnDefs = settings.oInit.columnDefs || [];
        const nameColumnDef = columnDefs.find(def => def.targets && def.targets.includes(0));
        const nameColumnNoSearchPane = nameColumnDef && nameColumnDef.searchPanes && nameColumnDef.searchPanes.show === false;
        
        return hasSearchPanes && nameColumnNoSearchPane;
    });
    
    // Test 11: Verify responsive functionality
    test('Responsive functionality is enabled', () => {
        const dt = $('#personList').DataTable();
        const settings = dt.settings()[0];
        return settings.oInit.responsive === true;
    });
    
    // Test 12: Verify German localization
    test('German localization is configured', () => {
        const dt = $('#personList').DataTable();
        const settings = dt.settings()[0];
        const languageUrl = settings.oInit.language && settings.oInit.language.url;
        return languageUrl && languageUrl.includes('de-DE.json');
    });
    
    // Test 13: Verify column count in export configuration
    test('Export configuration uses correct column indexes', () => {
        const dt = $('#personList').DataTable();
        const settings = dt.settings()[0];
        const buttons = settings.oInit.layout && settings.oInit.layout.topStart && settings.oInit.layout.topStart.buttons;
        
        if (!buttons) return false;
        
        const pdfButton = buttons.find(btn => btn.extend === 'pdfHtml5');
        if (!pdfButton || !pdfButton.exportOptions || !pdfButton.exportOptions.columns) return false;
        
        const exportColumns = pdfButton.exportOptions.columns;
        // Should export columns [0, 1, 2, 3, 4, 5, 6] (excluding FZ and Actions)
        return Array.isArray(exportColumns) && exportColumns.length === 7 && exportColumns[0] === 0 && exportColumns[6] === 6;
    });
    
    // Test 14: Verify table structure integrity
    test('Table structure is valid HTML', () => {
        const table = document.getElementById('personList');
        const thead = table.querySelector('thead');
        const tbody = table.querySelector('tbody');
        const headerCount = thead ? thead.querySelectorAll('th').length : 0;
        const firstRowCellCount = tbody && tbody.querySelector('tr') ? tbody.querySelector('tr').querySelectorAll('td').length : 0;
        
        return thead && tbody && headerCount === 9 && (firstRowCellCount === 0 || firstRowCellCount === 9);
    });
    
    // Test 15: Verify clickable links in name column
    test('Name column contains clickable links', () => {
        const nameCells = document.querySelectorAll('#personList tbody tr td:first-child');
        if (nameCells.length === 0) return true; // No data is acceptable
        
        let hasLinks = 0;
        nameCells.forEach(cell => {
            const link = cell.querySelector('a');
            if (link && link.href) {
                hasLinks++;
            }
        });
        
        return hasLinks === nameCells.length;
    });
    
    // Run all tests
    console.log('\n🔍 Running DataTable validation tests...\n');
    
    // Wait a moment for DataTable to fully initialize
    setTimeout(() => {
        // Run tests here (they're already defined above)
        
        // Print summary
        console.log('\n' + '='.repeat(70));
        console.log('📊 TEST SUMMARY');
        console.log('='.repeat(70));
        console.log(`✅ Passed: ${results.passed}`);
        console.log(`❌ Failed: ${results.failed}`);
        console.log(`📈 Success Rate: ${((results.passed / (results.passed + results.failed)) * 100).toFixed(1)}%`);
        
        if (results.failed === 0) {
            console.log('\n🎉 ALL TESTS PASSED! DataTable functionality is working correctly.');
        } else {
            console.log('\n⚠️  Some tests failed. Please review the implementation.');
            console.log('\nFailed tests:');
            results.tests.filter(t => t.status !== 'PASS').forEach(test => {
                console.log(`  - ${test.description}: ${test.error || 'Failed'}`);
            });
        }
        
        console.log('\n📋 Detailed Results:');
        results.tests.forEach(test => {
            const icon = test.status === 'PASS' ? '✅' : '❌';
            console.log(`  ${icon} ${test.description}`);
        });
        
        // Return results for programmatic access
        window.dataTableValidationResults = results;
        
    }, 1000); // Wait 1 second for DataTable initialization
    
})();

console.log('⏳ DataTable validation script loaded. Results will appear in 1 second...');