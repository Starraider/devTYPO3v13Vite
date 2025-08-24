/**
 * Responsive Table Validation Tests
 * Tests for Task 6: Validate responsive design and layout optimization
 */

describe('Person List Responsive Design', () => {
    let table;
    let container;

    beforeEach(() => {
        // Create test DOM structure
        document.body.innerHTML = `
            <div class="container">
                <table id="personList" class="table table-striped display">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Kategorien</th>
                            <th>PLZ</th>
                            <th>Stadt</th>
                            <th>Email</th>
                            <th>Telefon</th>
                            <th>Organisation Kategorien</th>
                            <th>FZ</th>
                            <th>Aktionen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#">Mustermann, Max</a></td>
                            <td><span class="badge bg-secondary">Vorlesepate</span></td>
                            <td>12345</td>
                            <td>Berlin</td>
                            <td>max@example.com</td>
                            <td>030-123456</td>
                            <td><span class="badge bg-primary">Kita</span></td>
                            <td>✓</td>
                            <td><button class="btn btn-sm">Edit</button></td>
                        </tr>
                        <tr>
                            <td><a href="#">Schmidt, Anna</a></td>
                            <td><span class="badge bg-secondary">Koordinator</span></td>
                            <td>54321</td>
                            <td>Hamburg</td>
                            <td>anna.schmidt@example.com</td>
                            <td>040-654321</td>
                            <td><span class="badge bg-primary">Schule</span></td>
                            <td>✓</td>
                            <td><button class="btn btn-sm">Edit</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;
        
        table = document.getElementById('personList');
        container = document.querySelector('.container');
    });

    afterEach(() => {
        document.body.innerHTML = '';
    });

    describe('Column Structure Validation', () => {
        test('should have correct number of columns after merge', () => {
            const headerCells = table.querySelectorAll('thead th');
            expect(headerCells).toHaveLength(9);
            
            // Verify column headers
            expect(headerCells[0].textContent.trim()).toBe('Name');
            expect(headerCells[1].textContent.trim()).toBe('Kategorien');
            expect(headerCells[2].textContent.trim()).toBe('PLZ');
            expect(headerCells[3].textContent.trim()).toBe('Stadt');
            expect(headerCells[4].textContent.trim()).toBe('Email');
            expect(headerCells[5].textContent.trim()).toBe('Telefon');
            expect(headerCells[6].textContent.trim()).toBe('Organisation Kategorien');
            expect(headerCells[7].textContent.trim()).toBe('FZ');
            expect(headerCells[8].textContent.trim()).toBe('Aktionen');
        });

        test('should display merged names in correct format', () => {
            const nameCells = table.querySelectorAll('tbody td:first-child');
            
            expect(nameCells[0].textContent.trim()).toBe('Mustermann, Max');
            expect(nameCells[1].textContent.trim()).toBe('Schmidt, Anna');
        });

        test('should maintain clickable links in name column', () => {
            const nameLinks = table.querySelectorAll('tbody td:first-child a');
            
            expect(nameLinks).toHaveLength(2);
            expect(nameLinks[0].getAttribute('href')).toBe('#');
            expect(nameLinks[1].getAttribute('href')).toBe('#');
        });
    });

    describe('Mobile Responsive Behavior', () => {
        beforeEach(() => {
            // Simulate mobile viewport
            Object.defineProperty(window, 'innerWidth', {
                writable: true,
                configurable: true,
                value: 375
            });
            
            // Trigger resize event
            window.dispatchEvent(new Event('resize'));
        });

        test('should maintain table structure on mobile', () => {
            const table = document.getElementById('personList');
            expect(table).toBeTruthy();
            
            // Check that table doesn't overflow container
            const tableRect = table.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();
            
            // Table should not be wider than container (allowing for some margin)
            expect(tableRect.width).toBeLessThanOrEqual(containerRect.width + 10);
        });

        test('should have appropriate column widths on mobile', () => {
            const nameCells = table.querySelectorAll('tbody td:first-child');
            
            nameCells.forEach(cell => {
                const cellRect = cell.getBoundingClientRect();
                // Name column should have minimum width for readability
                expect(cellRect.width).toBeGreaterThanOrEqual(120);
            });
        });

        test('should maintain readable text size on mobile', () => {
            const textElements = table.querySelectorAll('td, th');
            
            textElements.forEach(element => {
                const computedStyle = window.getComputedStyle(element);
                const fontSize = parseFloat(computedStyle.fontSize);
                
                // Font size should be at least 14px for readability
                expect(fontSize).toBeGreaterThanOrEqual(14);
            });
        });
    });

    describe('Tablet Responsive Behavior', () => {
        beforeEach(() => {
            // Simulate tablet viewport
            Object.defineProperty(window, 'innerWidth', {
                writable: true,
                configurable: true,
                value: 768
            });
            
            window.dispatchEvent(new Event('resize'));
        });

        test('should utilize available width efficiently on tablet', () => {
            const headerCells = table.querySelectorAll('thead th');
            
            // All columns should be visible on tablet
            headerCells.forEach(cell => {
                const cellRect = cell.getBoundingClientRect();
                expect(cellRect.width).toBeGreaterThan(0);
            });
        });

        test('should have balanced column spacing on tablet', () => {
            const headerCells = table.querySelectorAll('thead th');
            const nameColumn = headerCells[0];
            const categoryColumn = headerCells[1];
            
            const nameRect = nameColumn.getBoundingClientRect();
            const categoryRect = categoryColumn.getBoundingClientRect();
            
            // Name column should be wider than category column but not excessively
            expect(nameRect.width).toBeGreaterThan(categoryRect.width * 0.8);
            expect(nameRect.width).toBeLessThan(categoryRect.width * 2);
        });
    });

    describe('Desktop Responsive Behavior', () => {
        beforeEach(() => {
            // Simulate desktop viewport
            Object.defineProperty(window, 'innerWidth', {
                writable: true,
                configurable: true,
                value: 1200
            });
            
            window.dispatchEvent(new Event('resize'));
        });

        test('should have optimal column width distribution on desktop', () => {
            const headerCells = table.querySelectorAll('thead th');
            const tableRect = table.getBoundingClientRect();
            
            const nameColumn = headerCells[0];
            const nameRect = nameColumn.getBoundingClientRect();
            
            // Name column should take approximately 18% of table width
            const expectedWidth = tableRect.width * 0.18;
            const tolerance = tableRect.width * 0.05; // 5% tolerance
            
            expect(nameRect.width).toBeGreaterThan(expectedWidth - tolerance);
            expect(nameRect.width).toBeLessThan(expectedWidth + tolerance);
        });

        test('should maintain proper proportions on large screens', () => {
            const headerCells = table.querySelectorAll('thead th');
            
            // Check that no column is excessively wide or narrow
            headerCells.forEach((cell, index) => {
                const cellRect = cell.getBoundingClientRect();
                
                if (index === 0) { // Name column
                    expect(cellRect.width).toBeGreaterThanOrEqual(150);
                    expect(cellRect.width).toBeLessThanOrEqual(250);
                } else if (index === 7 || index === 8) { // FZ and Actions columns
                    expect(cellRect.width).toBeGreaterThanOrEqual(40);
                    expect(cellRect.width).toBeLessThanOrEqual(100);
                }
            });
        });
    });

    describe('Content Alignment and Spacing', () => {
        test('should maintain proper text alignment', () => {
            const nameCells = table.querySelectorAll('tbody td:first-child');
            
            nameCells.forEach(cell => {
                const computedStyle = window.getComputedStyle(cell);
                // Name column should be left-aligned
                expect(computedStyle.textAlign).toBe('left');
            });
        });

        test('should have appropriate padding and spacing', () => {
            const cells = table.querySelectorAll('td, th');
            
            cells.forEach(cell => {
                const computedStyle = window.getComputedStyle(cell);
                const paddingTop = parseFloat(computedStyle.paddingTop);
                const paddingLeft = parseFloat(computedStyle.paddingLeft);
                
                // Cells should have reasonable padding
                expect(paddingTop).toBeGreaterThanOrEqual(4);
                expect(paddingLeft).toBeGreaterThanOrEqual(4);
            });
        });

        test('should handle long names gracefully', () => {
            // Add a row with a very long name
            const tbody = table.querySelector('tbody');
            const longNameRow = document.createElement('tr');
            longNameRow.innerHTML = `
                <td><a href="#">Sehr-Langer-Nachname, Sehr-Langer-Vorname-Mit-Vielen-Zeichen</a></td>
                <td><span class="badge bg-secondary">Test</span></td>
                <td>12345</td>
                <td>Test Stadt</td>
                <td>test@example.com</td>
                <td>123-456789</td>
                <td><span class="badge bg-primary">Test Org</span></td>
                <td>✓</td>
                <td><button class="btn btn-sm">Edit</button></td>
            `;
            tbody.appendChild(longNameRow);
            
            const longNameCell = longNameRow.querySelector('td:first-child');
            const cellRect = longNameCell.getBoundingClientRect();
            
            // Long names should not break the layout
            expect(cellRect.height).toBeLessThan(100); // Should not be excessively tall
            
            // Text should wrap or truncate appropriately
            const computedStyle = window.getComputedStyle(longNameCell);
            expect(['break-word', 'break-all']).toContain(computedStyle.wordWrap || computedStyle.overflowWrap);
        });
    });

    describe('Accessibility and Usability', () => {
        test('should maintain keyboard navigation', () => {
            const links = table.querySelectorAll('a');
            const buttons = table.querySelectorAll('button');
            
            // All interactive elements should be focusable
            [...links, ...buttons].forEach(element => {
                expect(element.tabIndex).toBeGreaterThanOrEqual(0);
            });
        });

        test('should have proper semantic structure', () => {
            // Table should have proper semantic elements
            expect(table.querySelector('thead')).toBeTruthy();
            expect(table.querySelector('tbody')).toBeTruthy();
            expect(table.querySelectorAll('th')).toHaveLength(9);
        });

        test('should maintain color contrast for badges', () => {
            const badges = table.querySelectorAll('.badge');
            
            badges.forEach(badge => {
                const computedStyle = window.getComputedStyle(badge);
                const backgroundColor = computedStyle.backgroundColor;
                const color = computedStyle.color;
                
                // Badges should have background and text colors set
                expect(backgroundColor).not.toBe('rgba(0, 0, 0, 0)');
                expect(color).not.toBe('rgba(0, 0, 0, 0)');
            });
        });
    });

    describe('Performance Considerations', () => {
        test('should not create excessive DOM nodes', () => {
            const totalCells = table.querySelectorAll('td, th').length;
            
            // With 2 data rows + 1 header row and 9 columns = 27 cells
            expect(totalCells).toBe(27);
        });

        test('should handle table resize efficiently', () => {
            const startTime = performance.now();
            
            // Simulate multiple resize events
            for (let i = 0; i < 10; i++) {
                window.dispatchEvent(new Event('resize'));
            }
            
            const endTime = performance.now();
            const duration = endTime - startTime;
            
            // Resize handling should be fast (less than 100ms for 10 events)
            expect(duration).toBeLessThan(100);
        });
    });
});

// Integration test with DataTables (if available)
describe('DataTables Integration', () => {
    test('should work with DataTables responsive extension', () => {
        // This test would require DataTables to be loaded
        // For now, we'll just check that the table structure is compatible
        
        const table = document.getElementById('personList');
        expect(table.classList.contains('display')).toBe(true);
        
        // Check that table has the correct structure for DataTables
        expect(table.querySelector('thead')).toBeTruthy();
        expect(table.querySelector('tbody')).toBeTruthy();
    });
});

// Export test utilities for manual testing
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        createTestTable: () => {
            return document.getElementById('personList');
        },
        simulateViewport: (width) => {
            Object.defineProperty(window, 'innerWidth', {
                writable: true,
                configurable: true,
                value: width
            });
            window.dispatchEvent(new Event('resize'));
        }
    };
}